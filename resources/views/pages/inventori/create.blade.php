<x-app-layout>
    <x-slot name="headerNav">
        {{ __('Create Inventory') }}
    </x-slot>


    <x-splade-form class="bg-base-100 space-y-2 p-5" action="{{ route('inventory.store') }}" method="post">
        @csrf
        <x-splade-input name="name" label="Name" />

        <x-splade-input name="price" label="Price" type="number" min="1000" />
        <x-splade-input name="stock" label="Stock" type="number" min="0" />

        <x-splade-submit label="Save" />

    </x-splade-form>
</x-app-layout>
