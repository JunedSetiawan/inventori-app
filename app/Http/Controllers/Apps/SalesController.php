<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Models\Sales;
use App\Tables\Sale;
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
        }

        Toast::message('Data Sales Successfully Added')->autoDismiss(5);

        return redirect()->route('sales.index');
    }

    public function show(Sales $sales)
    {
        $this->spladeTitle('Detail Sales');

        $sale = $sales->with('salesDetail')->first();

        return view('pages.sales.show', [
            'sale' => $sale,
        ]);
    }

    public function edit(Sales $sales)
    {
        $this->spladeTitle('Edit Sales');

        $sale = $sales->with('salesDetail')->first();

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

        $sales->salesDetail()->delete();

        foreach ($request->field as $key => $value) {
            $sales->salesDetail()->create([
                'inventori_id' => $value['inventori_id'],
                'qty' => $value['qty'],
                'price' => $value['price'],
            ]);
        }

        Toast::message('Data Sales Successfully Updated')->autoDismiss(5);

        return redirect()->route('sales.index');
    }
}
