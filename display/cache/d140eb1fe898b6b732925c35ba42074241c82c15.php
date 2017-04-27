<?php $__env->startSection('content'); ?>

<?php if(isset($q)): ?>
    <?php

    $db = new Core\Database\Database();
    $db->select('entries', ['word', '=', $q]);

    ?>
    <?php if($db->count()): ?>
        <?php $__currentLoopData = $db->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <?php echo e($item->word); ?>

                </div>
                <div class="panel-body">
                    <?php echo e($item->definition); ?>

                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>