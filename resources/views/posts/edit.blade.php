<!DOCTYPE html>
<html>
<head>
    <title>Edit Post</title>
</head>
<body>
    <h1>Edit Post</h1>
    <form action="{{ route('posts.update', $post->id) }}" method="POST">
        @csrf
        @method('PUT')
        <label>User ID:</label>
        <input type="text" name="user_id" value="{{ $post->user_id }}" required>
        <br>
        <label>Title:</label>
        <input type="text" name="title" value="{{ $post->title }}" required>
        <br>
        <label>Body:</label>
        <textarea name="body" required>{{ $post->body }}</textarea>
        <br>
        <button type="submit">Update</button>
    </form>
    <a href="{{ route('posts.index') }}">Back to Posts List</a>
</body>
</html>
