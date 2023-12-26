<x-app-layout>
    <x-slot name="headerNav">
        {{ __('History Purchases') }}
    </x-slot>

    <x-splade-table :for="$purchases">
    </x-splade-table>
</x-app-layout>
