<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderItemRequest;
use App\Http\Resources\OrderItemResource;
use App\Models\OrderItems;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    public function index()
    {
        $orderItems = OrderItems::all();
        return OrderItemResource::collection($orderItems);
    }

    public function store(OrderItemRequest $ord_i) {
        $product = Product::where("id", $ord_i->product_id)->first();
        if ($ord_i->item_quantity > $product->stock){
            return response()->json('На складе нет такого количества товара. Доступно только ' . $product->stock . ' единиц товара.');
        }
        if ($ord_i->item_quantity > Product::where("id", $ord_i->product_id)->first()->stock){
            return response()->json('На складе нет такого количества товара');}
        $ord = OrderItems::where("product_id", $ord_i->product_id)->where("order_id", $ord_i->order_id)->first();
        if ($ord) {
            $product = Product::find($ord_i->product_id);
            $ord->update(['item_quantity' => $ord->item_quantity + $ord_i->item_quantity]);
            $ord->update(['price' => $ord->price + ($ord_i->item_quantity * $product->price)]);
        } else {
            $product = Product::find($ord_i->product_id);
            $ord = OrderItems::create([
            'order_id' => $ord_i->order_id,
            'product_id' => $ord_i->product_id,
            'item_quantity' => $ord_i->item_quantity,
            'price' => $ord_i->item_quantity * $product->price,
            ]);
            
        }
        $order = Order::find($ord_i->order_id);
        $orderItems = OrderItems::where('order_id', $order->id)->get();
        $total = $orderItems->sum('price');
        $order->update(['total' => $total]);
        $pr = Product::where("id", $ord_i->product_id)->first();
        $pr->update(['stock' => $pr->stock - $ord_i->item_quantity]);
        return response()->json('Товар добавлен');
    }

    public function show($id)
    {
        $orderItem = OrderItems::where("id", $id)->first();
        OrderItemResource::make($orderItem);
        return new OrderItemResource($orderItem);
    
    }

    public function update(OrderItemRequest $request, $id)
    {
    $orderItem = OrderItems::find($id);
    $product = Product::where("id", $orderItem->product_id)->first();
    if ($request->item_quantity != $orderItem->item_quantity) {
        if ($request->item_quantity > $product->stock + $orderItem->item_quantity) {
            return response()->json(['data' => 'На складе нет такого количества товара'], 400);
        }
        $product->update(['stock' => $product->stock + $orderItem->item_quantity - $request->item_quantity]);
    }
    $orderItem->update(array_merge($request->validated(), ['price' => $product->price * $request->item_quantity]));
    $order = Order::find($orderItem->order_id);
    $orderItems = OrderItems::where('order_id', $order->id)->get();
    $total = $orderItems->sum('price');
    $order->update(['total' => $total]);
    return new OrderItemResource($orderItem);
}
    public function destroy(OrderItemRequest $request, $id)
    {
        $orderItem = OrderItems::find($id);
        if (!$orderItem) {
            return response()->json(['message' => 'Товар в заказе не найден'], 404);
        }
        $product = Product::where("id", $orderItem->product_id)->first();
        $orderItem->update(array_merge($request->validated(), ['price' => $product->price * $request->item_quantity]));
        $order = Order::find($orderItem->order_id);
        $orderItem->delete();
        $orderItems = OrderItems::where('order_id', $order->id)->get();
        $total_del = $orderItems->sum('price');
        $total_old = $order->total;
        $order->update(['total' => $total_old + ($total_del - $total_old)]);
        return response()->json(null, 204);
    }
}