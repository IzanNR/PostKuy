<!DOCTYPE html>
<html>
<head>
    <title>View Vote</title>
</head>
<body>
    <h1>View Vote</h1>
    <p>Vote Type: {{ $vote->vote_type }}</p>
    <p>Post: {{ $vote->post->title }}</p>
    <p>Voter: {{ $vote->user->name }}</p>
    <a href="{{ route('votes.edit', $vote->id) }}">Edit</a>
    <a href="{{ route('votes.index') }}">Back to Votes List</a>
</body>
</html>
