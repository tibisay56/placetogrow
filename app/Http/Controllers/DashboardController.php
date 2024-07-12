<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;

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
