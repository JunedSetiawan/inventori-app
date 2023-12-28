<x-app-layout>
    <x-slot name="headerNav">
        {{ __('Users') }}
    </x-slot>

    @can('manage-user')
        <Link href="{{ route('user.create') }}" class="btn btn-secondary mb-4">Create</Link>
    @endcan
    <x-splade-table :for="$users">
        @can('manage-user')
            <x-splade-cell Actions as="$user">
                <div class="space-x-3">
                    <Link slideover href="{{ route('user.edit', $user->id) }}" class="btn btn-secondary">Edit</Link>
                    <Link confirm href="{{ route('user.destroy', $user->id) }}" class="btn btn-error" method="DELETE">Delete
                    </Link>
                </div>
            </x-splade-cell>
        @endcan
    </x-splade-table>
</x-app-layout>
