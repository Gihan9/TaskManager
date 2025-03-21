<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
         body {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            font-family: 'Poppins', sans-serif;
        }
       
       
        .table {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            overflow: hidden;
        }
        .table th, .table td {
            color: black;
        }
       
        .btn-custom {
            background: white;
            color: #764ba2;
            font-weight: bold;
            border-radius: 25px;
            transition: 0.3s;
        }
        .btn-custom:hover {
            background: #764ba2;
            color: white;
        }
        @media (max-width: 768px) {
            .container {
                max-width: 100%;
                padding: 15px;
            }
            .table {
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }
            .table th, .table td {
                color: black;
                font-size: 10pt;
            }
            .btn-custom {
                width: 100%;
                margin-bottom: 10px;
            }
            .container{
                width:500px;
            }
        }

 
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand text-white" href="#">Task Manager</a>
            <div class="d-flex">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-custom me-2">Dashboard</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-danger">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-light me-2">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-success">Register</a>
                @endauth
            </div>
        </div>
    </nav>
    
    <div class="container mt-5">
        <div class="card p-4 shadow-lg rounded">
            @yield('content')
        </div>
    </div>

    <script src="{{ asset('js/task.js') }}"></script>
</body>
</html>