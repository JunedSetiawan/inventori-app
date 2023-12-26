<x-app-layout>
    <x-slot name="headerNav">
        {{ __('History Sales') }}
    </x-slot>

    <x-splade-table :for="$sales">
    </x-splade-table>
</x-app-layout>
