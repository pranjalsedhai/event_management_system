<!-- Using the layout of main.blade.php -->

<!-- adding the title -->
<?php $__env->startSection('title', 'Edit Event'); ?>
<!-- adding the content of the main section -->
<?php $__env->startSection('content'); ?>
<div class="form-wrapper">
    <div class="form-container">
        <h2>Edit Event</h2>
        <!-- check if there is any error while adding an event -->  
        <?php if(!empty($errors)): ?>
        <div class="errors">
            <ul>
                 <!-- display the error in unordered list -->
                <?php $__currentLoopData = $errors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
        <?php endif; ?>

        <form method="POST" action="/edit_event.php?id=<?php echo e($event['id']); ?>" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?php echo e($csrf_token); ?>">
            
            <div class="form-group">
                <label for="title">Event Title</label>
                <input type="text" id="title" name="title" value="<?php echo e($event['title']); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" required><?php echo e($event['description']); ?></textarea>
            </div>
            
            <div class="form-group">
                <label for="date">Date</label>
                <input type="date" id="date" name="date" value="<?php echo e($event['date']); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="time">Time</label>
                <input type="time" name="time" id="time" value="<?php echo e(substr($event['time'], 0, 5)); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="location">Location</label>
                <input type="text" id="location" name="location" value="<?php echo e($event['location']); ?>" required>
            </div>

            <div class="form-group">
                <label for="capacity">Maximum Participants</label>
                <input type="number" id="capacity" name="capacity" min="0" value="<?php echo e($event['capacity'] ?? 0); ?>">
            </div>
            
            <div class="form-group">
                <label for="image">Event Image (optional)</label>
                <!-- If the image exist, shows the image name -->
                <?php if(!empty($event['image'])): ?>
                <p>Current: <?php echo e($event['image']); ?></p>
                <?php endif; ?>
                <input type="file" id="image" name="image" accept="image/*">
            </div>
            
            <button type="submit" style="width: 100%;">Update Event</button>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/dada/Documents/University/3rd Semester/Full Stack Development/event_management_system/templates/events/edit.blade.php ENDPATH**/ ?>