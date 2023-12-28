<x-app-layout>
    <x-slot name="headerNav">
        {{ __('Inventory') }}
    </x-slot>

    @can('manage-inventory')
        <Link href="{{ route('inventory.create') }}" class="btn btn-secondary mb-4">Create</Link>
    @endcan
    <x-splade-table :for="$inventories">
        @can('manage-inventory')
            <x-splade-cell Actions as="$inventori">
                <div class="space-x-3">
                    <Link slideover href="{{ route('inventory.edit', $inventori->id) }}" class="btn btn-secondary">Edit</Link>
                    <Link confirm href="{{ route('inventory.destroy', $inventori->id) }}" class="btn btn-error"
                        method="DELETE">Delete
                    </Link>
                </div>
            </x-splade-cell>
        @endcan
    </x-splade-table>
</x-app-layout>
