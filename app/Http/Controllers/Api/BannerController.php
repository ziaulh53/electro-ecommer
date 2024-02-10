<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function index(){
        $banners = Banner::all();
        return response(['banners'=>$banners]);
    }

    public function store(Request $request){
        $data = $request->validate([
            'imgUrl' => ['required', 'url']
        ]);
    
        Banner::create($data);
        return response(['success'=>true, 'msg'=>'Banner Image Updated']);
    }

    public function destroy(Request $request, string $id){
        $banner = Banner::find($id);
        if(!isset($banner)) return response(['success'=>false, 'msg'=>'Not Found']);
        $banner->delete();
        return response(['success'=>true, 'msg'=>'Deleted Successfully']);
    }
}
