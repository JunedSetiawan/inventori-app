<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use App\Tables\PurchaseHistory;
use App\Tables\Purchases;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use ProtoneMedia\Splade\Facades\Toast;

class PurchaseController extends Controller
{
    /**
     * Display the index page for purchases.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        $this->spladeTitle('Purchase');
        $this->authorize('viewAny', \App\Models\Purchase::class);
        return view('pages.purchase.index', [
            'purchases' => Purchases::class,
        ]);
    }

    /**
     * Display the form for creating a new purchase.
     *
     * @return \Illuminate\View\View
     */
    public function create(): View
    {
        $this->spladeTitle('Create Purchase');

        return view('pages.purchase.create');
    }

    /**
     * Store a newly created purchase in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $this->authorize('create', \App\Models\Purchase::class);

        $request->validate([
            'field.*.inventori_id' => ['exists:inventories,id', 'required'],
            'date' => ['date', 'required'],
            'field.*.qty' => ['numeric', 'required'],
            'field.*.price' => ['numeric', 'required'],
        ]);

        $purchase = Purchase::create([
            'date' => $request->date,
            'user_id' => auth()->user()->id,
        ]);

        foreach ($request->field as $key => $value) {
            $purchase->purchaseDetail()->create([
                'inventori_id' => $value['inventori_id'],
                'qty' => $value['qty'],
                'price' => $value['price'],
            ]);

            $inventori = \App\Models\Inventori::find($value['inventori_id']);

            $inventori->stock = $inventori->stock + $value['qty'];

            $inventori->save();
        }

        Toast::message('Data Purchase Successfully Added')->autoDismiss(5);

        return redirect()->route('purchase.index');
    }

    /**
     * Display the details of a purchase.
     *
     * @param  Purchase  $purchase
     * @return \Illuminate\View\View
     */
    public function show(Purchase $purchase): View
    {
        $this->spladeTitle('Detail Purchase');

        $purchase = Purchase::with('purchaseDetail')->find($purchase->id);

        return view('pages.purchase.show', [
            'purchase' => $purchase,
        ]);
    }

    /**
     * Edit a purchase.
     *
     * @param  Purchase  $purchase
     * @return \Illuminate\View\View
     */
    public function edit(Purchase $purchase): View
    {
        $this->spladeTitle('Edit Purchase');
        $this->authorize('update', $purchase);

        $purchase = Purchase::with('purchaseDetail')->find($purchase->id);

        return view('pages.purchase.edit', [
            'purchase' => $purchase,
        ]);
    }

    /**
     * Update a purchase record.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Purchase $purchase): RedirectResponse
    {
        $this->authorize('update', $purchase);

        $request->validate([
            'field.*.inventori_id' => ['exists:inventories,id', 'required'],
            'date' => ['date', 'required'],
            'field.*.qty' => ['numeric', 'required'],
            'field.*.price' => ['numeric', 'required'],
        ]);

        $purchase->update([
            'date' => $request->date,
            'user_id' => auth()->user()->id,
        ]);

        foreach ($purchase->purchaseDetail as $key => $value) {
            $inventori = \App\Models\Inventori::find($value->inventori_id);

            $inventori->stock = $inventori->stock - $value->qty;

            $inventori->save();
        }

        $purchase->purchaseDetail()->delete();

        foreach ($request->field as $key => $value) {
            $purchase->purchaseDetail()->create([
                'inventori_id' => $value['inventori_id'],
                'qty' => $value['qty'],
                'price' => $value['price'],
            ]);

            $inventori = \App\Models\Inventori::find($value['inventori_id']);

            $inventori->stock = $inventori->stock + $value['qty'];

            $inventori->save();
        }

        Toast::message('Data Purchase Successfully Updated')->autoDismiss(5);

        return redirect()->route('purchase.index');
    }

    /**
     * Delete a purchase and update the inventory stock accordingly.
     *
     * @param  Purchase  $purchase  The purchase to be deleted
     * @return \Illuminate\Http\RedirectResponse  The redirect response to the purchase index page
     */
    public function destroy(Purchase $purchase): RedirectResponse
    {
        $this->authorize('delete', $purchase);

        $purchase = $purchase->with('purchaseDetail')->find($purchase->id);

        foreach ($purchase->purchaseDetail as $key => $value) {
            $inventori = \App\Models\Inventori::find($value->inventori_id);

            $inventori->stock = $inventori->stock - $value->qty;

            $inventori->save();
        }

        $purchase->delete();

        Toast::message('Data Purchase Successfully Deleted')->autoDismiss(5);

        return redirect()->route('purchase.index');
    }

    /**
     * Display the history of purchases.
     *
     * @return \Illuminate\View\View
     */
    public function history(): View
    {
        $this->spladeTitle('History Purchase');
        $this->authorize('viewAny', \App\Models\Purchase::class);

        return view('pages.purchase.history', [
            'purchases' => PurchaseHistory::class,
        ]);
    }
}
