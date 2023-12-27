<?php

namespace App\Tables;

use App\Models\Inventori;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;
use ProtoneMedia\Splade\AbstractTable;
use ProtoneMedia\Splade\Facades\Toast;
use ProtoneMedia\Splade\SpladeTable;

class Inventories extends AbstractTable
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
        if ($request->user()->isSuperAdmin() || $request->user()->can('manage-report') || $request->user()->can('delete', Inventori::class)) {
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
        return Inventori::query()->latest();
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
            ->withGlobalSearch(columns: ['name'])
            ->searchInput('code', 'Code')
            ->column('name', 'Name')
            ->column('code', 'Code')
            ->column('stock', 'Stock')
            ->column('price', 'Price', as: fn ($price, $user) => 'Rp. ' . number_format($price, 0, ',', '.'))
            ->column('created_at', 'Created At', as: fn ($created_at, $user) => $created_at->format('d M Y'))
            ->column('Actions', exportAs: false)
            ->export('Excel export', 'Inventory.xlsx', Excel::XLSX)
            ->export('Csv export', 'Inventory.csv', Excel::CSV)
            ->export('Pdf export', 'Inventory.pdf', Excel::DOMPDF)

            ->bulkAction('Delete', fn ($inventori) => $inventori->delete(), confirm: true, after: fn () => Toast::message('Inventori deleted successfully')->autoDismiss(5));

        // ->rowSlideover(fn (Inventori $inventori) => route('inventory.edit', ['id' => $inventori->id]))
    }
}
