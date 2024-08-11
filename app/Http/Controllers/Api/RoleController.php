<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware(['permission:role-list'], ['only' => ['index']]);
        $this->middleware(['permission:role-create'], ['only' => ['store']]);
        $this->middleware(['permission:role-edit'], ['only' => [ 'update']]);
        $this->middleware(['permission:role-delete'], ['only' => ['destroy']]);
    }
    public function index()
    {
        $roles = Role::orderBy('id', 'DESC')->paginate(5);
        return response()->json(["message" => "Success", "roles" => $roles], 200);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles,name',
            'permissions' => 'required|array',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(), 401);
        }

        $role = Role::create(['name' => $request->input('name'), 'guard_name' => 'web']);

        $role->syncPermissions($request->input('permissions'));

        return response()->json(['message' => 'Role created successfully', 'role' => $role], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $role = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")
            ->where("role_has_permissions.role_id", $id)
            ->get();
        return response()->json(["message" => "Success", "role" => $role, "rolePermissions" => $rolePermissions], 200);
    }




    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles,name',
            'permissions' => 'required|array',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(), 401);
        }
        $role =Role::find($id);
        $role->name = $request->input('name');
        $role->save();
        $role->syncPermissions($request->input('permissions'));
        return response()->json(['message' => 'Role updated successfully', 'role' => $role], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            Role::find($id)->delete();
            return response()->json(["message" => "Role Deleted"], 200);
        }catch(\Exception $e){
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }
}
