<?php

namespace App\Tables;

use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;
use ProtoneMedia\Splade\AbstractTable;
use ProtoneMedia\Splade\Facades\Toast;
use ProtoneMedia\Splade\SpladeTable;

class Users extends AbstractTable
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
        if ($request->user()->isSuperAdmin() || $request->user()->can('manage-report') || $request->user()->can('delete', User::class)) {
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
        return User::query()->where('id', '!=', auth()->user()->id)->latest();
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
            ->column('name', sortable: true, searchable: true)
            ->column('email', sortable: true, searchable: true)
            ->column('role', sortable: true, searchable: true)
            ->column('created_at', sortable: true, as: fn ($date) => $date->format('d F Y'))
            ->column('Actions', exportAs: false)
            ->searchInput('email')
            ->withGlobalSearch('name')
            ->export(
                'Export Excel',
                'User.xlsx',
                Excel::XLSX
            )
            ->export(
                'Export Csv',
                'User.csv',
                Excel::CSV
            )
            ->export(
                'Export Pdf',
                'User.pdf',
                Excel::DOMPDF
            )
            ->paginate(5);
    }
}
