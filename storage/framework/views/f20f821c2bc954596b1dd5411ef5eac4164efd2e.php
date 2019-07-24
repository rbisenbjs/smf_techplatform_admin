<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">		
        <title><?php echo e(config('app.name', 'SMF Platform')); ?></title>
        <!-- Favicon -->
        <link href="<?php echo e(asset('argon')); ?>/img/brand/favicon.png" rel="icon" type="image/png">
        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css">
        <!-- Custom styles for this template-->
        <link href="<?php echo e(asset('css/sb-admin-2.css')); ?>" rel="stylesheet">
        <!-- Custom styles for this page -->
       
		 <link href="<?php echo e(asset('vendor/datatables/dataTables.bootstrap4.min.css')); ?>" rel="stylesheet">
        <link href="<?php echo e(asset('argon')); ?>/vendor/nucleo/css/nucleo.css" rel="stylesheet">
        <link href="<?php echo e(asset('argon')); ?>/vendor/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
		
        <!-- Argon CSS -->
        <link type="text/css" href="<?php echo e(asset('argon')); ?>/css/argon.css" rel="stylesheet">
    </head>
    <body class="<?php echo e($class ?? ''); ?>" id="page-top">
        <?php if(auth()->guard()->check()): ?>
            <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                <?php echo csrf_field(); ?>
            </form>
            <?php echo $__env->make('layouts.navbars.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php endif; ?>
        
        <div class="main-content">
            <?php echo $__env->make('layouts.navbars.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php echo $__env->yieldContent('content'); ?>
        </div>

        <?php if(auth()->guard()->guest()): ?>
            <?php echo $__env->make('layouts.footers.guest', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php endif; ?>

     <!--  <script src="<?php echo e(asset('argon')); ?>/vendor/jquery/dist/jquery.min.js"></script> -->
	    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	  <script src="https://cdnjs.cloudflare.com/ajax/libs/knockout/3.4.0/knockout-min.js"></script>
        <!-- modal pop up script begins-->
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" ></script>
        <!-- modal pop up script ends-->
        <script src="https://surveyjs.azureedge.net/1.0.56/survey.ko.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.0/ace.min.js" type="text/javascript" charset="utf-8"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.0/ext-language_tools.js" type="text/javascript" charset="utf-8"></script>
        <link href="https://surveyjs.azureedge.net/1.0.56/surveyeditor.css" type="text/css" rel="stylesheet"/>
        <script src="https://surveyjs.azureedge.net/1.0.56/surveyeditor.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>
        <!-- Custom scripts for all pages-->
         <script src="<?php echo e(asset('js/sb-admin-2.min.js')); ?>"></script>
        <!-- Page level plugins -->
        <script src="<?php echo e(asset('vendor/datatables/jquery.dataTables.min.js')); ?>"></script>
        <script src="<?php echo e(asset('vendor/datatables/dataTables.bootstrap4.min.js')); ?>"></script>
		
        <script src="<?php echo e(asset('argon')); ?>/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script> 
        
		 <!-- Page level custom scripts -->
    
     <script src="<?php echo e(asset('js/demo/datatables-demo.js')); ?>"></script>
        <script src="<?php echo e(asset('js/index.js')); ?>"></script>
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCN9EBtzan_vCEI7oXXd3WppkET11enCFg&libraries=places&callback=initMap" async defer></script>		
        <?php echo $__env->yieldPushContent('scripts'); ?>
		
		 <!-- Argon JS -->
        <script src="<?php echo e(asset('argon')); ?>/js/argon.js"></script>
    </body>
</html>