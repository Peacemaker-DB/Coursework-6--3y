<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\OrderItems;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\File;

class ProductsController extends Controller
{
    public function index()
	{
		return ProductResource::collection(Product::all());
	}
	public function show($id_pr)
	{
		$product = Product::where("id", $id_pr)->first();
		ProductResource::make($product);
		return $product;
	}
	public function store(ProductRequest $product)
	{
        
		$filename = NULL;
        $path = NULL;
		if($product->has('image')){

            
            $file = $product->file('image');
            $extension = $file->getClientOriginalExtension();

            $filename = time().'.'.$extension;
           
            $path = 'uploads/category/';
            
            $file->move($path, $filename);
        }
        $product = Product::create($product->validated() + ["image" => $path.$filename]);
        return response()->json($product, 201);
	}
	public function update(ProductRequest $request, Product $product)
	{
		if($request->has('image') && $request->get('image') != ''){

            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();

            $filename = time().'.'.$extension;

            $path = 'uploads/category/';
            $file->move($path, $filename);

            if(File::exists($product->image)){
                File::delete($product->image);
            }

            $product->update($request->validated() + ['image' => $path.$filename]);
        } else {
        $product->update($request->validated() ); }
        return ProductResource::make($product);
	}
	public function destroy(Product $product)
	{
        OrderItems::where('product_id', $product->id)->delete();
		if(File::exists($product->image)){
            File::delete($product->image);
        }
        $product->delete();
        return response()->noContent();
	}

}
