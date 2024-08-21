<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::get();
        return view("pages.permissions.index", compact("permissions"));
    }


    public function store(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 401);
        }
        $crudNamed = ["list", "create", "edit", "delete"];
        if ($request->crud == "on") {
            foreach ($crudNamed as $crud) {
                Permission::create(['name' => $request->name . '-' . $crud, 'guard_name' => 'web']);

            }
        } else {
            Permission::create(['name' => $request->name, 'guard_name' => 'web']);
        }

        return response()->json(['message' => 'Permission created successfully'], 201);
    }
    public function show(Permission $permission){

        return response()->json(["message" => "Success", "permission" => $permission], 200);
    }
    public function update(Request $request, Permission $permission){

        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 401);
        }

        $permission->update($validator->validated());
        return response()->json(['message' => 'Permission updated successfully'], 201);
    }

    public function destroy(Permission $permission){
        $permission->delete();
        return response()->json(['message' => 'Permission deleted successfully'], 200);
    }

}

