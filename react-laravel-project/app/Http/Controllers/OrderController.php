<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItems;
use App\Http\Requests\OrderRequest;
use App\Http\Resources\OrderResource;


class OrderController extends Controller
{

    public function index()
    {
        return OrderResource::collection(Order::all());
    }

    public function store(OrderRequest $request)
    {
    $order = Order::create($request->validated());
    $orderItems = OrderItems::where('order_id', $order->id)->get();
    $total = $orderItems->sum('price');
    $order->update(['total' => $total]);
    return new OrderResource($order);
    }

    public function show($id_ord)
    {
        if(!$id_ord){
        $ord = Order::where("customer_id", auth()->user()->id)->get();
        if (!$ord) {
            return response()->json(['data' => ""], 404);
        }
        OrderResource::make($ord);
        return $ord;
    } else {
        $ord = Order::where("id", $id_ord)->first();
		OrderResource::make($ord);
		return $ord;
    }
    }

    public function update(OrderRequest $request, Order $order)
    {
        $order->update($request->validated());
        return new OrderResource($order);
    }

    public function destroy(Order $order)
    {
        OrderItems::where('order_id', $order->id)->delete();
        $order->delete();
        return response()->noContent();
    }
}