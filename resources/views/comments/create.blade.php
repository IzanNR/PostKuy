<!DOCTYPE html>
<html>
<head>
    <title>Create Comment</title>
</head>
<body>
    <h1>Create Comment</h1>
    <form action="{{ route('comments.store') }}" method="POST">
        @csrf
        <label>Post ID:</label>
        <input type="text" name="post_id" required>
        <br>
        <label>User ID:</label>
        <input type="text" name="user_id" required>
        <br>
        <label>Body:</label>
        <textarea name="body" required></textarea>
        <br>
        <button type="submit">Create</button>
    </form>
    <a href="{{ route('comments.index') }}">Back to Comments List</a>
</body>
</html>
