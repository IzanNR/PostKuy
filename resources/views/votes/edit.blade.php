<!DOCTYPE html>
<html>
<head>
    <title>Edit Vote</title>
</head>
<body>
    <h1>Edit Vote</h1>
    <form action="{{ route('votes.update', $vote->id) }}" method="POST">
        @csrf
        @method('PUT')
        <label>User ID:</label>
        <input type="text" name="user_id" value="{{ $vote->user_id }}" required>
        <br>
        <label>Post ID:</label>
        <input type="text" name="post_id" value="{{ $vote->post_id }}" required>
        <br>
        <label>Vote Type:</label>
        <select name="vote_type" required>
            <option value="upvote" {{ $vote->vote_type == 'upvote' ? 'selected' : '' }}>Upvote</option>
            <option value="downvote" {{ $vote->vote_type == 'downvote' ? 'selected' : '' }}>Downvote</option>
        </select>
        <br>
        <button type="submit">Update</button>
    </form>
    <a href="{{ route('votes.index') }}">Back to Votes List</a>
</body>
</html>
