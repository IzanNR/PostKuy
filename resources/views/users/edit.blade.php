<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
</head>
<body>
    <h1>Edit User</h1>
    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        <label>Name:</label>
        <input type="text" name="name" value="{{ $user->name }}" required>
        <br>
        <label>Username:</label>
        <input type="text" name="username" value="{{ $user->username }}" required>
        <br>
        <label>Email:</label>
        <input type="email" name="email" value="{{ $user->email }}" required>
        <br>
        <label>Password:</label>
        <input type="password" name="password">
        <br>
        <button type="submit">Update</button>
    </form>
    <a href="{{ route('users.index') }}">Back to Users List</a>
</body>
</html>
