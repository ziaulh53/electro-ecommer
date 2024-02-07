<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function getUsers(){
        $user = User::query()->orderBy('id', 'desc')->paginate(10);
        return response(['success'=>true, 'users'=>$user]);
    }
}
