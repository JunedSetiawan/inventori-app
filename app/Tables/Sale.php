<?php

namespace App\Tables;

use App\Models\Sales;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;
use PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf;
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
        if ($request->user()->isSales() || $request->user()->isSuperAdmin() || $request->user()->can('manage-report')  ||  $request->user()->can('delete', Sales::class)) {
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
            ->column('date', 'Date', sortable: true)
            ->column('user.name', 'User')
            ->column('salesDetail.subTotal', 'subTotal', as: fn ($subTotal, $user) => 'Rp. ' . number_format((float) $subTotal, 0, ',', '.'), hidden: true)
            ->column('Actions', exportAs: false)
            ->export('Excel export', 'Sales.xlsx', Excel::XLSX)
            ->export('CSV export', 'Sales.csv', Excel::CSV)
            ->export('PDF export', 'Sales.pdf', Excel::DOMPDF)
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
