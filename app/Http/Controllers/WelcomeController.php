<?php

namespace App\Http\Controllers;

use App\Constants\CurrencyType;
use App\Constants\DocumentTypes;
use App\Constants\PaymentGateway;
use App\Models\Payment;
use App\Models\Site;
use Inertia\Inertia;
use Illuminate\Http\Response;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

class WelcomeController extends Controller
{
    public function __invoke(): \Inertia\Response
    {
        return Inertia::render('Welcome', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            'sites' => Site::all(),
        ]);
    }

    public function welcome(): \Inertia\Response
    {
        $sites = Site::all();
        return Inertia::render('Welcome', ['sites' => $sites]);
    }
}
