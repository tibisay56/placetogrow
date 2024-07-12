<?php

namespace App\Http\Controllers;

use App\Http\Requests\Role\StoreRoleRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Response;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();

        return inertia('Role/Index', [
            'roles' => $roles,
        ]);
    }

    public function create(): Response
    {
        return inertia('Role/Create');
    }

    public function store(StoreRoleRequest $request): \Illuminate\Http\RedirectResponse
    {
        Role::create([
            'name' => $request->name,
        ]);

        return to_route('role.index');
    }

    public function show(Role $role): Response
    {
        return inertia('Role/Show', [
            'role' => $role,
        ]);
    }


}

