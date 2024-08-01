<div style="display: flex;align-items: center;justify-content: space-between;    margin: 0px 40px;    flex-wrap: wrap;"
    class="mt-4 center-mobile">
    <div class="all-center" style="flex-direction: row;align-items: center;gap: 20px;    flex-wrap: wrap;">
        <a href="<?php echo e($back_link); ?>"><button class="theme-button " style="width: 150px;">Back</button></a>
        <div style="display: flex; align-items: center;gap:20px;">
            <h1 style="color:white !important;" class="bold"><?php echo e($nav_title); ?></h1>
            <img style="width: 60px;border-radius: 50%;border: 2px solid white;height: 60px;object-fit: cover;"
                src="<?php echo e(asset((isset($image) && $image) ? $image : 'uploads/default-profile.jpg')); ?>" alt="">
        </div>
    </div>
    <div class="">
        <h1 style="margin: 0px" class="bold">NotBot</h1>
        <small style="color: white;float: right;">Welcome <?php echo e(Auth::user()->fullname); ?></small><br>
        <a href="#" onclick="logout()"
            style="color: white; float: right; font-weight: bold; cursor: pointer;">Logout</a>
        <script>
            function logout() {
                if (confirm('Are you sure you want to logout?')) {
                    window.location.href = '<?php echo e(route('logout')); ?>';
                }
            }
        </script>
    </div>
</div>
<?php /**PATH C:\xampp\final_year_project\resources\views/partials/navbar.blade.php ENDPATH**/ ?>