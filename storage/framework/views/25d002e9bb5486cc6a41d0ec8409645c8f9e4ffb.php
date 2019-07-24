<?php $__env->startSection('content'); ?>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <!-- <h1 class="h3 mb-0 text-gray-800"><?php echo e($pagetitle); ?></h1> -->
</div>
<div class="row-landing" style="text-align:center">
    <div class="col-xl-8-landing col-lg-7">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"><?php echo e($pagetitle); ?></h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <div class="chart-area">
                    <p>You can login to portal using
                        <!-- <a href="/login" class="btn btn-primary btn-lg" >Login</a> -->
                        <a href="/login" class="btn btn-primary btn-icon-split btn-sm">
                            <span class="icon text-white-50">
                            <i class="fas fa-arrow-right"></i>
                            </span>
                            <span class="text">Login</span>
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Content Row -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', ['title' => __('User Management')], \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>