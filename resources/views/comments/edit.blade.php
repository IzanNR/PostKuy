<!DOCTYPE html>
<html>
<head>
    <title>Edit Comment</title>
</head>
<body>
    <h1>Edit Comment</h1>
    <form action="{{ route('comments.update', $comment->id) }}" method="POST">
        @csrf
        @method('PUT')
        <label>Post ID:</label>
        <input type="text" name="post_id" value="{{ $comment->post_id }}" required>
        <br>
        <label>User ID:</label>
        <input type="text" name="user_id" value="{{ $comment->user_id }}" required>
        <br>
        <label>Body:</label>
        <textarea name="body" required>{{ $comment->body }}</textarea>
        <br>
        <button type="submit">Update</button>
    </form>
    <a href="{{ route('comments.index') }}">Back to Comments List</a>
</body>
</html>
