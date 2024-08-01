<?php $__env->startSection('content'); ?>
    <div class="container center">
        <div class="row">
            <div class="col-md-6 mx-auto">
                <?php echo $__env->make('partials/notification', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                <div class="signin_tab">
                    <div class="col-md-12 text-center mb-4">
                        <h1 style="font-weight: bold;">NoteBot</h1>
                    </div>
                    <div class="myform form ">
                        <div class="logo mb-3">

                        </div>
                        <form action="<?php echo e(route('login')); ?>" method="post" name="login" id="login_form">
                            <?php echo csrf_field(); ?>
                            <h3 style="color: #c0b7e8 !important;">Sign In</h3>
                            <p class="bold">To Continue NoteBot</p>

                            <div class="form-group">
                                <label for="exampleInputEmail11">Email address</label>
                                <input type="email" name="email" class="form-control" id="email"  placeholder="Enter email">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail11">Password</label>
                                <input type="password" name="password" id="password" class="form-control"  placeholder="Enter Password">
                            </div>
                            <div class="form-group">
                                <p class="text-center">By signing up you accept our <a href="#">Terms Of Use</a></p>
                            </div>
                            <div class="col-md-12 text-center ">
                                <button type="submit" class=" btn btn-block mybtn btn-primary tx-tfm theme-button">Login</button>
                            </div>
                            <div class="col-md-12 ">
                                <div class="login-or">
                                    <hr class="hr-or">
                                    <span class="span-or">OR</span>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <p class="text-center">
                                    <a href="#" class="google btn mybtn call_signup_tab"><i class="fa fa-google-plus">
                                        </i> Signup Your Account
                                    </a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="signup_tab">
                    <div class="col-md-12 text-center mb-4">
                        <h1 style="font-weight: bold;">NoteBot</h1>
                    </div>
                    <div class="myform form ">
                        <div class="logo mb-3">

                        </div>
                        <form action="<?php echo e(route('signup')); ?>" method="post" name="signup" id="signup_form">
                            <?php echo csrf_field(); ?>
                            <h3 style="color: #c0b7e8 !important;">Sign Up</h3>
                            <p class="bold">To Continue NoteBot</p>

                            <div class="form-group">
                                <label for="exampleInputfullname1">Full Name</label>
                                <input type="text" name="fullname" class="form-control" id="fullname"
                                    aria-describedby="fullnameHelp" placeholder="Enter Full Name">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email address</label>
                                <input type="email" name="email" class="form-control" id="email"
                                    aria-describedby="emailHelp" placeholder="Enter email">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputphonenumber1">Phone Number</label>
                                <input type="number" name="phonenumber" class="form-control" id="phonenumber"
                                    aria-describedby="phonenumberHelp" placeholder="Enter Phone Number">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password" class="form-control"
                                    aria-describedby="emailHelp" placeholder="Enter Password">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Confirm Password</label>
                                <input type="password" name="password_confirmation" id="passwordconfirm"
                                    class="form-control" aria-describedby="emailHelp" placeholder="Enter Passwordconfirm">
                            </div>
                            <div class="form-group">
                                <p class="text-center">By signing up you accept our <a href="#">Terms Of Use</a></p>
                            </div>
                            <div class="col-md-12 text-center ">
                                <button type="submit" class=" btn btn-block mybtn btn-primary tx-tfm theme-button">Signup</button>
                            </div>
                            <div class="col-md-12 ">
                                <div class="login-or">
                                    <hr class="hr-or">
                                    <span class="span-or">OR</span>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <p class="text-center">
                                    <a href="#" class="google btn mybtn call_signin_tab"><i class="fa fa-google-plus">
                                        </i> Login Your Account
                                    </a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout/layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\final_year_project\resources\views/index.blade.php ENDPATH**/ ?>