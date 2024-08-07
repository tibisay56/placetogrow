<?php

namespace App\Http\Controllers;

use App\Constants\CurrencyType;
use App\Constants\DocumentTypes;
use App\Constants\PaymentGateway;
use App\Models\Site;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

        return Inertia::render('Welcome', [
            'sites' => $sites,
            'currencies' => CurrencyType::toArray(),
            'documentTypes' => DocumentTypes::toArray(),
            'gateways' => PaymentGateway::toOptions(),
        ]);
    }
}
