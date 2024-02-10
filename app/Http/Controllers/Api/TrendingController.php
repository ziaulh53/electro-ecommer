<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Trending;
use Illuminate\Http\Request;

class TrendingController extends Controller
{
    public function index (){
        $trending = Trending::with('product.colors')->get();
        return response(['success'=>true, 'trendings'=>$trending]);
    }
    public function store(Request $request)
    {
        $trending = Trending::create($request->only('product_id'));
        return response()->json($trending, 201);
    }

    public function destroy($id)
    {
        $trending = Trending::where('product_id', $id)->first();

        if ($trending) {
            $trending->delete();
            return response()->json(['success'=>true,'msg' => 'Product removed from trending list'], 200);
        } else {
            return response()->json(['success'=>false,'msg' => 'Product not found in trending list'], 404);
        }
    }
}
