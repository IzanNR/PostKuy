<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class PostController extends Controller
{
    public function index(Request $request)
    {
        // Ambil query parameter untuk pencarian, jika ada
        $title = $request->query('title');
        $username = $request->query('username');
    
        $query = Post::query();
    
        // Tambahkan filter pencarian jika ada
        if ($title) {
            $query->where('title', 'like', '%' . $title . '%');
        }
        if ($username) {
            $query->whereHas('user', function ($query) use ($username) {
                $query->where('name', 'like', '%' . $username . '%');
            });
        }
    
        // Urutkan postingan berdasarkan tanggal terbaru
        $posts = $query->orderBy('created_at', 'desc')->paginate(10);
    
        return view('posts.index', compact('posts'));
    }
    

    public function create()
    {
        return view('posts.create');
    }
    

    public function show($id)
    {
        $post = Post::with('user')->find($id);
        if ($post) {
            return view('posts.show', compact('post'));
        } else {
            return response()->json(['message' => 'Post not found'], 404);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        Post::create([
            'user_id' => Auth::id(),
            'title' => $request->input('title'),
            'body' => $request->input('body'),
        ]);

        return redirect()->route('posts.index')->with('success', 'Post created successfully.');
    }


    public function updatePost(Request $request, $id)
    {
        $post = Post::find($id);
        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }

        $request->validate([
            'user_id' => 'sometimes|required|exists:users,id',
            'title' => 'sometimes|required|string|max:255',
            'body' => 'sometimes|required|string',
        ]);

        $post->update($request->all());
        return response()->json($post);
    }

    public function destroyPost($id)
    {
        $post = Post::find($id);
        if ($post) {
            $post->delete();
            return response()->json(['message' => 'Post deleted']);
        } else {
            return response()->json(['message' => 'Post not found'], 404);
        }
    }
}
