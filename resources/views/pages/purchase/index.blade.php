<x-app-layout>
    <x-slot name="headerNav">
        {{ __('Purchases') }}
    </x-slot>

    @can('manage-purchase')
        <a href="{{ route('purchase.create') }}" class="btn btn-secondary mb-4">Create</a>
    @endcan
    <x-splade-table :for="$purchases">
        @can('manage-purchase')
            <x-splade-cell Actions as="$purchase">
                <div class="space-x-3">
                    <a href="{{ route('purchase.edit', $purchase->id) }}" class="btn btn-secondary">Edit</a>
                    <Link confirm href="{{ route('purchase.destroy', $purchase->id) }}" class="btn btn-error" method="DELETE">
                    Delete</Link>
                </div>
            </x-splade-cell>
        @endcan
    </x-splade-table>
</x-app-layout>
