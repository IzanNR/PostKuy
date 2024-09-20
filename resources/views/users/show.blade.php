<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IMHO - User Profile</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Background gradient behind the card */
        body {
            background: linear-gradient(to bottom right, #b0b0b0, #d0e4f7);
            min-height: 100vh;
        }
        .profile-card {
            margin-bottom: 20px;
        }
        .post-card {
            margin-bottom: 20px;
        }
        .vote-buttons {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .vote-button {
            cursor: pointer;
            border: none;
            background: none;
            font-size: 18px;
        }
        .vote-count {
            margin: 0 10px;
        }
        /* Fixed Navbar */
        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }
        /* Adjust content margin to clear the navbar */
        .content {
            margin-top: 80px; /* Adjusted for navbar height */
        }
        /* Fixed Button for Add Opinion */
        .fixed-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 999;
        }
        /* Custom search bar in the navbar */
        .navbar-search {
            display: flex;
            align-items: center;
            margin-left: auto;
        }
        .navbar-search input {
            margin-left: 10px;
            margin-right: 10px;
            max-width: 200px;
        }
        /* Style for clickable post title */
        .post-title {
            color: black; /* Ensure title color is black */
            text-decoration: none; /* Remove underline */
        }
        .post-title:hover {
            text-decoration: underline; /* Optional: underline on hover */
        }
    </style>
</head>
<body>

    <!-- Fixed Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{ asset('android-chrome-512x512.png') }}" alt="IMHO Logo" width="40" height="40">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/home') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/posts') }}">Posts</a>
                </li>
                @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/users/' . Auth::user()->username) }}">Profile ({{ Auth::user()->name }})</a>
                    </li>
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button class="nav-link btn btn-link" type="submit">Logout</button>
                        </form>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Register</a>
                    </li>
                @endauth
            </ul>

            <!-- Search Filter Form inside Navbar -->
            <form method="GET" action="{{ route('posts.index') }}" class="navbar-search form-inline">
                <input type="text" name="title" class="form-control" placeholder="Title" value="{{ request('title') }}">
                <input type="text" name="username" class="form-control" placeholder="Username" value="{{ request('username') }}">
                <button type="submit" class="btn btn-outline-primary">Search</button>
            </form>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container content">
        <!-- User Profile Card -->
        <div class="card profile-card">
            <div class="card-body">
                <h3 class="card-title">{{ $user->name }}</h3>
                <p class="card-text"><strong>Username:</strong> {{ $user->username }}</p>
                <p class="card-text"><strong>Email:</strong> {{ $user->email }}</p>
                <!-- Add more user details here if needed -->
            </div>
        </div>

        <!-- User's Posts List -->
        <h4>User's Posts:</h4>
        @foreach($user->posts as $post)
            <div class="card post-card" id="post-{{ $post->id }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $post->title }}</h5>
                    <p class="card-text">{{ $post->body }}</p>
                    <p class="card-text"><small class="text-muted">by {{ $post->user->name }}</small></p>
                    
                    <div class="vote-buttons">
                        <button class="vote-button" onclick="vote('{{ $post->id }}', 'upvote')">👍</button>
                        <span class="vote-count upvote-count">{{ $post->votes->where('vote_type', 'upvote')->count() }}</span>
                        <button class="vote-button" onclick="vote('{{ $post->id }}', 'downvote')">👎</button>
                        <span class="vote-count downvote-count">{{ $post->votes->where('vote_type', 'downvote')->count() }}</span>
                    </div>

                    <a href="{{ route('posts.show', $post->id) }}" class="btn btn-primary mt-3">View</a>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Fixed Button to Add Opinion -->
    @auth
        <a href="{{ route('posts.create') }}" class="btn btn-success fixed-button">Post Your Opinion!</a>
    @endauth


    <script>
        function vote(postId, type) {
            fetch(`/posts/${postId}/vote`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ type: type })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update vote counts without reloading the page
                    document.querySelector(`#post-${postId} .upvote-count`).textContent = data.upvotes;
                    document.querySelector(`#post-${postId} .downvote-count`).textContent = data.downvotes;
                } else {
                    console.error('Vote failed:', data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        }
    </script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
