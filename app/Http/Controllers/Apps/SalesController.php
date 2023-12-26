<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Models\Sales;
use App\Tables\Sale;
use App\Tables\SaleHistory;
use Illuminate\Http\Request;
use ProtoneMedia\Splade\Facades\Toast;

class SalesController extends Controller
{
    public function index()
    {
        $this->spladeTitle('Sales');
        $this->authorize('viewAny', \App\Models\Sales::class);
        return view('pages.sales.index', [
            'sales' => Sale::class,
        ]);
    }

    public function create()
    {
        return view('pages.sales.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', \App\Models\Sales::class);

        $request->validate([
            'field.*.inventori_id' => ['exists:inventories,id', 'required'],
            'date' => ['date', 'required'],
            'field.*.qty' => ['numeric', 'required'],
            'field.*.price' => ['numeric', 'required'],
        ]);

        $sales = Sales::create([
            'date' => $request->date,
            'user_id' => auth()->user()->id,
        ]);

        foreach ($request->field as $key => $value) {
            $sales->salesDetail()->create([
                'inventori_id' => $value['inventori_id'],
                'qty' => $value['qty'],
                'price' => $value['price'],
            ]);

            // stock in inventory
            // Price will be reduced upon purchase

            $inventori = \App\Models\Inventori::find($value['inventori_id']);

            if ($inventori->stock >= $value['qty']) {
                $inventori->stock = $inventori->stock - $value['qty'];
            } else {
                Toast::message('Stock is not enough')->autoDismiss(5);
                return redirect()->back();
            }
            $inventori->save();
        }

        Toast::message('Data Sales Successfully Added')->autoDismiss(5);

        return redirect()->route('sales.index');
    }

    public function show(Sales $sales)
    {
        $this->spladeTitle('Detail Sales');

        $sale = $sales->with('salesDetail')->find($sales->id);

        return view('pages.sales.show', [
            'sale' => $sale,
        ]);
    }

    public function edit(Sales $sales)
    {
        $this->spladeTitle('Edit Sales');

        $sale = $sales->with('salesDetail')->find($sales->id);

        return view('pages.sales.edit', [
            'sale' => $sale,
        ]);
    }

    public function update(Request $request, Sales $sales)
    {
        $this->authorize('update', $sales);
        $request->validate([
            'field.*.inventori_id' => ['exists:inventories,id', 'required'],
            'date' => ['date', 'required'],
            'field.*.qty' => ['numeric', 'required'],
            'field.*.price' => ['numeric', 'required'],
        ]);

        $sales->update([
            'date' => $request->date,
            'user_id' => auth()->user()->id,
        ]);

        foreach ($sales->salesDetail as $key => $value) {
            $inventori = \App\Models\Inventori::find($value->inventori_id);

            $inventori->stock = $inventori->stock + $value->qty;

            $inventori->save();
        }

        $sales->salesDetail()->delete();


        foreach ($request->field as $key => $value) {
            $sales->salesDetail()->create([
                'inventori_id' => $value['inventori_id'],
                'qty' => $value['qty'],
                'price' => $value['price'],
            ]);

            $inventori = \App\Models\Inventori::find($value['inventori_id']);

            if ($inventori->stock >= $value['qty']) {
                $inventori->stock = $inventori->stock - $value['qty'];
            } else {
                Toast::message('Stock is not enough')->autoDismiss(5);
                return redirect()->back();
            }

            $inventori->save();
        }

        Toast::message('Data Sales Successfully Updated')->autoDismiss(5);

        return redirect()->route('sales.index');
    }

    public function destroy(Sales $sales)
    {
        $this->authorize('delete', $sales);

        $sales = $sales->with('salesDetail')->find($sales->id);

        foreach ($sales->salesDetail as $key => $value) {
            $inventori = \App\Models\Inventori::find($value->inventori_id);

            $inventori->stock = $inventori->stock + $value->qty;

            $inventori->save();
        }

        $sales->delete();

        Toast::message('Data Sales Successfully Deleted')->autoDismiss(5);

        return redirect()->route('sales.index');
    }

    public function history()
    {
        $this->spladeTitle('Sales History');
        $this->authorize('viewAny', \App\Models\Sales::class);

        return view('pages.sales.history', [
            'sales' => SaleHistory::class,
        ]);
    }
}
