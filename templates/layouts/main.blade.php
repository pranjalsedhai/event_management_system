<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- placeholder to be filled by a child template -->
    <title>@yield('title', 'Event Management')</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1><a href="/">Event Management System</a></h1>
            <nav>
                <a href="/">Events</a>
                <!-- Validating whether a user is logged in or not -->
                @if(isset($is_logged_in) && $is_logged_in)
                    <!-- Show Add event button only for admin -->
                    @if(isset($is_admin) && $is_admin)
                        <a href="/add_event.php">Add Event</a>
                    @endif
                    <a href="/logout.php">Logout</a>
                @else
                    <a href="/login.php">Login</a>
                    <a href="/register.php">Register</a>
                @endif
            </nav>
        </div>
    </header>

    <main class="container">
        @yield('content')
    </main>
    
    <footer>
        <div class="container">
            <p>Pranjal Sedhai &copy; 2026 Event Management System. All rights reserved.</p>
        </div>
    </footer>
    
    @yield('scripts')
</body>
</html>