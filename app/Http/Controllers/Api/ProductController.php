<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductCreateRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $product = Product::with(['colors', 'category'])->get();
        return response(['product'=>$product]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductCreateRequest $request)
    {
        $data = $request->validated();
        $product = Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'discountPrice' => $request->discountPrice,
            'discountAvailable' => $request->discountAvailable,
            'newArrival' => $request->newArrival,
            'description' => $request->description,
            'brands_id' => $request->brands_id,
            'category_id' => $request->category_id,
        ]);
        foreach ($request->colors as $color) {
            $product->colors()->attach($color['color_id'], [
                'quantity' => $color['quantity'],
                'images' => json_encode($color['images']),
            ]);
        }
        return response(['success' => true, 'msg' => 'Product added.']);
    }

    public function show(Request $request, string $id)
    {
        $product = Product::with(['colors','brand', 'category'])->find($id);
        return response(['success' => true, 'result' => $product]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    public function getNewArrival (){
        $product = Product::query()->where('newArrival', true)->with('colors')->get();
        return response(['success' => true, 'product' => $product]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);
        $product->delete();
        return response(['success' => true, 'msg' => 'Deleted Successully.']);
    }
}
