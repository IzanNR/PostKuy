<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post - IMHO!</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Background gradient behind the card */
        body {
            background: linear-gradient(to bottom right, #b0b0b0, #d0e4f7);
            min-height: 100vh;
        }
        /* Card shadow and spacing */
        .card {
            margin-top: 80px; /* Keeping the original margin for navbar */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Adding shadow to the card */
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
        /* Custom content styles */
        .container {
            margin-top: 90px; /* Adjust for fixed navbar */
        }
        .text-center {
            text-align: center;
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
        <div class="card form-card">
            <div class="card-body">
                <h2 class="card-title">Create a New Post</h2>

                <!-- Display Validation Errors -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Create Post Form -->
                <form action="{{ route('posts.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" placeholder="Enter the post title" required>
                    </div>
                    <div class="form-group">
                        <label for="body">Body</label>
                        <textarea name="body" id="body" class="form-control" rows="5" placeholder="Enter the post body" required>{{ old('body') }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Create Post</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
