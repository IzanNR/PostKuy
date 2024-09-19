<!DOCTYPE html>
<html>
<head>
    <title>Comments List</title>
</head>
<body>
    <h1>Comments List</h1>
    <form method="GET" action="{{ route('comments.index') }}">
        <label>Post ID:</label>
        <input type="text" name="post_id" value="{{ request('post_id') }}">
        <br>
        <label>User ID:</label>
        <input type="text" name="user_id" value="{{ request('user_id') }}">
        <br>
        <button type="submit">Filter</button>
    </form>
    <a href="{{ route('comments.create') }}">Create New Comment</a>
    <ul>
        @foreach($comments as $comment)
            <li>
                {{ $comment->body }} on post {{ $comment->post->title }} by {{ $comment->user->name }}
                <a href="{{ route('comments.show', $comment->id) }}">View</a>
                <a href="{{ route('comments.edit', $comment->id) }}">Edit</a>
                <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
            </li>
        @endforeach
    </ul>
    {{ $comments->appends(request()->query())->links() }}
</body>
</html>
