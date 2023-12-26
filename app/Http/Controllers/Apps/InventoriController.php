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

    public function edit(Inventori $inventori): View
    {
        $this->spladeTitle('Edit Inventori');

        return view('pages.inventori.edit', [
            'inventori' => $inventori,
        ]);
    }

    public function update(InventoriRequest $request, Inventori $inventori): RedirectResponse
    {
        $this->authorize('update', $inventori);

        $inventori->update($request->validated());

        Toast::message('Inventori updated successfully')->autoDismiss(5);

        return redirect()->route('inventory.index');
    }

    public function getInventory(Request $request)
    {
        $search = $request->search;

        if ($search == '') {
            $inventories = Inventori::orderby('name', 'asc')->select('id', 'name', 'stock')->limit(5)->get();
        } else {
            $inventories = Inventori::orderby('name', 'asc')->select('id', 'name', 'stock')->where('name', 'like', '%' . $search . '%')->limit(5)->get();
        }

        $response = array();
        foreach ($inventories as $inventory) {
            $response[] = array(
                "id" => $inventory->id,
                "text" => $inventory->name . ' , Stock(' . $inventory->stock . ')',
            );
        }

        return response()->json($response);
    }
}
