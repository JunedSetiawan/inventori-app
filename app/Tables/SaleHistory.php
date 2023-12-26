<?php

namespace App\Tables;

use App\Models\Sales;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;
use ProtoneMedia\Splade\AbstractTable;
use ProtoneMedia\Splade\SpladeTable;

class SaleHistory extends AbstractTable
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
        return $request->user()->can('viewAny', Sales::class);
    }

    /**
     * The resource or query builder.
     *
     * @return mixed
     */
    public function for()
    {
        return Sales::query()->where('user_id', auth()->user()->id)->with('salesDetail')->latest();
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
            ->rowSlideover(fn (Sales $sales) => route('sales.show', [
                'sales' => $sales,
            ]));

        // ->searchInput()
        // ->selectFilter()
        // ->withGlobalSearch()

        // ->bulkAction()
        // ->export()
    }
}
