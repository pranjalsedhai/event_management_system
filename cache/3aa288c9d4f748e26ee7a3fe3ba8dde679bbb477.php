<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- placeholder to be filled by a child template -->
    <title><?php echo $__env->yieldContent('title', 'Event Management'); ?></title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1><a href="/">Event Management System</a></h1>
            <nav>
                <a href="/">Events</a>
                <!-- Validating whether a user is logged in or not -->
                <?php if(isset($is_logged_in) && $is_logged_in): ?>
                    <!-- Show Add event button only for admin -->
                    <?php if(isset($is_admin) && $is_admin): ?>
                        <a href="/add_event.php">Add Event</a>
                    <?php endif; ?>
                    <a href="/logout.php">Logout</a>
                <?php else: ?>
                    <a href="/login.php">Login</a>
                    <a href="/register.php">Register</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <main class="container">
        <?php echo $__env->yieldContent('content'); ?>
    </main>
    
    <footer>
        <div class="container">
            <p>Pranjal Sedhai &copy; 2026 Event Management System. All rights reserved.</p>
        </div>
    </footer>
    
    <?php echo $__env->yieldContent('scripts'); ?>
</body>
</html><?php /**PATH /home/dada/Documents/University/3rd Semester/Full Stack Development/event_management_system/templates/layouts/main.blade.php ENDPATH**/ ?>