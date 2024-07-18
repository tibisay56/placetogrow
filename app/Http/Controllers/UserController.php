<?php

namespace App\Http\Controllers;

use App\Constants\PermissionSlug;
use App\Constants\PolicyName;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\Site;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Response;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(): Response
    {
        if(!Auth::user()->can(PermissionSlug::USERS_VIEW_ANY)){
            ABORT(403);
        }

        $users = User::with(['site', 'roles'])->get();

        return inertia('User/Index', [
            'users' => $users,
        ]);
    }

    public function create(): Response
    {
        if(!Auth::user()->can(PermissionSlug::USERS_CREATE)){
            abort(403);
        }

        $sites = Site::all();

        return inertia('User/Create', [
        'sites' => $sites
    ]);
    }

    public function store(StoreUserRequest $request): \Illuminate\Http\RedirectResponse
    {
        if(!Auth::user()->can(PermissionSlug::USERS_CREATE)){
            abort(403);
        }
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make('password');
        $user->save();

        return to_route('user.index');
    }
    public function show(User $user): Response
    {
        if(!Auth::user()->can(PermissionSlug::USERS_VIEW)){
            abort(403);
        }
        $user->load(['roles', 'site']);

        return inertia('User/Show', [
            'user' => $user,
            'roles' => $user->roles,
            'site' => $user->site ?: null,
        ]);
    }

    public function edit(User $user): Response
    {
        if(!Auth::user()->can(PermissionSlug::USERS_UPDATE)){
            abort(403);
        }
        $roles = Role::all();
        return inertia('User/Edit', [
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'roles' => $user->roles,
            ],
            'roles' => $roles,
        ]);
    }

    public function update(UpdateUserRequest $request, User $user): \Illuminate\Http\RedirectResponse
    {
        if(!Auth::user()->can(PermissionSlug::USERS_UPDATE)){
            abort(403);
        }
        $user->update([
            'name' => $request->input('name'),
        ]);

        $user->syncRoles($request->input('roles_id'));

        return to_route('user.index');
    }

    public function destroy(User $user): RedirectResponse
    {
        if(!Auth::user()->can(PermissionSlug::USERS_DELETE)){
            abort(403);
        }
        $user->delete();

        return to_route('user.index');
    }
}

