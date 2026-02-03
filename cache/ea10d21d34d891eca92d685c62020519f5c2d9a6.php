<!-- Using the layout of main.blade.php -->

<!-- Using the title 'Login' -->
<?php $__env->startSection('title', 'Login'); ?>
<!-- Main content of the page -->
<?php $__env->startSection('content'); ?>
<div class="auth-wrapper">
    <div class="auth-container">
        <div class="auth-form">
            <h2>Login</h2>
            <!-- if there is any error, list out as unordered list -->
            <?php if(!empty($errors)): ?>
            <div class="errors">
                <ul>
                    <?php $__currentLoopData = $errors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
            <?php endif; ?>
            
            <form method="POST" action="/login.php">
                <input type="hidden" name="csrf_token" value="<?php echo e($csrf_token); ?>">
                
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                
                <button type="submit" style="width: 100%;">Login</button>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/dada/Documents/University/3rd Semester/Full Stack Development/event_management_system/templates/auth/login.blade.php ENDPATH**/ ?>