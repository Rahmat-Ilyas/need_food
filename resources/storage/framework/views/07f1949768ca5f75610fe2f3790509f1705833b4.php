<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
    <meta name="author" content="Coderthemes">

    <link rel="shortcut icon" href="<?php echo e(asset('assets/images/fav.png')); ?>">

    <title>Login Admin - NeedFood</title>

    <link href="<?php echo e(asset('assets/css/bootstrap.min.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('assets/css/core.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('assets/css/components.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('assets/css/icons.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('assets/css/pages.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('assets/css/responsive.css')); ?>" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shiv and Respond.js') }} IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js') }} doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js') }}"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js') }}/1.3.0/respond.min.js') }}"></script>
    <![endif]-->

    <script src="<?php echo e(asset('assets/js/modernizr.min.js')); ?>"></script>

</head>
<body>

    <div class="account-pages"></div>
    <div class="clearfix"></div>
    <div class="wrapper-page">
       <div class=" card-box">
        <div class="panel-heading"> 
            <h3 class="text-center"><strong class="text-custom text-warning">NEED</strong>Food</h3>
        </div> 


        <div class="panel-body">
            <form class="form-horizontal m-t-20" method="POST" action="<?php echo e(route('admin.login.submit')); ?>">
                <?php echo e(csrf_field()); ?> 
                <div class="form-group ">
                    <div class="col-xs-12">
                        <input class="form-control" type="text" name="username" required="" value="<?php echo e(old('username')); ?>" placeholder="Username">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-xs-12">
                        <input class="form-control" type="password" name="password" required="" value="<?php echo e(old('password')); ?>" placeholder="Password">
                    </div>
                </div>

                <div class="form-group ">
                    <div class="col-xs-12">
                        <div class="checkbox checkbox-primary">
                            <input id="checkbox-signup" type="checkbox" name="remember">
                            <label for="checkbox-signup">
                                Remember me
                            </label>
                        </div>
                        
                    </div>
                </div>

                <?php if($errors->has('username')): ?>
                <div class="col-12">
                    <span class="text-danger"><?php echo e($errors->first('username')); ?></span>
                </div>
                <?php endif; ?>

                <?php if($errors->has('password')): ?>
                <div class="col-12">
                    <span class="text-danger"><?php echo e($errors->first('password')); ?></span>
                </div>
                <?php endif; ?>
                
                <div class="form-group text-center m-t-20">
                    <div class="col-xs-12">
                        <button class="btn btn-warning btn-block text-uppercase waves-effect waves-light" type="submit">Log In</button>
                    </div>
                </div>
            </form> 
            
        </div>   
    </div>

</div>




<script>
    var resizefunc = [];
</script>

<!-- jQuery  -->
<script src="<?php echo e(asset('assets/js/jquery.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/bootstrap.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/detect.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/fastclick.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/jquery.slimscroll.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/jquery.blockUI.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/waves.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/wow.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/jquery.nicescroll.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/jquery.scrollTo.min.js')); ?>"></script>


<script src="<?php echo e(asset('assets/js/jquery.core.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/jquery.app.js')); ?>"></script>

</body>
</html><?php /**PATH C:\xampp\htdocs\kesiniku1\resources\resources\views/admin/login.blade.php ENDPATH**/ ?>