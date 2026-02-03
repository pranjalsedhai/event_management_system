<!-- Using the layout of main.blade.php -->


<!-- Displaying the event title -->
<?php $__env->startSection('title', $event['title']); ?>

<!-- Main content begins here -->
<?php $__env->startSection('content'); ?>
<div class="event-detail">

    <div class="event-detail-image <?php echo e(empty($event['image']) ? 'no-image' : ''); ?>">
        <!-- checks if there is any image of the event -->
        <?php if(!empty($event['image'])): ?>
            <img src="/assets/images/<?php echo e($event['image']); ?>" alt="<?php echo e($event['title']); ?>">
        <?php else: ?>
            <!-- if no image found display the below message -->
            Event Image
        <?php endif; ?>
    </div>

    <h2><?php echo e($event['title']); ?></h2>

    <div class="info">
        <p><strong>Date:</strong> <?php echo e($event['date']); ?></p>

        <?php if(!empty($event['time'])): ?>
            <p><strong>Time:</strong> <?php echo e(date('H:i', strtotime($event['time']))); ?></p>
        <?php endif; ?>

        <p><strong>Location:</strong> <?php echo e($event['location']); ?></p>

        <?php if($event['capacity'] > 0): ?>
            <p><strong>Capacity:</strong> <?php echo e($participant_count); ?> / <?php echo e($event['capacity']); ?></p>
        <?php else: ?>
            <p><strong>Participants:</strong> <?php echo e($participant_count); ?></p>
        <?php endif; ?>

        <?php if($event['capacity'] > 0 && $participant_count >= $event['capacity']): ?>
            <p class="event-full">Event is Full</p>
        <?php endif; ?>

        <p><strong>Organized by:</strong> <?php echo e($event['creator_name']); ?></p>
    </div>

    <div class="description">
        <h3>Description</h3>
        <p><?php echo e($event['description']); ?></p>
    </div>

    <!-- if the user is not logged in, they must login to participate the event -->
    <?php if(!$is_logged_in): ?>

        <div class="login-prompt">
            <p>
                <a href="/login.php">Login</a> or
                <a href="/register.php">Register</a> to join this event.
            </p>
        </div>

    <!-- if the user is logged in and not admin -->
    <?php elseif($is_logged_in && !$is_admin): ?>

        <!-- if the user has already joined the event -->
        <?php if($is_participating): ?>
            <form method="POST" action="/participate.php" style="display: inline-block; padding: 0; border: none; margin: 0;">
                <input type="hidden" name="csrf_token" value="<?php echo e($csrf_token); ?>">
                <input type="hidden" name="event_id" value="<?php echo e($event['id']); ?>">
                <input type="hidden" name="action" value="cancel">
                <button type="submit" class="btn-delete">Cancel Participation</button>
            </form>

        <!-- if the user has not joined the event -->
        <?php else: ?>

            <!-- check if event has unlimited capacity or still has available slots -->
            <?php if($event['capacity'] == 0 || $participant_count < $event['capacity']): ?>
                <form method="POST" action="/participate.php" style="display: inline-block; padding: 0; border: none; margin: 0;">
                    <input type="hidden" name="csrf_token" value="<?php echo e($csrf_token); ?>">
                    <input type="hidden" name="event_id" value="<?php echo e($event['id']); ?>">
                    <input type="hidden" name="action" value="join">
                    <button type="submit">Join Event</button>
                </form>
            <?php else: ?>
                <!-- if event is full -->
                <button disabled style="background: #999; cursor: not-allowed;">
                    Event Full
                </button>
            <?php endif; ?>

        <?php endif; ?>

    <?php endif; ?>

    <!-- if the user is admin -->
    <?php if($is_admin): ?>
        <div class="admin-actions">
            <h3>Admin Actions</h3>

            <!-- redirects to the edit, so that the admin can update the field -->
            <a href="/edit_event.php?id=<?php echo e($event['id']); ?>">
                <button type="button">Edit Event</button>
            </a>

            <!-- delete confirmation pops up if admin clicks delete -->
            <form method="POST"
                  action="/delete_event.php"
                  style="display: inline-block; padding: 0; border: none; margin: 0;"
                  onsubmit="return confirm('Are you sure you want to delete this event?');">

                <input type="hidden" name="csrf_token" value="<?php echo e($csrf_token); ?>">
                <input type="hidden" name="event_id" value="<?php echo e($event['id']); ?>">
                <button type="submit" class="btn-delete">Delete Event</button>
            </form>
        </div>
    <?php endif; ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/dada/Documents/University/3rd Semester/Full Stack Development/event_management_system/templates/events/single.blade.php ENDPATH**/ ?>