<!DOCTYPE html>
<html>
<head>
    <title>Votes List</title>
</head>
<body>
    <h1>Votes List</h1>
    <form method="GET" action="{{ route('votes.index') }}">
        <label>Post ID:</label>
        <input type="text" name="post_id" value="{{ request('post_id') }}">
        <br>
        <label>User ID:</label>
        <input type="text" name="user_id" value="{{ request('user_id') }}">
        <br>
        <label>Vote Type:</label>
        <select name="vote_type">
            <option value="">-- All --</option>
            <option value="upvote" {{ request('vote_type') == 'upvote' ? 'selected' : '' }}>Upvote</option>
            <option value="downvote" {{ request('vote_type') == 'downvote' ? 'selected' : '' }}>Downvote</option>
        </select>
        <br>
        <button type="submit">Filter</button>
    </form>
    <a href="{{ route('votes.create') }}">Create New Vote</a>
    <ul>
        @foreach($votes as $vote)
            <li>
                {{ $vote->vote_type }} on post {{ $vote->post->title }} by {{ $vote->user->name }}
                <a href="{{ route('votes.show', $vote->id) }}">View</a>
                <a href="{{ route('votes.edit', $vote->id) }}">Edit</a>
                <form action="{{ route('votes.destroy', $vote->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
            </li>
        @endforeach
    </ul>
    {{ $votes->appends(request()->query())->links() }}
</body>
</html>
