<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Models\User;


class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // LIST
    public function index()
    {
        $roles = Role::with('permissions')->get();

        return view('roles.list', compact('roles'));
    }

    // ADD FORM
    public function create()
    {
        $permissions = Permission::all();

         $users = User::all();
        return view('roles.add', compact('permissions','users'));
    }

    // STORE
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'array',
             'users' => 'array'
        ]);

        $role = Role::create([
            'name' => $request->name,
            'guard_name' => 'web'
        ]);

        if ($request->permissions) {
            $role->syncPermissions($request->permissions);
        }

        //  assign users to role
        if ($request->users) {
            foreach ($request->users as $userId) {
                $user = User::find($userId);
                if ($user) {
                    $user->assignRole($role->name);
                }
            }
        }


        return redirect('/roles')->with('success', 'Role created successfully');
    }

    // EDIT FORM
   public function edit($id)
{
    $role = Role::findOrFail($id);
    $permissions = Permission::all();
    $users = User::all();

    $rolePermissions = $role->permissions->pluck('name')->toArray();
    $roleUsers = $role->users->pluck('id')->toArray();

    return view(
        'roles.edit',
        compact('role', 'permissions', 'rolePermissions', 'users', 'roleUsers')
    );
}

    // UPDATE
    public function update(Request $request, $id)
{
    $role = Role::findOrFail($id);

    $request->validate([
        'name' => 'required|unique:roles,name,' . $id,
        'permissions' => 'array',
        'users' => 'array'
    ]);

    $role->name = $request->name;
    $role->save();

    // permissions
    $role->syncPermissions($request->permissions ?? []);

    //  USERS SYNC
    $allUsers = User::all();

    foreach ($allUsers as $user) {
        if ($user->hasRole($role->name)) {
            $user->removeRole($role->name);
        }
    }

    if ($request->users) {
        foreach ($request->users as $userId) {
            $user = User::find($userId);
            if ($user) {
                $user->assignRole($role->name);
            }
        }
    }

    return redirect('/roles')->with('success', 'Role updated successfully');
}


    // DELETE
    public function delete(Request $request)
    {
        $role = Role::findOrFail($request->id);
        $role->delete();

        return back()->with('success', 'Role deleted successfully');
    }
}
