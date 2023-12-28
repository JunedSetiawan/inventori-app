<x-app-layout>
    <x-slot name="headerNav">
        {{ __('Create Inventory') }}
    </x-slot>


    <x-splade-form class="bg-base-100 space-y-2 p-5" action="{{ route('user.store') }}" method="post">
        @csrf
        <x-splade-input name="name" label="Name" required />
        <x-splade-input name="email" label="Email" type="email" required />
        <x-splade-input name="password" label="Password" type="password" required />
        <x-splade-select name="role" :options="$roles" label="Role" required placeholder="Select 1 role" />

        <x-splade-submit label="Save" />

    </x-splade-form>
</x-app-layout>
