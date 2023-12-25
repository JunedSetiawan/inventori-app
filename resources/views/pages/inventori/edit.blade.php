<x-app-layout>
    <x-slot name="headerNav">
        {{ __('Edit Inventory') }}
    </x-slot>

    <x-splade-modal>
        <x-splade-form class="bg-base-100 space-y-2 p-5" :default="$inventori"
            action="{{ route('inventory.update', $inventori->id) }}" method="put">
            @csrf
            <x-splade-input name="name" label="Name" />

            <x-splade-input name="price" label="Price" type="number" />
            <x-splade-input name="stock" label="Stock" type="number" />

            <div class="flex justify-between">
                <x-splade-submit />
            </div>
        </x-splade-form>
    </x-splade-modal>
</x-app-layout>
