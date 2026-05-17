<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PostController extends Controller
{
    // HOME
    public function home()
    {
        $posts = Post::with('user')
            ->latest()
            ->paginate(6);

        return view('pages.home', compact('posts'));
    }

    // DASHBOARD
    public function dashboard()
{
    $posts = Auth::user()
        ->posts()
        ->latest()
        ->get();

    $totalPosts = Auth::user()
        ->posts()
        ->count();

    return view('dashboard.index', compact(
        'posts',
        'totalPosts'
    ));
}

    // CREATE PAGE
    public function create()
    {
        return view('dashboard.create');
    }

    // STORE DATA
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'image' => 'nullable|image',
            'content' => 'required',
        ]);

        $image = null;

        if ($request->hasFile('image')) {

            $image = $request->file('image')
                ->store('posts', 'public');
        }

        Post::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'slug' => Str::slug($request->title . '-' . time()),
            'image' => $image,
            'content' => $request->content,
        ]);

        return redirect('/dashboard')
            ->with('success', 'Artikel berhasil dibuat');
    }

    // DETAIL
    public function detail($slug)
{
    $post = Post::with([
        'user',
        'likes',
        'comments.user'
    ])
    ->where('slug', $slug)
    ->firstOrFail();

    // RELATED POSTS
    $related = Post::where('id', '!=', $post->id)
        ->latest()
        ->take(4)
        ->get();

    return view('pages.detail', [
        'post' => $post,
        'related' => $related,
    ]);
}

    // EDIT PAGE
    public function edit(Post $post)
    {
        // SECURITY
        if ($post->user_id !== Auth::id()) {
            abort(403);
        }

        return view('dashboard.edit', compact('post'));
    }

    // UPDATE
    public function update(Request $request, Post $post)
    {
        // SECURITY
        if ($post->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required',
            'image' => 'nullable|image',
            'content' => 'required',
        ]);

        $image = $post->image;

        if ($request->hasFile('image')) {

            $image = $request->file('image')
                ->store('posts', 'public');
        }

        $post->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title . '-' . time()),
            'image' => $image,
            'content' => $request->content,
        ]);

        return redirect('/dashboard')
            ->with('success', 'Artikel berhasil diupdate');
    }

    // DELETE
    public function destroy(Post $post)
    {
        // SECURITY
        if ($post->user_id !== Auth::id()) {
            abort(403);
        }

        $post->delete();

        return redirect('/dashboard')
            ->with('success', 'Artikel berhasil dihapus');
    }
}