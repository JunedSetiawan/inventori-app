<x-app-layout>
    <x-slot name="headerNav">
        {{ __('Inventory') }}
    </x-slot>


    <Link href="{{ route('inventory.create') }}" class="btn btn-secondary mb-4">Create</Link>
    <x-splade-table :for="$inventories">
    </x-splade-table>
</x-app-layout>
