<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Inertia\Response;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(): Response
    {
        $users = User::with('roles')->get();

        return inertia('User/Index', [
            'users' => $users,
        ]);
    }

    public function create(): Response
    {
        return inertia('User/Create');
    }

    public function store(StoreUserRequest $request): \Illuminate\Http\RedirectResponse
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make('password');
        $user->save();

        return to_route('user.index');
    }
    public function show(User $user): Response
    {
        $roles = $user->roles()->get();

        return inertia('User/Show', [
            'user' => $user,
            'roles' => $roles,
        ]);
    }

    public function edit(User $user): Response
    {
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

        $user->update([
            'name' => $request->input('name'),
        ]);

        $user->syncRoles($request->input('roles_id'));

        return to_route('user.index');
    }

    public function destroy(User $user): Response
    {
        $user->delete();

        return inertia('User/Index');
    }
}

