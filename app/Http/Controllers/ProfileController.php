<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        return view('profile.show', compact('user'));
    }

    public function update(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'avatar' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $fileName = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
            $path = $file->storeAs('avatars', $fileName, 'public');
            $user->avatar = $path;
        }

        $user->name = $request->name;
        $user->save();

        return redirect()->route('profile.show')->with('success', 'Profile updated');
    }
}
