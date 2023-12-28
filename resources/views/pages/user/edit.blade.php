<x-app-layout>
    <x-slot name="headerNav">
        {{ __('Edit User') }}
    </x-slot>

    <x-splade-modal>
        <x-splade-form class="bg-base-100 space-y-2 p-5" :default="$user" action="{{ route('user.update', $user->id) }}"
            method="put">
            @csrf
            <x-splade-input name="name" label="Name" />
            <x-splade-input name="email" label="Email" type="email" />
            <x-splade-select name="role" :options="$roles" label="Role" placeholder="Select 1 role" />

            <div class="flex justify-between">
                <x-splade-submit />
            </div>
        </x-splade-form>
    </x-splade-modal>
</x-app-layout>
