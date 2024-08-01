<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $roles = $user->roles()->get();

        return Inertia::render('Dashboard', [
            'user' => $user,
            'roles' => $user->roles,
        ]);
    }
}
