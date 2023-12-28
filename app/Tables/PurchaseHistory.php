<?php

namespace App\Tables;

use App\Models\Purchase;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;
use ProtoneMedia\Splade\AbstractTable;
use ProtoneMedia\Splade\SpladeTable;

class PurchaseHistory extends AbstractTable
{
    /**
     * Create a new instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the user is authorized to perform bulk actions and exports.
     *
     * @return bool
     */
    public function authorize(Request $request)
    {
        return $request->user()->can('viewAny', Purchase::class);
    }

    /**
     * The resource or query builder.
     *
     * @return mixed
     */
    public function for()
    {
        return Purchase::query()->where('user_id', auth()->user()->id)->with('purchaseDetail')->latest();
    }

    /**
     * Configure the given SpladeTable.
     *
     * @param \ProtoneMedia\Splade\SpladeTable $table
     * @return void
     */
    public function configure(SpladeTable $table)
    {
        $table
            ->withGlobalSearch(columns: ['number'])
            ->column('number', 'Number')
            ->column('date', 'Date', sortable: true)
            ->column('user.name', 'User')
            ->export('Excel export', 'export.xlsx', Excel::XLSX)
            ->export('CSV export', 'export.csv', Excel::CSV)
            ->export('PDF export', 'export.pdf', Excel::DOMPDF)
            ->rowSlideover(fn (Purchase $purchase) => route('sales.show', [
                'sales' => $purchase,
            ]));
    }
}
