<?php

namespace App\Http\Controllers;

use App\Constants\PermissionSlug;
use App\Constants\PolicyName;
use App\Http\Requests\Role\StoreRoleRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Response;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        if(!Auth::user()->can(PermissionSlug::ROLES_VIEW_ANY)){
            abort(403);
        }
        $roles = Role::all();

        return inertia('Role/Index', [
            'roles' => $roles,
        ]);
    }

    public function create(): Response
    {
        if(!Auth::user()->can(PermissionSlug::ROLES_CREATE)){
            abort(403);
        }

        return inertia('Role/Create');
    }

    public function store(StoreRoleRequest $request): \Illuminate\Http\RedirectResponse
    {
        if(!Auth::user()->can(PermissionSlug::ROLES_CREATE)){
            abort(403);
        }
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

