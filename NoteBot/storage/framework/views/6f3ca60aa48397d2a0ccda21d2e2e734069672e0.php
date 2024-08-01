<?php $__env->startSection('content'); ?>
    <div class="row container" style="margin:auto; margin-top: 10%;">
        <div class="col-md-6 all-center">
            <h1 class="bold">NoteBot</h1>
            <div class="d-flex" style="align-items:center;gap:10px;">
                <h1 class="bold">Notes</h1>
                <h2 class="bold" style="color:white !important">Taking Assistant</h2>
            </div>
            <p style="color:white">Capture Thoughts, Your Way!, </p>
            <p style="color:white">Where Words and Voices Unite! </p>
            <p style="color:white">Speak, Record, Write-Your Ideas, Your Way!.</p>
            <a href="<?php echo e(route('login_signup')); ?>"><button class="theme-button mt-3" style="width: 250px;">Start Taking Notes</button></a>
        </div>
        <div class="col-md-6">
            <img src="<?php echo e(asset('uploads/intro_image.png')); ?>" alt="">
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout/layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\final_year_project\resources\views/introduction.blade.php ENDPATH**/ ?>