<x-app-layout>
    <x-slot name="headerNav">
        {{ __('Sales') }}
    </x-slot>

    @can('manage-sales')
        <a href="{{ route('sales.create') }}" class="btn btn-secondary mb-4">Create</a>
    @endcan
    <x-splade-table :for="$sales">
        @can('manage-sales')
            <x-splade-cell Actions as="$sale">
                <Link slideover href="{{ route('sales.edit', $sale->id) }}" class="btn btn-secondary">Edit</Link>
            </x-splade-cell>
        @endcan
    </x-splade-table>
</x-app-layout>
