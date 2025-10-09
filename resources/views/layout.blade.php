<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DeadlinePulse</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- === Structured Styles === -->
    <style>
        /* === General Body === */
        body {
            background-color: #f4f7fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* === Navbar === */
        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
        }

        .navbar .btn-nav {
            margin-left: 10px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        /* === Cards === */
        .card {
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .card-title {
            font-weight: bold;
            font-size: 1.2rem;
        }

        .card-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .text-truncate {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* === Badges === */
        .badge-pending { background-color: #ffc107; }
        .badge-completed { background-color: #28a745; }
        .badge-high { background-color: #dc3545; }
        .badge-medium { background-color: #fd7e14; }
        .badge-low { background-color: #0d6efd; }

        /* === Forms (Login / Signup) === */
        .auth-card {
            width: 400px;
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0,0,0,0.1);
            padding: 2rem;
            background-color: #fff;
        }

        .auth-card h4 {
            margin-bottom: 1.5rem;
            font-weight: bold;
            text-align: center;
        }

        .auth-card .form-control { border-radius: 8px; }
        .auth-card .btn { border-radius: 8px; }

        /* === Utilities === */
        .mt-4 { margin-top: 1.5rem !important; }
        .mb-3 { margin-bottom: 1rem !important; }
        .mb-4 { margin-bottom: 1.5rem !important; }
        .mb-2 { margin-bottom: .5rem !important; }
        .g-3 { gap: 1rem !important; }
    </style>
</head>
<body>

<!-- === Navbar === -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ route('task.index') }}">DeadlinePulse</a>

        @if(session('logged_in'))
        <div class="ms-auto d-flex">
            <a class="btn btn-light text-primary btn-nav" href="{{ route('task.create') }}">Add Task</a>
            <a class="btn btn-light text-success btn-nav" href="{{ route('task.completed') }}">Completed Tasks</a>
            <a class="btn btn-light text-danger btn-nav" href="{{ route('task.logout') }}">Logout</a>
        </div>
        @endif
    </div>
</nav>

<!-- === Content Section === -->
<div class="container mt-4">
    @yield('content')
</div>

</body>
</html>
