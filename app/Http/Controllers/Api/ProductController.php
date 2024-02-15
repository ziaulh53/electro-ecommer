<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductCreateRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $query = Product::with(['colors', 'category']);
        if ($request->has('category') && !empty($request->category)) {
            $categoryId = $request->get('category');
            $query->where('category_id', $categoryId);
        }
        $product = $query->paginate(15);
        return response([
            'product' => $product,
        ]);
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
            'quantity' => $request->quantity,
            'is_variation' => $request->is_variation,
            'discountPrice' => $request->discountPrice,
            'default_images' => json_encode($request->default_images),
            'discountAvailable' => $request->discountAvailable,
            'newArrival' => $request->newArrival,
            'description' => $request->description,
            'brands_id' => $request->brands_id,
            'category_id' => $request->category_id,
        ]);
        foreach ($request->colors as $color) {
            $product->colors()->attach($color['color_id'], [
                'quantity' => $color['quantity'],
                // 'images' => json_encode($color['images']),
            ]);
        }
        return response(['success' => true, 'msg' => 'Product added.']);
    }

    public function show(Request $request, string $id)
    {
        $product = Product::with(['colors', 'brand', 'category'])->find($id);
        return response(['success' => true, 'result' => $product]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductUpdateRequest $request, string $id)
    {
        $product = Product::with(['colors'])->findOrFail($id);

        $data = $request->validated();

        $product->update($data);

        $attachedColors = [];
        foreach ($request->colors as $color) {
            $colorId = $color['color_id'] ?? null; 

            if (!empty($colorId)) {
                $product->colors()->updateExistingPivot($colorId, [
                    'quantity' => $color['quantity'],
                    // 'images' => json_encode($color['images']),
                ]);
                $attachedColors[] = $colorId;
            } else {
                $product->colors()->attach($color['color_id'], [
                    'quantity' => $color['quantity'],
                    // 'images' => json_encode($color['images']),
                ]);
            }
        }

        $detachedColors = array_diff($product->colors->pluck('id')->toArray(), $attachedColors);
        $product->colors()->detach($detachedColors);
        return response(['success' => true, 'msg' => 'Product updated.']);
    }

    public function getProductsByCategory(Request $request, string $id)
    {
        $products = Product::query()
            ->where('category_id', $id)
            ->with(['colors'])
            ->get();
        $category = Category::find($id);
        if ($request->has('brands') && !empty($request->brands)) {
            $brands = $request->brands;
            $products = $products->filter(function ($product) use ($brands) {
                return in_array($product->brands_id, $brands);
            });
        }

        return response()->json([
            'success' => true,
            'product' => $products,
            'category' => $category,
        ]);
    }


    public function getSuggestion(Request $request, ){
        $category_id = $request['categoryId'];
        $product_id = $request['productId'];
        $product = Product::query()->where('category_id', $category_id)->where('id', '!=', $product_id)->with('colors')->get();
        return response(['success'=>true, 'product'=>$product]);
    }


    public function getProdcutsByBrand(Request $request, string $id){
        $products = Product::query()->where('brands_id', $id)->with('colors')->get();
        return response(['success'=>false, 'product'=>$products]);
    }

    public function getNewArrival()
    {
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
