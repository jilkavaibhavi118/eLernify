<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = auth()->user();
        return view('backend.profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'password' => 'nullable|string|min:8|confirmed',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            // Delete old photo if exists
            if ($user->profile_photo && \Storage::exists('public/' . $user->profile_photo)) {
                \Storage::delete('public/' . $user->profile_photo);
            }
            
            // Store new photo
            $path = $request->file('profile_photo')->store('profile_photos', 'public');
            $user->profile_photo = $path;
        }

        $user->save();

        return response()->json([
            'success' => 'Profile updated successfully',
            'url' => route('backend.profile.edit')
        ]);
    }
}
