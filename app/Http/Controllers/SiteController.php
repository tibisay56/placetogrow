<?php

namespace App\Http\Controllers;

use App\Constants\CurrencyType;
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

class SiteController extends Controller
{
    public function index(): Response
    {
        $sites = Site::with('type')->where('user_id', Auth::id())->get();

        return Inertia::render('Site/Index', compact('sites'));
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
        $types = TypeName::toArray();
        $currencies = CurrencyType::toArray();

        return Inertia::render('Site/Show', [
            'site' => $site,
            'types' => $types,
            'currencies' => $currencies,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Site $site): Response
    {
        $types = TypeName::toArray();
        $currencies = CurrencyType::toArray();

        return Inertia::render('Site/Edit', [
            'site' => $site,
            'types' => $types,
            'currencies' => $currencies,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Site $site): RedirectResponse
    {

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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Site $site): RedirectResponse
    {
        if ($site->avatar) {
            Storage::disk('public')->delete($site->avatar);
        }
        $site->delete();

        return to_route('site.index');
    }
}
