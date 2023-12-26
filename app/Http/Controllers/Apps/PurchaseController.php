<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use App\Tables\PurchaseHistory;
use App\Tables\Purchases;
use Illuminate\Http\Request;
use ProtoneMedia\Splade\Facades\Toast;

class PurchaseController extends Controller
{
    public function index()
    {
        $this->spladeTitle('Purchase');
        $this->authorize('viewAny', \App\Models\Purchase::class);
        return view('pages.purchase.index', [
            'purchases' => Purchases::class,
        ]);
    }

    public function create()
    {
        return view('pages.purchase.create');
    }

    public function store(Request $request)
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

            // stock in inventory 
            // Price will be reduced upon purchase

            $inventori = \App\Models\Inventori::find($value['inventori_id']);

            $inventori->stock = $inventori->stock + $value['qty'];

            $inventori->save();
        }

        Toast::message('Data Purchase Successfully Added')->autoDismiss(5);

        return redirect()->route('purchase.index');
    }

    public function show(Purchase $purchase)
    {
        $this->spladeTitle('Detail Purchase');

        $purchase = Purchase::with('purchaseDetail')->find($purchase->id);

        return view('pages.purchase.show', [
            'purchase' => $purchase,
        ]);
    }

    public function edit(Purchase $purchase)
    {
        $this->spladeTitle('Edit Purchase');

        $purchase = Purchase::with('purchaseDetail')->find($purchase->id);

        return view('pages.purchase.edit', [
            'purchase' => $purchase,
        ]);
    }

    public function update(Request $request, Purchase $purchase)
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

            // stock in inventory\
            // Price will be reduced upon purchase

            $inventori = \App\Models\Inventori::find($value['inventori_id']);

            $inventori->stock = $inventori->stock + $value['qty'];

            $inventori->save();
        }

        Toast::message('Data Purchase Successfully Updated')->autoDismiss(5);

        return redirect()->route('purchase.index');
    }

    public function destroy(Purchase $purchase)
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

    public function history()
    {
        $this->spladeTitle('History Purchase');
        $this->authorize('viewAny', \App\Models\Purchase::class);

        return view('pages.purchase.history', [
            'purchases' => PurchaseHistory::class,
        ]);
    }
}
