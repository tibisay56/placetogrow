<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class WelcomeController extends Controller
{
    public function __invoke(): \Inertia\Response
    {
        $sites = Site::with('Type')->paginate(15);

        return Inertia::render('Welcome', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            'sites' => $sites,
        ]);
    }
}
