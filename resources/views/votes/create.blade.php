<!DOCTYPE html>
<html>
<head>
    <title>Create Vote</title>
</head>
<body>
    <h1>Create Vote</h1>
    <form action="{{ route('votes.store') }}" method="POST">
        @csrf
        <label>User ID:</label>
        <input type="text" name="user_id" required>
        <br>
        <label>Post ID:</label>
        <input type="text" name="post_id" required>
        <br>
        <label>Vote Type:</label>
        <select name="vote_type" required>
            <option value="upvote">Upvote</option>
            <option value="downvote">Downvote</option>
        </select>
        <br>
        <button type="submit">Create</button>
    </form>
    <a href="{{ route('votes.index') }}">Back to Votes List</a>
</body>
</html>
