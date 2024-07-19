<?php

namespace App\Http\Controllers;

use App\Constants\CurrencyType;
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

        $types = TypeName::toArray();
        $currencies = CurrencyType::toArray();

        return Inertia::render('Site/Create', [
            'types' => $types,
            'currencies' => $currencies,
        ]);

    }

    public function store(StoreRequest $request): RedirectResponse
    {

        if (! Auth::check()) {

            return redirect()->route('avatar');
        }

        $data = $request->except('avatar');

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $path = $file->store('avatars', ['disk' => 'public']);
            $data['avatar'] = $path;
        }
        $data['user_id'] = Auth::user()->id;

        Site::create($data);

        return to_route('site.index');
    }

    public function show(Site $site): Response
    {
        $site->load('users');
        $types = TypeName::toArray();
        $currencies = CurrencyType::toArray();

        return Inertia::render('Site/Show', [
            'site' => $site,
            'types' => $types,
            'currencies' => $currencies,
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

    public function update(UpdateRequest $request, Site $site): RedirectResponse
    {
        if(!Auth::user()->can(PermissionSlug::SITES_UPDATE)){
            abort(403);
        }
        $data = $request->except('avatar');

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $path = $file->store('avatars', ['disk' => 'public']);
            $data['avatar'] = $path;

            if ($site->avatar) {
                Storage::disk('public')->delete($site->avatar);
            }
        }

        $site->update($data);

        return to_route('site.index');

    }

    public function destroy(Site $site): RedirectResponse
    {
        if(!Auth::user()->can(PermissionSlug::SITES_DELETE)){
            abort(403);
        }
        if ($site->avatar) {
            Storage::disk('public')->delete($site->avatar);
        }
        $site->delete();

        return to_route('site.index');
    }
}
