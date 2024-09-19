<!DOCTYPE html>
<html>
<head>
    <title>Users List</title>
</head>
<body>
    <h1>Users List</h1>
    <form method="GET" action="{{ route('users.index') }}">
        <label>Username:</label>
        <input type="text" name="username" value="{{ request('username') }}">
        <button type="submit">Filter</button>
    </form>
    <a href="{{ route('users.create') }}">Create New User</a>
    <ul>
        @foreach($users as $user)
            <li>
                {{ $user->name }} ({{ $user->username }})
                <a href="{{ route('users.show', $user->id) }}">View</a>
                <a href="{{ route('users.edit', $user->id) }}">Edit</a>
                <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
            </li>
        @endforeach
    </ul>
    {{ $users->appends(request()->query())->links() }}
</body>
</html>
