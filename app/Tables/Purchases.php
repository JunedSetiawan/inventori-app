<?php

namespace App\Tables;

use App\Models\Purchase;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;
use ProtoneMedia\Splade\AbstractTable;
use ProtoneMedia\Splade\Facades\Toast;
use ProtoneMedia\Splade\SpladeTable;

class Purchases extends AbstractTable
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
        if ($request->user()->isPurchase() || $request->user()->isSuperAdmin() || $request->user()->can('manage-report') || $request->user()->can('delete', Purchase::class)) {
            return true;
        }
    }

    /**
     * The resource or query builder.
     *
     * @return mixed
     */
    public function for()
    {
        return Purchase::query()->latest();
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
            ->column('Actions')
            ->export('Excel export', 'export.xlsx', Excel::XLSX)
            ->export('CSV export', 'export.csv', Excel::CSV)
            ->export('PDF export', 'export.pdf', Excel::DOMPDF)
            ->rowSlideover(fn (Purchase $purchase) => route('purchase.show', [
                'purchase' => $purchase,
            ]));


        // ->searchInput()
        // ->selectFilter()
        // ->withGlobalSearch()

        // ->bulkAction()
        // ->export()
    }
}
