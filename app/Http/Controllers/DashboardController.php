<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(): \Inertia\Response
    {
        $user = auth()->user();

        if ($user instanceof User) {
            return Inertia::render('Dashboard', [
                'user' => $user,
                'roles' => $user->roles,
            ]);
        }

        return Inertia::render('Dashboard', [
            'user' => $user,
            'roles' => [],
        ]);
    }
}
