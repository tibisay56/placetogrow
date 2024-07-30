<?php

namespace App\Http\Controllers;

use App\Actions\Sites\DeleteAction;
use App\Actions\Sites\StoreAction;
use App\Actions\Sites\UpdateAction;
use App\Constants\CurrencyType;
use App\Constants\DocumentTypes;
use App\Constants\PaymentGateway;
use App\Constants\PermissionSlug;
use App\Constants\PolicyName;
use App\Constants\TypeName;
use App\Http\Requests\Site\StoreRequest;
use App\Http\Requests\Site\UpdateRequest;
use App\Models\Type;
use App\Models\Site;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\Permission\Models\Role;
use App\Models\Payment;

class SiteController extends Controller
{
    public function index(): Response
    {
        $user = Auth::user();

        if ($user->hasRole('Admin')) {
            $sites = Site::with(['users', 'type'])->get();
        } else {
            $sites = $user->sites()->with(['type'])->get();
        }

        return Inertia::render('Site/Index', [
            'sites' => $sites,
        ]);
    }

    public function create(): Response
    {
        if(!Auth::user()->can(PermissionSlug::SITES_CREATE)){
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

        if (!Auth::check()) {
            return redirect()->route('avatar');
        }

        $data = $request->all();
        $storeAction->execute($data);

        return to_route('site.index')->with('message', 'Site created successfully.');
    }


    public function showBySlug($slug): Response
    {
        $site = Site::where('slug', $slug)->with('type')->firstOrFail();

        return Inertia::render('Site/Show', [
            'site' => $site,
            'types' => Type::all(['id', 'name']),
            'currencies' => CurrencyType::toArray(),
            'documentTypes' => DocumentTypes::toArray(),
            'payments' => Payment::all(),
            'gateways' => PaymentGateway::toOptions(),
        ]);
    }

    public function edit(Site $site): Response
    {
        if(!Auth::user()->can(PermissionSlug::SITES_UPDATE)){
            abort(403);
        }
        $site->load('users');

        $types = TypeName::toArray();
        $currencies = CurrencyType::toArray();

        return Inertia::render('Site/Edit', [
            'site' => $site,
            'types' => $types,
            'currencies' => $currencies,
        ]);
    }

    public function update(UpdateRequest $request, Site $site, UpdateAction $updateAction): RedirectResponse
    {
        if (!Auth::user()->can(PermissionSlug::SITES_UPDATE)) {
            abort(403);
        }

        $data = $request->all();
        $updateAction->execute($site, $data);

        return to_route('site.index')->with('message', 'Site updated successfully.');
    }

    public function destroy(Site $site, DeleteAction $deleteAction): RedirectResponse
    {
        if (!Auth::user()->can(PermissionSlug::SITES_DELETE)) {
            abort(403);
        }

        $deleteAction->execute($site);

        return to_route('site.index')->with('message', 'Site deleted successfully.');
    }
}
