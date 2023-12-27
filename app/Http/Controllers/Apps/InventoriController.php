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
    /**
     * Display a listing of the inventories.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        $this->spladeTitle('Inventori');
        $this->authorize('viewAny', \App\Models\Inventori::class);

        return view('pages.inventori.index', [
            'inventories' => Inventories::class,
        ]);
    }

    /**
     * Show the form for creating a new inventory.
     *
     * @return \Illuminate\View\View
     */
    public function create(): View
    {
        $this->spladeTitle('Create Inventori');
        $this->authorize('create', \App\Models\Inventori::class);

        return view('pages.inventori.create');
    }

    /**
     * Store a newly created inventory in storage.
     *
     * @param  \App\Http\Requests\InventoriRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(InventoriRequest $request)
    {
        $this->authorize('create', \App\Models\Inventori::class);

        Inventori::create($request->validated());

        Toast::message('Inventori created successfully')->autoDismiss(5);

        return redirect()->route('inventory.index');
    }

    /**
     * Show the form for editing the specified inventory.
     *
     * @param  \App\Models\Inventori  $inventori
     * @return \Illuminate\View\View
     */
    public function edit(Inventori $inventori): View
    {
        $this->spladeTitle('Edit Inventori');

        return view('pages.inventori.edit', [
            'inventori' => $inventori,
        ]);
    }

    /**
     * Update the specified inventori in storage.
     *
     * @param  \App\Http\Requests\InventoriRequest  $request
     * @param  \App\Models\Inventori  $inventori
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(InventoriRequest $request, Inventori $inventori): RedirectResponse
    {
        $this->authorize('update', $inventori);

        $inventori->update($request->validated());

        Toast::message('Inventori updated successfully')->autoDismiss(5);

        return redirect()->route('inventory.index');
    }

    /**
     * Retrieves inventory data based on search query.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
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
