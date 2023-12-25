<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Models\Sales;
use App\Tables\Sale;
use Illuminate\Http\Request;

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
        dd($request->all());
    }

    public function show()
    {
        //     $this->spladeTitle('Detail Sales');
        //     $this->authorize('view', $sales);
        //     return view('pages.sales.show', [
        //         'sales' => $sales,
        //     ]);
    }
}
