<!-- Using the layout of main.blade.php -->

<!-- adding the title -->
<?php $__env->startSection('title', 'Events'); ?>
<!-- adding the content of the main section -->
<?php $__env->startSection('content'); ?>
<div class="search-bar">
    <input type="text" id="search-input" placeholder="Search events...">
    <button type="button" id="search-button">Search</button>
    <div id="search-results"></div>
</div>
<!-- if user searches events with no title, description or location match -->
<?php if(empty($events)): ?>
<p>No events found.</p>
<?php else: ?>
<div class="events-grid">
    <?php $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="event-card">
        <div class="event-card-image <?php echo e(empty($event['image']) ? 'no-image' : ''); ?>">
            <!-- if image is kept, show image -->
            <?php if(!empty($event['image'])): ?>
            <img src="/assets/images/<?php echo e($event['image']); ?>" alt="<?php echo e($event['title']); ?>" loading="lazy">
            <?php else: ?>
            <!-- if no image exists -->
            Event Image
            <?php endif; ?>
        </div>
        <!-- a card of an event consist these data -->
        <div class="event-card-content">
            <h3><?php echo e($event['title']); ?></h3>
            <p><strong>Date:</strong> <?php echo e($event['date']); ?></p>
            <?php if(!empty($event['time'])): ?>
            <p><strong>Time:</strong> <?php echo e(date('H:i', strtotime($event['time']))); ?></p>
            <?php endif; ?>
            <p><strong>Location:</strong> <?php echo e($event['location']); ?></p>
            <p class="event-description">
                <?php echo e(strlen($event['description']) > 100 ? substr($event['description'], 0, 100) . '...' : $event['description']); ?>

            </p>
        </div>
        <div class="event-card-footer">
            <a href="/event.php?id=<?php echo e($event['id']); ?>">View Details</a>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script src="/assets/js/main.js"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/dada/Documents/University/3rd Semester/Full Stack Development/event_management_system/templates/events/list.blade.php ENDPATH**/ ?>