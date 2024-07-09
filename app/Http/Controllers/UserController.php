<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Inertia\Response;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index(): Response
    {
        $users = User::all();

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
        return inertia('User/Show', [
            'user' => $user,
        ]);
    }

    public function edit(User $user): Response
    {
        return inertia('User/Edit', [
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
            ]
        ]);
    }

    public function update(UpdateUserRequest $request, User $user): \Illuminate\Http\RedirectResponse
    {

        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
        ]);

        return redirect()->route('user.show', ['user' => $user->id]);
    }

    public function destroy(User $user): Response
    {
        $user->delete();

        return inertia('User/Index');
    }
}

