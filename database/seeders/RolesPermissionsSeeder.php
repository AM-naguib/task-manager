<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolesPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    private $permissions = [
        'role-list',
        'role-create',
        'role-edit',
        'role-delete',
        "project-list",
        "project-create",
        "project-edit",
        "project-delete",
        "task-list",
        "task-create",
        "task-edit",
        "task-delete",
        "comment-list",
        "comment-create",
        "comment-edit",
        "comment-delete",
        "user-list",
        "user-create",
        "user-edit",
        "user-delete",

    ];
    public function run(): void
    {

        foreach ($this->permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
        $user = User::create([
            'name' => 'Ahmed Mohamed',
            'email' => 'am_f@gmail.com',
            'username' => 'am-naguib',
            'password' => Hash::make('password')
        ]);
        $role = Role::create(['name' => 'Admin']);
        $permissions = Permission::pluck('id', 'id')->all();
        $role->syncPermissions($permissions);
        $user->assignRole([$role->id]);

    }
}
