<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container mt-5">
        @auth
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Welcome {{ auth()->user()->name }}</h2>
                <form action="/logout" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-danger">Logout</button>
                </form>
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <form action="/create-post" method="POST">
                        @csrf
                        <div class="mb-3">
                            <input type="text" name="title" class="form-control" placeholder="Title">
                        </div>
                        <div class="mb-3">
                            <textarea name="body" class="form-control" placeholder="What is on your mind?"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Post</button>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">TODO:</h2>
                    @foreach ($posts as $post)
                        <div class="card mb-3">
                            <div class="card-body">
                                <h3 class="card-title">{{ $post->title }}</h3>
                                <p class="card-text">{{ $post->body }}</p>
                                <div class="d-flex justify-content-between">
                                <a href="/edit-post/{{ $post->id }}" class="btn btn-warning">Edit</a>
                                    <form action="/delete-post/{{ $post->id }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="text-center">
                <h1>Welcome</h1>
                <a href="/register-page" class="btn btn-primary">Register</a>
                <a href="/login-page" class="btn btn-secondary">Login</a>
            </div>
        @endauth
    </div>
</body>
</html>