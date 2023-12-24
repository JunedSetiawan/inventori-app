<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Http\Requests\Apps\InventoriRequest;
use App\Models\Inventori;
use App\Tables\Inventories;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use ProtoneMedia\Splade\Facades\Toast;

class InventoriController extends Controller
{
    public function index(): View
    {
        $this->spladeTitle('Inventori');
        $this->authorize('viewAny', \App\Models\Inventori::class);

        return view('pages.inventori.index', [
            'inventories' => Inventories::class,
        ]);
    }

    public function create(): View
    {
        $this->spladeTitle('Create Inventori');
        $this->authorize('create', \App\Models\Inventori::class);

        return view('pages.inventori.create');
    }

    // store data inventori
    public function store(InventoriRequest $request)
    {
        $this->authorize('create', \App\Models\Inventori::class);

        Inventori::create($request->validated());

        Toast::message('Inventori created successfully')->autoDismiss(5);

        return redirect()->route('inventory.index');
    }

    public function edit($inventori): View
    {
        $this->spladeTitle('Edit Inventori');

        $inventori = Inventori::find($inventori);

        return view('pages.inventori.edit', [
            'inventori' => $inventori,
        ]);
    }
}
