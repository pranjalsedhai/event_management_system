<!-- Using the layout of main.blade.php -->

<!-- Use the title as "Register" -->
<?php $__env->startSection('title', 'Register'); ?>

<!-- Main section of the page -->
<?php $__env->startSection('content'); ?>
<div class="auth-wrapper">
    <div class="auth-container">
        <div class="auth-form">
            <h2>Register</h2>

            <!-- if any errors, listed in unordered list -->
            <?php if(!empty($errors)): ?>
            <div class="errors">
                <ul>
                    <?php $__currentLoopData = $errors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
            <?php endif; ?>

            <!-- If the registration is successful, redirects to login -->
            <?php if($success): ?>
            <div class="success">
                Registration successful! <a href="/login.php">Login here</a>
            </div>
            <?php else: ?>
            <form method="POST" action="/register.php" style="padding: 0; border: none;">
                <input type="hidden" name="csrf_token" value="<?php echo e($csrf_token); ?>">
                
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                    <div id="email-error" class="error"></div>
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                
                <div class="form-group">
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>
                
                <button type="submit" style="width: 100%;">Register</button>
            </form>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script src="/assets/js/main.js"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/dada/Documents/University/3rd Semester/Full Stack Development/event_management_system/templates/auth/register.blade.php ENDPATH**/ ?>