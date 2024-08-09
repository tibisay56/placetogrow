<?php

namespace App\Http\Controllers;

use App\Actions\Users\DeleteUserAction;
use App\Actions\Users\StoreUserAction;
use App\Actions\Users\UpdateUserAction;
use App\Constants\PermissionSlug;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\Site;
use App\Models\User;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Response;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(): Response
    {
        if (! Auth::user()->can(PermissionSlug::USERS_VIEW_ANY)) {
            ABORT(403);
        }

        $users = User::with(['sites', 'roles'])->get();

        return inertia('User/Index', [
            'users' => $users,
        ]);
    }

    public function create(): Response
    {
        if (! Auth::user()->can(PermissionSlug::USERS_CREATE)) {
            abort(403);
        }

        $sites = Site::all();
        $roles = Role::all();

        return inertia('User/Create', [
            'sites' => $sites,
            'roles' => $roles,
        ]);
    }

    public function store(StoreUserRequest $request, StoreUserAction $storeUserAction): RedirectResponse
    {
        if (! Auth::user()->can(PermissionSlug::USERS_CREATE)) {
            abort(403);
        }

        $data = $request->only(['name', 'email', 'password']);
        $data['password'] = bcrypt($data['password']);

        $storeUserAction->execute($data);

        return to_route('user.index')->with('message', 'User was created successfully!');
    }

    public function show(User $user): Response
    {
        if (! Auth::user()->can(PermissionSlug::USERS_VIEW)) {
            abort(403);
        }
        $user->load(['roles', 'sites']);

        return inertia('User/Show', [
            'user' => $user,
            'roles' => $user->roles,
            'sites' => $user->sites,
        ]);
    }

    public function edit(User $user): Response
    {
        if (! Auth::user()->can(PermissionSlug::USERS_UPDATE)) {
            abort(403);
        }
        $user->load(['roles', 'sites']);
        $roles = Role::all();
        $sites = Site::all();

        return inertia('User/Edit', [
            'user' => $user,
            'roles' => $roles,
            'sites' => $sites,
        ]);
    }

    public function update(UpdateUserRequest $request, User $user, UpdateUserAction $updateUserAction): RedirectResponse
    {
        if (! Auth::user()->can(PermissionSlug::USERS_UPDATE)) {
            abort(403);
        }

        $data = $request->only(['name', 'email', 'roles_id', 'site_id']);
        $updateUserAction->execute($user, $data);

        return to_route('user.index')->with('message', 'User updated successfully!');
    }

    public function destroy(User $user, DeleteUserAction $deleteUserAction): RedirectResponse
    {
        if (! Auth::user()->can(PermissionSlug::USERS_DELETE)) {
            abort(403);
        }

        $deleteUserAction->execute($user);

        return to_route('user.index')->with('message', 'User deleted successfully!');
    }
}
