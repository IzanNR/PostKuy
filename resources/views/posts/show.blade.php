<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IMHO - {{ $post->title }}</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Background gradient behind the card */
        body {
            background: linear-gradient(to bottom right, #b0b0b0, #d0e4f7); /* Blue to black gradient */
            min-height: 100vh;
        }
        .post-detail {
            margin-top: 80px; /* Adjusted for navbar height */
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
        /* Custom styles for comments */
        .comment {
            border-top: 1px solid #e5e5e5;
            padding-top: 10px;
            margin-top: 10px;
        }
        .comment-text {
            margin-top: 5px;
        }
        /* Adjust button styles */
        .btn-primary {
            margin-top: 10px;
        }
        /* Adjust fixed button styles */
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
    <div class="container post-detail">
        <!-- Back to Posts List Button -->
        <a href="{{ route('posts.index') }}" class="btn btn-primary mb-3">Back to Posts List</a>

        <!-- Post Details -->
        <div class="card">
            <div class="card-body">
                <h2 class="card-title">{{ $post->title }}</h2>
                <p class="card-text">{{ $post->body }}</p>
                <p class="card-text">
                    <small class="text-muted">
                        by <a href="{{ url('/users/' . $post->user->username) }}">{{ $post->user->name }}</a>
                    </small>
                </p>
                
                <!-- Voting Buttons -->
                <div class="vote-buttons">
                    <button class="vote-button" onclick="vote('{{ $post->id }}', 'upvote')">👍</button>
                    <span class="vote-count upvote-count">{{ $post->votes->where('vote_type', 'upvote')->count() }}</span>
                    <button class="vote-button" onclick="vote('{{ $post->id }}', 'downvote')">👎</button>
                    <span class="vote-count downvote-count">{{ $post->votes->where('vote_type', 'downvote')->count() }}</span>
                </div>

                <!-- Comments Section -->
                <div class="comments mt-4">
                    <h4>Comments</h4>
                    @foreach($post->comments as $comment)
                        <div class="comment">
                            <p><strong>{{ $comment->user->name }}:</strong></p>
                            <p class="comment-text">{{ $comment->body }}</p>
                        </div>
                    @endforeach
                </div>

                <!-- Add Comment Form -->
                @auth
                    <div class="mt-4">
                        <h4>Add a Comment</h4>
                        <form action="{{ route('comments.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="post_id" value="{{ $post->id }}" required>
                            <div class="form-group">
                                <label for="body">Comment</label>
                                <textarea name="body" id="body" class="form-control" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                @endauth
            </div>
        </div>
    </div>

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
                    document.querySelector('.upvote-count').textContent = data.upvotes;
                    document.querySelector('.downvote-count').textContent = data.downvotes;
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
