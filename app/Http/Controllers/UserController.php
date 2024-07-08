<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
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
        return inertia('Users/Index', [
            'users' => User::all(),
        ]);
    }

    public function create(): Response
    {
        return inertia('Users/Create');
    }

    public function store(StoreUserRequest $request): Response
    {
        $user = new User();
        $user->name = $request->first_name . ' ' . $request->last_name;
        $user->email = $request->email;
        $user->password = Hash::make('password');
        $user->save();

        return Redirect::route('users')->with('success', 'User created.');
    }
    public function show(User $user): Response
    {
        return inertia('Users/Show', [
            'user' => $user,
        ]);
    }

    public function edit(User $user): Response
    {
        return inertia('Users/Edit', [
            'user' => [
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
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

        return redirect()->route('users.show', ['user' => $user->id]);
    }

    public function destroy(User $user): Response
    {
        $user->delete();

        return inertia('Users/Index');
    }
}

