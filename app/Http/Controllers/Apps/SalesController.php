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
    /**
     * Display the sales index page.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $this->spladeTitle('Sales');
        $this->authorize('viewAny', \App\Models\Sales::class);
        return view('pages.sales.index', [
            'sales' => Sale::class,
        ]);
    }

    /**
     * Display the form for creating a new sales record.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('pages.sales.create');
    }

    /**
     * Store a newly created sales record.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
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

    /**
     * Display the details of a sales record.
     *
     * @param Sales $sales The sales record to display.
     * @return \Illuminate\View\View The view displaying the sales details.
     */
    public function show(Sales $sales)
    {
        $this->spladeTitle('Detail Sales');

        $sale = $sales->with('salesDetail')->find($sales->id);

        return view('pages.sales.show', [
            'sale' => $sale,
        ]);
    }

    /**
     * Edit a sales record.
     *
     * @param Sales $sales The sales record to be edited.
     * @return \Illuminate\View\View The view for editing the sales record.
     */
    public function edit(Sales $sales)
    {
        $this->spladeTitle('Edit Sales');

        $sale = $sales->with('salesDetail')->find($sales->id);

        return view('pages.sales.edit', [
            'sale' => $sale,
        ]);
    }

    /**
     * Update the specified sales record in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sales  $sales
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Sales $sales)
    {
        // Check if the user is authorized to update the sales record
        $this->authorize('update', $sales);

        // Validate the request data
        $request->validate([
            'field.*.inventori_id' => ['exists:inventories,id', 'required'],
            'date' => ['date', 'required'],
            'field.*.qty' => ['numeric', 'required'],
            'field.*.price' => ['numeric', 'required'],
        ]);

        // Update the sales record with the new date and user ID
        $sales->update([
            'date' => $request->date,
            'user_id' => auth()->user()->id,
        ]);

        // Update the stock of each inventory item associated with the sales record
        foreach ($sales->salesDetail as $key => $value) {
            $inventori = \App\Models\Inventori::find($value->inventori_id);

            $inventori->stock = $inventori->stock + $value->qty;

            $inventori->save();
        }

        // Delete all existing sales details associated with the sales record
        $sales->salesDetail()->delete();

        // Create new sales details based on the request data
        foreach ($request->field as $key => $value) {
            $sales->salesDetail()->create([
                'inventori_id' => $value['inventori_id'],
                'qty' => $value['qty'],
                'price' => $value['price'],
            ]);

            $inventori = \App\Models\Inventori::find($value['inventori_id']);

            // Check if the inventory stock is sufficient for the requested quantity
            if ($inventori->stock >= $value['qty']) {
                $inventori->stock = $inventori->stock - $value['qty'];
            } else {
                Toast::message('Stock is not enough')->autoDismiss(5);
                return redirect()->back();
            }

            $inventori->save();
        }

        // Display a success message
        Toast::message('Data Sales Successfully Updated')->autoDismiss(5);

        // Redirect to the sales index page
        return redirect()->route('sales.index');
    }

    /**
     * Delete a sales record and update the inventory stock accordingly.
     *
     * @param Sales $sales The sales record to be deleted.
     * @return \Illuminate\Http\RedirectResponse The redirect response to the sales index page.
     */
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

    /**
     * Display the sales history.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function history()
    {
        $this->spladeTitle('Sales History');
        $this->authorize('viewAny', \App\Models\Sales::class);

        return view('pages.sales.history', [
            'sales' => SaleHistory::class,
        ]);
    }
}
