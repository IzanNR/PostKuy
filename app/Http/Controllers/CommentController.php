<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CommentController extends Controller
{
    public function index(Request $request)
    {
        // Get filtering parameters
        $post_id = $request->query('post_id');
        $user_id = $request->query('user_id');
        
        // Query with filtering and pagination
        $query = Comment::with('post', 'user');
        if ($post_id) {
            $query->where('post_id', $post_id);
        }
        if ($user_id) {
            $query->where('user_id', $user_id);
        }
        $comments = $query->paginate(10); // Paginate with 10 comments per page

        return view('comments.index', ['comments' => $comments]);
    }


    public function show($id)
    {
        $comment = Comment::with('post', 'user')->find($id);
        if ($comment) {
            return response()->json($comment);
        } else {
            return response()->json(['message' => 'Comment not found'], 404);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id',
            'body' => 'required|string',
        ]);

        Comment::create([
            'post_id' => $request->input('post_id'),
            'user_id' => Auth::id(),  // Menggunakan Auth facade
            'body' => $request->input('body'),
        ]);

        return redirect()->back()->with('success', 'Comment added successfully.');
    }



    public function updateComment(Request $request, $id)
    {
        $comment = Comment::find($id);
        if (!$comment) {
            return response()->json(['message' => 'Comment not found'], 404);
        }

        $request->validate([
            'post_id' => 'sometimes|required|exists:posts,id',
            'user_id' => 'sometimes|required|exists:users,id',
            'body' => 'sometimes|required|string',
        ]);

        $comment->update($request->all());
        return response()->json($comment);
    }

    /*
    public function destroy($id)
    {
        // Find the comment by ID
        $comment = Comment::findOrFail($id);
    
        // Delete the comment
        $comment->delete();
    
        // Redirect or respond with a message
        return redirect()->route('comments.index')->with('success', 'Comment deleted successfully.');
    }
    */
}
