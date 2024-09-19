<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IMHO - Home</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
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
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="{{ url('/') }}">IMHO!</a>
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
        <div class="card mt-4">
            <div class="card-body">
                <h1>What does the world think?</h1>
                
                @auth
                    <p>Welcome, {{ Auth::user()->name }}!</p>
                    <a href="{{ url('/posts') }}" class="btn btn-primary">View Posts</a>
                @else
                    <p><a href="{{ route('login') }}" class="btn btn-primary">Login</a></p>
                    <p><a href="{{ route('register') }}" class="btn btn-primary">Register</a></p>
                @endauth
            </div>
        </div>
    </div>

    <!-- Fixed Button to Add Opinion -->
    <a href="{{ route('posts.create') }}" class="btn btn-success fixed-button">Post Your Opinion!</a>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
