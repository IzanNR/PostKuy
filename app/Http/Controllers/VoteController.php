<?php

namespace App\Http\Controllers;

use App\Models\Vote;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class VoteController extends Controller
{
    public function index(Request $request)
    {
        // Get filtering parameters
        $post_id = $request->query('post_id');
        $user_id = $request->query('user_id');
        $vote_type = $request->query('vote_type');
        
        // Query with filtering and pagination
        $query = Vote::with('post', 'user');
        if ($post_id) {
            $query->where('post_id', $post_id);
        }
        if ($user_id) {
            $query->where('user_id', $user_id);
        }
        if ($vote_type) {
            $query->where('vote_type', $vote_type);
        }
        $votes = $query->paginate(10); // Paginate with 10 votes per page

        return view('votes.index', ['votes' => $votes]);
    }


    public function show($id)
    {
        $vote = Vote::with('user', 'post')->find($id);
        if ($vote) {
            return response()->json($vote);
        } else {
            return response()->json(['message' => 'Vote not found'], 404);
        }
    }

    public function store(Request $request, Post $post)
    {
        $request->validate([
            'type' => 'required|in:upvote,downvote'
        ]);
    
        $userId = Auth::id();
        $voteType = $request->input('type');
    
        // Cek apakah user sudah memberikan vote untuk post ini
        $existingVote = Vote::where('user_id', $userId)
                            ->where('post_id', $post->id)
                            ->first();
    
        if ($existingVote) {
            if ($existingVote->vote_type === $voteType) {
                // Jika vote sudah ada dan sama, hapus vote
                $existingVote->delete();
            } else {
                // Jika vote sudah ada tapi berbeda, update vote
                $existingVote->update(['vote_type' => $voteType]);
            }
        } else {
            // Buat vote baru jika belum ada
            Vote::create([
                'user_id' => $userId,
                'post_id' => $post->id,
                'vote_type' => $voteType,
            ]);
        }
    
        // Kembalikan respons sukses
        return response()->json([
            'success' => true,
            'message' => 'Vote processed successfully!',
            'upvotes' => $post->votes()->where('vote_type', 'upvote')->count(),
            'downvotes' => $post->votes()->where('vote_type', 'downvote')->count(),
        ]);
    }
    

}
