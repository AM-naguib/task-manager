<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(){

        return response()->json(["users" => User::all(), "roles" => Role::all()], 200);
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            "name"=>["required"],
            "email"=>["required","unique:users,email","email"],
            "username"=>["required","unique:users,username"],
            "password"=>["required"],
            "role_id"=>["required","exists:roles,id"],
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 401);
        }

        try{
            $data = $validator->validated();
            $data["password"] = bcrypt($data["password"]);
            $user = User::create($data);
            $role = Role::find($request["role_id"]);
            $user->assignRole([$role->id]);
            return response()->json(["message" => "User Created", "user" => $user, "role" => $role], 201);

        }catch(\Exception $e){
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }


    public function show(User $user)
{
    $roles = $user->getRoleNames();

    return response()->json([
        "user" => $user->only(['id', 'name', 'email', 'username', 'email_verified_at', 'created_at', 'updated_at']),
        "roles" => $roles
    ], 200);
}


    public function update(Request $request, User $user) {
        $validator = Validator::make($request->all(), [
            "name" => ["required"],
            "email" => "required|email|unique:users,email," . $user->id,
            "username" => "required|unique:users,username," . $user->id,
            "password" => ["nullable"],
            "role_id" => ["required", "exists:roles,id"],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 401);
        }

        try {
            $data = $validator->validated();
            if (isset($data["password"]) && !empty($data["password"])) {
                $data["password"] = bcrypt($data["password"]);
            } else {
                unset($data["password"]);
            }
            $user->update($data);
            $role = Role::find($request["role_id"]);
            $user->assignRole([$role->id]);
            return response()->json(["message" => "User Updated", "user" => $user, "role" => $role], 200);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }

    public function destroy($id){
        try{
            User::find($id)->delete();
            return response()->json(["message" => "User Deleted"], 200);
        }catch(\Exception $e){
            return response()->json(["message" => $e->getMessage()], 500);
        }

    }
}
