<x-app-layout>
    <x-slot name="headerNav">
        {{ __('Create Inventory') }}
    </x-slot>


    <x-splade-form class="bg-base-100 space-y-2 p-5" action="{{ route('inventory.store') }}" method="post">
        @csrf
        <x-splade-input name="name" label="Name" />

        <x-splade-input name="price" label="Price" type="number" />
        <x-splade-input name="stock" label="Stock" type="number" />

        <div class="flex justify-between">
            <x-splade-submit />
            <button class="btn btn-neutral">Add More</button>
        </div>
    </x-splade-form>
</x-app-layout>
