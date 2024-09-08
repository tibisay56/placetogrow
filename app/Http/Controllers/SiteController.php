<?php

namespace App\Http\Controllers;

use App\Actions\Sites\DeleteAction;
use App\Actions\Sites\StoreAction;
use App\Actions\Sites\UpdateAction;
use App\Constants\CurrencyType;
use App\Constants\DocumentTypes;
use App\Constants\FieldType;
use App\Constants\PaymentGateway;
use App\Constants\PermissionSlug;
use App\Constants\TypeName;
use App\Http\Requests\Site\StoreRequest;
use App\Http\Requests\Site\UpdateRequest;
use App\Models\Payment;
use App\Models\Site;
use App\Models\Type;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;

class SiteController extends Controller
{
    public function index(): Response
    {
        if (! Auth::user()->can(PermissionSlug::SITES_VIEW)) {
            abort(403);
        }
        $user = Auth::user();

        if ($user->hasRole('Admin')) {
            $sites = Site::with('type')->get();
        } else {
            $sites = $user->site()->with('type')->get();
        }

        return Inertia::render('Site/Index', [
            'sites' => $sites,
        ]);
    }

    public function create(): Response
    {
        if (! Auth::user()->can(PermissionSlug::SITES_CREATE)) {
            abort(403);
        }

        $types = TypeName::toArray();
        $currencies = CurrencyType::toArray();

        return Inertia::render('Site/Create', [
            'types' => $types,
            'currencies' => $currencies,
        ]);

    }

    public function store(StoreRequest $request, StoreAction $storeAction): RedirectResponse
    {

        if (! Auth::check()) {
            return redirect()->route('avatar');
        }

        $data = $request->all();
        $storeAction->execute($data);

        return to_route('site.index')->with('message', 'Site created successfully.');
    }

    public function showBySlug($slug): Response
    {

        $site = Site::where('slug', $slug)->with('type', 'plans.planType')->firstOrFail();

        return Inertia::render('Site/Slug', [
            'site' => $site,
            'types' => Type::all(['id', 'name']),
            'currencies' => CurrencyType::toArray(),
            'documentTypes' => DocumentTypes::toArray(),
            'payments' => Payment::all(),
            'gateways' => PaymentGateway::toOptions(),
            'required_fields' => $site->required_fields,
            'plans' => $site->plans,
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ]);
    }

    public function showTransactions($slug): Response
    {

        $site = Site::where('slug', $slug)->firstOrFail();
        $site->load('user');
        $site->load('payments');
        $payments = $site->payments()->paginate(10);
        $currencies = CurrencyType::toArray();
        $types = TypeName::toArray();

        return Inertia::render('Site/Show', [
            'site' => $site,
            'currencies' => $currencies,
            'payments' => $payments,
            'types' => $types,
        ]);
    }

    public function edit(Site $site): Response
    {
        if (! Auth::user()->can(PermissionSlug::SITES_UPDATE)) {
            abort(403);
        }
        $site->load('user');

        $types = TypeName::toArray();
        $currencies = CurrencyType::toArray();
        $field_types = FieldType::toArray();

        return Inertia::render('Site/Edit', [
            'site' => $site,
            'types' => $types,
            'currencies' => $currencies,
            'field_types' => $field_types,
        ]);
    }

    public function update(UpdateRequest $request, Site $site, UpdateAction $updateAction): RedirectResponse
    {
        if (! Auth::user()->can(PermissionSlug::SITES_UPDATE)) {
            abort(403);
        }

        $data = $request->all();
        $updateAction->execute($site, $data);

        return to_route('site.index')->with('message', 'Site updated successfully.');
    }

    public function destroy(Site $site, DeleteAction $deleteAction): RedirectResponse
    {
        if (! Auth::user()->can(PermissionSlug::SITES_DELETE)) {
            abort(403);
        }

        $deleteAction->execute($site);

        return to_route('site.index')->with('message', 'Site deleted successfully.');
    }
}
