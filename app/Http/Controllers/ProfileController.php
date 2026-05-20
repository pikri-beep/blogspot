<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Post;

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
    // PUBLIC PROFILE PAGE
    public function showPublicProfile($id)
    {
        // Cari user berdasarkan ID penulis artikel
        $user = User::findOrFail($id);
        
        // Ambil semua artikel yang ditulis oleh user ini
        $posts = Post::where('user_id', $id)->latest()->get();
        $totalPosts = $posts->count();

        // Ganti dari 'profile' menjadi 'pages.profile' ya, Bang!
        return view('pages.profile', compact('user', 'posts', 'totalPosts'));
    }
}