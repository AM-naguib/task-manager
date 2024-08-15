<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(){
        $users = User::get();
        $roless = Role::get();
        
        return view("pages.users.index",compact("users","roless"));
    }
}
