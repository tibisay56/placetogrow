<?php

namespace App\Http\Controllers;

use App\Constants\ImportStatus;
use App\Imports\InvoiceImportToCollection;
use App\Imports\InvoiceImportToModel;
use App\Jobs\ProcessInvoiceFile;
use App\Models\Import;
use App\Models\Site;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Maatwebsite\Excel\Excel as Reader;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function index(Site $site): Response
    {

        $imports = $site->imports;

        return Inertia::render('Import/Index', [
            'site' => $site,
            'imports' => $imports,
        ]);
    }

    public function create(Site $site): Response
    {
        $imports = Import::all();

        return Inertia::render('Import/Create', [
            'site' => $site,
            'imports' => $imports,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        if (! $request->hasFile('file')) {
            return back()->withErrors(['file' => 'No file was uploaded']);
        }

        $file = $request->file('file');

        $path = $file->store(options: ['disk' => Import::DISK]);

        $import = new Import();
        $import->path = $path;
        $import->file_name = $file->getClientOriginalName();
        $import->status = ImportStatus::PENDING;
        $import->user()->associate(auth()->user());
        $import->save();

        Excel::import(new InvoiceImportToModel($import), $import->path, Import::DISK, Reader::CSV);
        // Excel::import(new InvoiceImportToCollection($import), $import->path, Import::DISK, Reader::CSV);
        //dispatch(new ProcessInvoiceFile($import));

        return redirect()->route('import.show', $import);
    }

    public function show(Site $site): Response
    {
        $imports = Import::all();

        return Inertia::render('Import/Show', [
            'site' => $site,
            'imports' => $imports,
        ]);
    }
}
