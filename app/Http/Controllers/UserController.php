<?php

namespace App\Http\Controllers;

use App\Http\Requests\Apps\UpdateUserRequest;
use App\Http\Requests\Apps\UserRequest;
use App\Models\User;
use App\Tables\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use ProtoneMedia\Splade\Facades\Toast;

class UserController extends Controller
{
    public function index()
    {
        $this->spladeTitle('User');
        $this->authorize('viewAny', \App\Models\User::class);
        return view('pages.user.index', [
            'users' => Users::class,
        ]);
    }

    public function create()
    {
        $this->spladeTitle('Create User');

        $roles = [
            'sales' => 'Sales',
            'purchase' => 'Purchase',
            'manager' => 'Manager',
        ];

        return view('pages.user.create', [
            'roles' => $roles
        ]);
    }

    public function store(UserRequest $request)
    {
        $this->authorize('create', \App\Models\User::class);

        $validated = $request->validated();

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        Toast::success('User created successfully!')->autoDismiss(5);

        return redirect()->route('user.index');
    }

    public function edit(User $user)
    {
        $this->spladeTitle('Edit User');

        $roles = [
            'sales' => 'Sales',
            'purchase' => 'Purchase',
            'manager' => 'Manager',
        ];

        return view('pages.user.edit', [
            'user' => $user,
            'roles' => $roles
        ]);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $this->authorize('update', \App\Models\User::class);

        $validated = $request->validated();

        $user->update($validated);

        Toast::success('User updated successfully!')->autoDismiss(5);

        return redirect()->route('user.index');
    }

    public function destroy(User $user)
    {
        $this->authorize('delete', \App\Models\User::class);

        $user->delete();

        Toast::success('User deleted successfully!')->autoDismiss(5);

        return redirect()->route('user.index');
    }
}
