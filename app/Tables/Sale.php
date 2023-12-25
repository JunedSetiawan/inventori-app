<?php

namespace App\Tables;

use App\Models\Sales;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;
use ProtoneMedia\Splade\AbstractTable;
use ProtoneMedia\Splade\Facades\Toast;
use ProtoneMedia\Splade\SpladeTable;

class Sale extends AbstractTable
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
        if ($request->user()->isSales() || $request->user()->isSuperAdmin() ||  $request->user()->can('delete', Sales::class)) {
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
        return Sales::query()->latest();
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
            ->column('date', 'Date', as: fn ($date, $user) => $date->format('d M Y'), sortable: true)
            ->column('user.name', 'User')
            ->column('Actions')
            ->export('Excel export', 'export.xlsx', Excel::XLSX)
            ->export('CSV export', 'export.csv', Excel::CSV)
            ->export('PDF export', 'export.pdf', Excel::DOMPDF)

            ->bulkAction('Delete', fn ($sales) => $sales->delete(), confirm: true, after: fn () => Toast::message('Inventori deleted successfully')->autoDismiss(5));

        // ->searchInput()
        // ->selectFilter()
        // ->withGlobalSearch()

        // ->bulkAction()
        // ->export()
    }
}
