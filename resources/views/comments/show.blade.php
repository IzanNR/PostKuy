<!DOCTYPE html>
<html>
<head>
    <title>View Comment</title>
</head>
<body>
    <h1>View Comment</h1>
    <p>Body: {{ $comment->body }}</p>
    <p>Post: {{ $comment->post->title }}</p>
    <p>Author: {{ $comment->user->name }}</p>
    <a href="{{ route('comments.edit', $comment->id) }}">Edit</a>
    <a href="{{ route('comments.index') }}">Back to Comments List</a>
</body>
</html>
