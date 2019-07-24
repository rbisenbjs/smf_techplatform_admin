<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">
        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Brand -->
        <a class="navbar-brand pt-0" href="<?php echo e(route('home')); ?>">
            <img src="<?php echo e(asset('argon')); ?>/img/brand/bjs_logo.png" class="navbar-brand-img" alt="...">
        </a>
        <!-- User -->
        <ul class="nav align-items-center d-md-none">
		
			
            <li class="nav-item dropdown">
                <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="media align-items-center">
                        <span class="avatar avatar-sm rounded-circle">
                        <img alt="Image placeholder" src="<?php echo e(asset('argon')); ?>/img/theme/team-1-800x800.jpg">
                        </span>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                    <div class="dropdown-header noti-title">
                        <h6 class="text-overflow m-0"><?php echo e(__('Welcome!')); ?></h6>
                    </div>
                    <a href="<?php echo e(route('profile.edit')); ?>" class="dropdown-item">
                        <i class="ni ni-single-02"></i>
                        <span><?php echo e(__('My profile')); ?></span>
                    </a>
                    <a href="#" class="dropdown-item">
                        <i class="ni ni-settings-gear-65"></i>
                        <span><?php echo e(__('Settings')); ?></span>
                    </a>
                    <a href="#" class="dropdown-item">
                        <i class="ni ni-calendar-grid-58"></i>
                        <span><?php echo e(__('Activity')); ?></span>
                    </a>
                    <a href="#" class="dropdown-item">
                        <i class="ni ni-support-16"></i>
                        <span><?php echo e(__('Support')); ?></span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="<?php echo e(route('logout')); ?>" class="dropdown-item" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                        <i class="ni ni-user-run"></i>
                        <span><?php echo e(__('Logout')); ?></span>
                    </a>
                </div>
            </li>
        </ul>
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
            <!-- Collapse header -->
            <div class="navbar-collapse-header d-md-none">
                <div class="row">
                    <div class="col-6 collapse-brand">
                        <a href="<?php echo e(route('home')); ?>">
                            <img src="<?php echo e(asset('argon')); ?>/img/brand/bjs_logo.png">
                        </a>
                    </div>
                    <div class="col-6 collapse-close">
                        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>
            <!-- Form -->
            <form class="mt-4 mb-3 d-md-none">
                <div class="input-group input-group-rounded input-group-merge">
                    <input type="search" class="form-control form-control-rounded form-control-prepended" placeholder="<?php echo e(__('Search')); ?>" aria-label="Search">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="fa fa-search"></span>
                        </div>
                    </div>
                </div>
            </form>
            <!-- Navigation -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('home')); ?>">
                        <i class="ni ni-tv-2 text-primary"></i> <?php echo e(__('Dashboard')); ?>

                    </a>
                </li>			
				
                <!--<li class="nav-item">
                    <a class="nav-link active" href="#navbar-examples" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-examples">
                        <i class="fab fa-laravel" style="color: #f4645f;"></i>
                        <span class="nav-link-text" style="color: #f4645f;"><?php echo e(__('Laravel Examples')); ?></span>
                    </a>

                    <div class="collapse show" id="navbar-examples">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo e(route('profile.edit')); ?>">
                                    <?php echo e(__('User profile')); ?>

                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo e(route('user.index')); ?>">
                                    <?php echo e(__('User Management')); ?>

                                </a>
                            </li>
                        </ul>
                    </div>
                </li> -->
			 <?php if(Session::get('userRole') == 'ADMIN'): ?> 
				 
				<li class="nav-item">
                    <a class="nav-link" href="/<?php echo e($orgId); ?>/userlist">
                        <i class="ni ni-cloud-download-95"></i>Users
                    </a>
                </li>
				
                <li class="nav-item">
                    <a class="nav-link" href="/<?php echo e($orgId); ?>/forms">
                        <i class="ni ni-planet text-blue"></i> <?php echo e(__('Forms')); ?>

                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/<?php echo e($orgId); ?>/microservices">
                        <i class="ni ni-pin-3 text-orange"></i> <?php echo e(__('Microservices')); ?>

                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/<?php echo e($orgId); ?>/entities">
                        <i class="ni ni-key-25 text-info"></i> <?php echo e(__('Entities')); ?>

                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/<?php echo e($orgId); ?>/categories">
                        <i class="ni ni-button-power text-green"></i> <?php echo e(__('Categories')); ?>

                    </a>
                </li>
				
				 <li class="nav-item">
                    <a class="nav-link" href="/<?php echo e($orgId); ?>/event-types">
                        <i class="ni ni-money-coins text-blue"></i> <?php echo e(__('Event Types')); ?>

                    </a>
                </li>
				
				
				 <li class="nav-item">
                    <a class="nav-link" href="/<?php echo e($orgId); ?>/jurisdictions">
                        <i class="ni ni-book-bookmark text-black"></i> <?php echo e(__('Jurisdictions')); ?>

                    </a>
                </li>
				
				<li class="nav-item">
                    <a class="nav-link" href="/<?php echo e($orgId); ?>/jurisdiction-types">
                        <i class="ni ni-ui-04 text-red"></i> <?php echo e(__('Jurisdiction Types')); ?>

                    </a>
                </li>
				
				
				<li class="nav-item">
                    <a class="nav-link" href="/<?php echo e($orgId); ?>/locations">
                        <i class="ni ni-pin-3 text-blue"></i> <?php echo e(__('Locations')); ?>

                    </a>
                </li>
			
				
              
			<?php endif; ?>

			<?php if(Session::get('userRole') == 'ROOTORGADMIN'): ?>
				
				<li class="nav-item">
                    <a class="nav-link" href="<?php echo e(url('/users')); ?>">
                        <i class="ni ni-cloud-download-95"></i>Users
                    </a>
                </li>
				
				<li class="nav-item">
                    <a class="nav-link" href="<?php echo e(url('/role')); ?>">
                        <i class="ni ni-cloud-download-95"></i>Roles
                    </a>
                </li>
				
				<li class="nav-item">
                    <a class="nav-link" href="<?php echo e(url('/organisation')); ?>">
                        <i class="ni ni-cloud-download-95"></i>Organisations
                    </a>
                </li>
			<?php endif; ?>		
            </ul>
            <!-- Divider -->
           <!--  <hr class="my-3">
            <!-- Heading -->
           <!-- <h6 class="navbar-heading text-muted">Documentation</h6>
            <!-- Navigation -->
          <!--  <ul class="navbar-nav mb-md-3">
                <li class="nav-item">
                    <a class="nav-link" href="https://demos.creative-tim.com/argon-dashboard/docs/getting-started/overview.html">
                        <i class="ni ni-spaceship"></i> Getting started
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="https://demos.creative-tim.com/argon-dashboard/docs/foundation/colors.html">
                        <i class="ni ni-palette"></i> Foundation
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="https://demos.creative-tim.com/argon-dashboard/docs/components/alerts.html">
                        <i class="ni ni-ui-04"></i> Components
                    </a>
                </li>
            </ul> -->
        </div>
    </div>
</nav>