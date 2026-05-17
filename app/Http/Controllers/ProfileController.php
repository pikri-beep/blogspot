<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    // PROFILE PAGE
    public function index()
    {
        $user = Auth::user();

        $posts = $user->posts()
            ->latest()
            ->get();

        $totalPosts = $posts->count();

        return view('pages.profile', compact(
            'user',
            'posts',
            'totalPosts'
        ));
    }

    // UPDATE PROFILE
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'bio' => 'nullable',
            'avatar' => 'nullable|image',
        ]);

        $user = Auth::user();

        $avatar = $user->avatar;

        // upload avatar
        if ($request->hasFile('avatar')) {

            $avatar = $request->file('avatar')
                ->store('avatars', 'public');
        }

        $user->update([
            'name' => $request->name,
            'bio' => $request->bio,
            'avatar' => $avatar,
        ]);

        return back()->with(
            'success',
            'Profile berhasil diupdate'
        );
    }
}