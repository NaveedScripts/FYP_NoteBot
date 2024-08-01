
<?php $__env->startSection('content'); ?>
    <script src="https://cdn.tiny.cloud/1/o9g17apj7kmskvkthmya4zmtfbkkzca2kux2sqao86loc5y0/tinymce/7/tinymce.min.js">
    </script>
    <style>
        .viewtab{
            background: #f0f0f0;
            padding: 20px;
            border-radius: 20px;

        }
    </style>
    <div class="textarea_container m-5">
        <h1>NotBot</h1>
       <div class="d-flex" style="align-items: center;gap: 10px;flex-wrap: wrap;margin-bottom: 20px;">
        <h2 class="" style="color:white !important;">Viewing Book:</h2>
        <div style="display: flex; align-items: center;gap:20px;">
            <h1 style="color:white !important;" class="bold"><?php echo e($nav_title); ?></h1>
            <img style="width: 60px;border-radius: 50%;border: 2px solid white;height: 60px;object-fit: cover;"
                src="<?php echo e(asset((isset($image) && $image) ? $image : 'uploads/default-profile.jpg')); ?>" alt="">
        </div>
       </div>
        
        <div class="viewtab"><?php echo (isset($book->content->content) && $book->content->content) ? $book->content->content : 'No Content Available'; ?></div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout/layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\final_year_project\resources\views/shareBook.blade.php ENDPATH**/ ?>