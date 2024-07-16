<?php

namespace App\Http\Controllers;

use App\Constants\PermissionSlug;
use App\Http\Requests\Role\StoreRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RoleController extends Controller
{
    public function index(): Response
    {
        if(!Auth::user()->can(PermissionSlug::ROLES_VIEW_ANY)){
            abort(403);
        }
        $roles = Role::with('permissions')->get();

        return inertia('Role/Index', [
            'roles' => $roles,
        ]);
    }

    public function create(): Response
    {
        if(!Auth::user()->can(PermissionSlug::ROLES_CREATE)){
            abort(403);
        }

        return Inertia::render('Role/Create', [
            'permissions' => Permission::get()
        ]);
    }

    public function store(StoreRoleRequest $request): \Illuminate\Http\RedirectResponse
    {
        if(!Auth::user()->can(PermissionSlug::ROLES_CREATE)){
            abort(403);
        }

        $role = Role::create(['name' => $request->name]);
        $permissions = Permission::whereIn('id', $request->permissions)->get(['name'])->toArray();


        $role->syncPermissions($permissions);

        return redirect()->route('role.index', $role)->with('success', 'Role created successfully.');
    }

    public function show(Role $role): Response
    {
        if(!Auth::user()->can(PermissionSlug::ROLES_CREATE)){
            abort(403);
        }

        $permissions = Permission::all();

        return Inertia::render('Role/Show', ['role' => $role->load('permissions'),
            'permissions' => $permissions,]);
    }

    public function edit(Role $role): Response
    {
        if(!Auth::user()->can(PermissionSlug::ROLES_UPDATE)){
            abort(403);
        }

        $permissions = Permission::all();

        return Inertia::render('Role/Edit', ['role' => $role->load('permissions'),
            'permissions' => $permissions,]);
    }

    public function update(UpdateRoleRequest $request, Role $role): RedirectResponse
    {
        if(!Auth::user()->can(PermissionSlug::ROLES_UPDATE)){
            abort(403);
        }

        $role->update(['name' => $request->name]);

        $permissions = Permission::whereIn('id', $request->permissions)->get(['name'])->toArray();

        $role->syncPermissions($permissions);

        return redirect()->route('role.index')->with('success', 'Role updated successfully.');
    }

    public function destroy(Role $role): RedirectResponse
    {
        if(!Auth::user()->can(PermissionSlug::ROLES_DELETE)){
            abort(403);
        }

        $role->delete();

        return to_route('role.index');
    }
}

