<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DeadlinePulse</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

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
            box-shadow: 0 2px 4px rgba(0,0,0,0.08);
            background: #fff;
            border: none;
            transition: box-shadow 0.2s, background 0.2s, color 0.2s, transform 0.12s cubic-bezier(.4,2,.6,1), filter 0.12s;
            font-weight: 600;
            position: relative;
        }
        .navbar .btn-nav:hover, .navbar .btn-nav:focus {
            box-shadow: 0 6px 18px rgba(13,110,253,0.13);
            background: #e7f1ff;
            filter: brightness(1.04);
            color: #0d6efd;
        }
        .navbar .btn-nav:active {
            transform: scale(0.96);
            box-shadow: 0 2px 6px rgba(13,110,253,0.18);
            filter: brightness(0.95);
        }
        /* Profile button avatar style */
        .navbar .profile-btn {
            display: flex;
            align-items: center;
            background: #f8fcff;
            border: none;
            color: #0a8ecf !important;
            border-radius: 50px;
            padding: 0.32rem 1.05rem 0.32rem 0.7rem;
            font-weight: 700;
            font-size: 1.08em;
            box-shadow: 0 2px 12px rgba(13,202,240,0.13);
            letter-spacing: 0.5px;
            transition: box-shadow 0.2s, background 0.2s, color 0.2s, transform 0.12s cubic-bezier(.4,2,.6,1), filter 0.12s;
        }
        .navbar .profile-btn:hover, .navbar .profile-btn:focus {
            background: #e3f6ff;
            color: #0a8ecf !important;
            box-shadow: 0 8px 28px rgba(13,202,240,0.18);
            filter: brightness(1.08);
        }
        .navbar .profile-btn:active {
            transform: scale(0.96);
            box-shadow: 0 2px 6px rgba(13,202,240,0.18);
            filter: brightness(0.95);
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

        /* === Scrollable Description === */
        .description-scroll {
            max-height: 300px;
            overflow-y: auto;
            padding-right: 10px;
            border-left: 4px solid #667eea;
            padding-left: 15px;
        }
        .description-scroll::-webkit-scrollbar {
            width: 8px;
        }
        .description-scroll::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        .description-scroll::-webkit-scrollbar-thumb {
            background: #667eea;
            border-radius: 10px;
        }
        .description-scroll::-webkit-scrollbar-thumb:hover {
            background: #764ba2;
        }
    </style>
</head>
<body>

<!-- === Navbar === -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ route('task.index') }}">DeadlinePulse</a>

        @if(session('logged_in'))
        <div class="d-flex w-100 align-items-center">
            <!-- Left group: Add/Completed -->
            <div class="d-flex align-items-center flex-grow-1">
                <a class="btn btn-nav me-2" style="background:#fff; color:#0d6efd;" href="{{ route('task.create') }}">
                    <i class="bi bi-plus-circle me-1" style="color:#0d6efd;"></i> Add Task
                </a>
                <a class="btn btn-nav fw-bold" style="background:#fff; color:#198754;" href="{{ route('task.completed') }}">
                    <i class="bi bi-check2-circle me-1" style="color:#198754;"></i> Completed Tasks
                </a>
            </div>
            <!-- Right group: Profile/Logout -->
            <div class="d-flex align-items-center ms-auto">
                <a class="btn profile-btn me-2" href="{{ route('task.profile') }}">
                    <i class="bi bi-person-circle me-1" style="color:#0a8ecf; font-size:1.3em;"></i> <span style="color:#0a8ecf; font-weight:700; letter-spacing:0.5px;">Profile</span>
                </a>
                <form action="{{ route('task.logout') }}" method="POST" style="display:inline;">
                  @csrf
                  <button type="submit" class="btn btn-nav fw-bold" style="background:#fff; color:#dc3545; border:none; cursor:pointer;">
                    <i class="bi bi-box-arrow-right me-1" style="color:#dc3545;"></i> Logout
                  </button>
                </form>
            </div>
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
