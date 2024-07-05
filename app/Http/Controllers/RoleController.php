<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $users = User::all();
        $roles = Role::all();

        return view('roles.index', compact('users', 'roles'));
    }

    public function assign(Request $request)
    {
        $user = User::find($request->user_id);
        $role = Role::findByName($request->role);

        if ($user && $role) {
            $user->syncRoles([$role]);
        }

        return redirect()->route('roles.index')->with('success', 'Role assigned successfully');
    }
}

