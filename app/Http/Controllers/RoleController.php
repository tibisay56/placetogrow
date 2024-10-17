<?php

namespace App\Http\Controllers;

use App\Actions\Roles\DeleteRoleAction;
use App\Actions\Roles\StoreRoleAction;
use App\Actions\Roles\UpdateRoleAction;
use App\Constants\PermissionSlug;
use App\Http\Requests\Role\StoreRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index(): Response
    {
        if (! Auth::user()->can(PermissionSlug::ROLES_VIEW_ANY)) {
            abort(403);
        }
        $roles = Role::with('permissions')->get();

        return inertia('Role/Index', [
            'roles' => $roles,
        ]);
    }

    public function create(): Response
    {
        if (! Auth::user()->can(PermissionSlug::ROLES_CREATE)) {
            abort(403);
        }

        return Inertia::render('Role/Create', [
            'permissions' => Permission::get(),
        ]);
    }

    public function store(StoreRoleRequest $request, StoreRoleAction $storeRoleAction): RedirectResponse
    {
        if (! Auth::user()->can(PermissionSlug::ROLES_CREATE)) {
            abort(403);
        }

        $role = $storeRoleAction->execute($request->all());

        return redirect()->route('role.index', $role)->with('message', 'Role created successfully.');
    }

    public function show(Role $role): Response
    {
        if (! Auth::user()->can(PermissionSlug::ROLES_CREATE)) {
            abort(403);
        }

        $permissions = Permission::all();

        return Inertia::render('Role/Show', ['role' => $role->load('permissions'),
            'permissions' => $permissions, ]);
    }

    public function edit(Role $role): Response
    {
        if (! Auth::user()->can(PermissionSlug::ROLES_UPDATE)) {
            abort(403);
        }

        $permissions = Permission::all();

        return Inertia::render('Role/Edit', ['role' => $role->load('permissions'),
            'permissions' => $permissions, ]);
    }

    public function update(UpdateRoleRequest $request, Role $role, UpdateRoleAction $updateRoleAction): RedirectResponse
    {

        if (! Auth::user()->can(PermissionSlug::ROLES_UPDATE)) {
            abort(403);
        }

        $updateRoleAction->execute($role, $request->all());

        return redirect()->route('role.index')->with('message', 'Role updated successfully.');
    }

    public function destroy(Role $role, DeleteRoleAction $deleteRoleAction): RedirectResponse
    {
        if (! Auth::user()->can(PermissionSlug::ROLES_DELETE)) {
            abort(403);
        }

        $deleteRoleAction->execute($role);

        return to_route('role.index')->with('message', 'Role deleted successfully.');
    }
}
