<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        // Eager load roles to avoid N+1 query issue if needed
        $users = User::with('roles')
            ->where('id', '!=', auth()->id())
            ->paginate(10); 
        return view('admin.users.index', compact('users'));
    }

    public function show()
    {
        return view('profile.show', ['user' => auth()->user()]);
    }

    public function edit(User $user)
    {
        return view('profile.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request)
    {
        // Using form request validation to keep the controller clean
        auth()->user()->update($request->validated());

        return back()->with('success', 'Profile updated!');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|confirmed|min:8|different:current_password',
        ]);
    
        $user = auth()->user();
    
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }

        $user->update(['password' => Hash::make($request->password)]);
    
        return back()->with('success', 'Password changed successfully!');
    }

    public function updateUser(UpdateUserRequest $request, User $user)
    {
        $user->update($request->validated());

        return back()->with('success', 'User updated!');
    }

    public function destroy(User $user)
    {
        // Add confirmation or soft delete as needed
        $user->delete();

        return back()->with('success', 'User deleted!');
    }

    public function promoteToAdmin(User $user)
    {
        $user->syncRoles(['admin']); // Using syncRoles ensures no duplication
        return back()->with('success', 'User promoted to admin!');
    }


}
