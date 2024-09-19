<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // Get filtering parameters
        $username = $request->query('username');
        
        // Query with filtering and pagination
        $query = User::query();
        if ($username) {
            $query->where('username', 'LIKE', "%{$username}%");
        }
        $users = $query->paginate(10); // Paginate with 10 users per page

        return view('users.index', ['users' => $users]);
    }


    public function show($username)
    {
        // Cari pengguna berdasarkan username
        $user = User::where('username', $username)
            ->with(['posts' => function ($query) {
                $query->orderBy('created_at', 'desc'); // Sort posts from newest to oldest
            }])
            ->first();
    
        if ($user) {
            return view('users.show', ['user' => $user]);
        } else {
            return redirect()->route('users.index')->with('error', 'User not found');
        }
    }
    
    

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|unique:users',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return response()->json($user, 201);
    }

    public function edit($id)
    {
        $user = User::find($id);
        if ($user) {
            return view('users.edit', ['user' => $user]);
        } else {
            return redirect()->route('users.index')->with('error', 'User not found');
        }
    }
    
    public function updateUpdate(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return redirect()->route('users.index')->with('error', 'User not found');
        }
    
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'username' => 'sometimes|required|string|unique:users,username,' . $id,
            'email' => 'sometimes|required|string|email|unique:users,email,' . $id,
            'password' => 'sometimes|nullable|string|min:6',
        ]);
    
        $user->fill($request->only(['name', 'username', 'email']));
        
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }
    
        $user->save();
    
        return redirect()->route('users.show', $id)->with('success', 'User updated successfully');
    }
    
    /*
        public function destroy($id)
        {
            $user = User::find($id);
            if ($user) {
                $user->delete();
                return response()->json(['message' => 'User deleted']);
            } else {
                return response()->json(['message' => 'User not found'], 404);
            }
        }
    */
}
