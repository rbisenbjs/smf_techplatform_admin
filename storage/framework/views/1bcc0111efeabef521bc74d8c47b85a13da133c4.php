<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('layouts.headers.cards', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<meta name="csrf-token" content="">
<!-- Begin Page Content -->
<div class="container-fluid">

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Users</h1>
<p class="mb-4">
<?php if(session('status')): ?>
  <div class="alert alert-success">
      <?php echo e(session('status')); ?>

  </div>
<?php endif; ?>
</p>
<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
   <h6 class="m-0 font-weight-bold text-primary">
        <a href="/<?php echo e($orgId); ?>/addUser" class="btn btn-primary btn-icon-split">
        <span class="icon text-white-50">
            <i class="fas fa-plus"></i>
        </span>
        <span class="text">User</span>
        </a>
    </h6> 
	<!--<a  data-toggle="modal" data-target="#exampleModal" class="btn btn-success"> <i class="fas fa-plus"></i> <span class="text">User</span></a>
  -->
  
  </div>
  



  
  
  
  



  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>Name</th>
            <th>Email</th>
			<th>Phone</th>
            <th>Action</th>
          </tr>
        </thead>
        <tfoot>
         <tr>
            <th>Name</th>
            <th>Email</th>
			<th>Phone</th>
            <th>Action</th>
          </tr>
        </tfoot>
        <tbody id="userTable">

        <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <tr>
            <td><?php echo e($user->name); ?></td>
            <td><?php echo e($user->email); ?></td>
			<td><?php echo e($user->phone); ?></td>
            <td>
                <div class="actions">
                  <div style="float:left !important;padding-left:5px;">
                      <a class="btn btn-primary btn-circle btn-sm" href="/editUser/<?php echo e($user->id); ?>"><i class="fas fa-pen"></i></a>
                  </div>
                  <div style="float:left !important;padding-left:5px;">
                    <!-- <form action="<?php echo e(url('user',$user->id)); ?>" method="POST">
                        <?php echo e(csrf_field()); ?>

                        <?php echo e(method_field('DELETE')); ?>

						
                        <button type="submit" class="btn btn-danger btn-circle btn-sm"><i class="fas fa-trash"></i></button>
                    </form> -->
					
						<button data-toggle="modal" onclick="deleteUserConfirmation('<?php echo e($user->id); ?>');" class="btn btn-danger btn-circle btn-sm deleteButton"><i class="fas fa-trash"></i></button> 

                  </div>
                  <div style="clear:both !important;"></div>
                </div>
            </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td>no users</td></tr>
        <?php endif; ?>





        </tbody>
      </table>
    </div>
  </div>
</div>

<?php echo $__env->make('layouts.footers.auth', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	
</div>
<!-- /.container-fluid -->

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
         <h5 class="modal-title" id="exampleModalLabel">Create Form</h5> 	
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
       <div class="modal-body">	  
			<div class="row">			
				<div class="card-body px-lg-2 py-lg-0">

					<div class="alert alert-danger" role="alert""></div>
					<form action="<?php echo e(route('users.store')); ?>" method="post" class="form-horizontal">
                           <?php echo e(csrf_field()); ?> 

						<div class="form-group row">
							<label class="col-md-3 col-form-label"><b>Is Org Admin</b></label>
							<div class="col-sm-6 mb-3 mb-sm-0">
							<input type="checkbox" name="is_admin" />
							</div>
						</div>
						
                        <div class="form-group row">
                            <label  class="col-md-3 required" for="name"  >Name</label>
                            <div class="col-sm-3">
                                <input id="name" type="text" class="form-control form-control-user" placeholder="Name" name="name" value="<?php echo e(old('name')); ?>" required autofocus>
                                <?php if($errors->has('name')): ?>
                                <span class="help-block">
                                <strong><?php echo e($errors->first('name')); ?></strong>
                                </span>
                                <?php endif; ?>
                            </div>							
							 
                        </div>
						<!-- </div> -->
						<div class="form-group row">
						<label for="email" class="col-md-3 required" >Email</label>
						<div class="col-sm-6 mb-3 mb-sm-0">
						  <input id="email" type="email" class="form-control form-control-user" name="email" value="<?php echo e(old('email')); ?>" required placeholder="E-Mail Address">
							<?php if($errors->has('email')): ?>
								<span class="help-block">
									<strong><?php echo e($errors->first('email')); ?></strong>
								</span>
							<?php endif; ?>
							</div>
						</div>
						<div class="form-group row">
						<label for="password" class="col-md-3 required">Password</label>
						  <div class="col-sm-6 mb-3 mb-sm-0">
							<input id="password" type="password" class="form-control form-control-user" name="password" required placeholder="Password">
							  <?php if($errors->has('password')): ?>
								  <span class="help-block">
									  <strong><?php echo e($errors->first('password')); ?></strong>
								  </span>
							  <?php endif; ?>
						  </div>
						 
						</div>
						<div class="form-group row">
							<label class="col-md-3"  for="phone"><?php echo e(__('Phone Number')); ?></label>
							<div class="col-sm-6 mb-3 mb-sm-0 required">
							<input id="phone" type="text" class="form-control form-control-user" name="phone" value="<?php echo e(old('phone')); ?>" required placeholder="Phone Number">
							  
								<?php if($errors->has('phone')): ?>
									<b style="color:red"><?php echo e($errors->first('phone')); ?></b>
								<?php endif; ?>
							  </div>
						</div>
						<div class="form-group row date" data-provide="datepicker">
						
						<label for="dob" class="col-md-3 col-form-label"><?php echo e(__('Date Of Birth')); ?></label>
						<div class="col-sm-6 mb-3 mb-sm-0">
							<input  name="dob" class="form-control form-control-user" placeholder="Date Of Birth">
							
							<div class="input-group-addon">
							  <span class="glyphicon glyphicon-th"></span>
							</div>
							<?php if($errors->has('dob')): ?>
							<span class="invalid-feedback" role="alert">
								<strong><?php echo e($errors->first('dob')); ?></strong>
							</span>
							<?php endif; ?>
						  </div>
						</div>
						
						<div class="form-group row">
							<label for="gender" class="col-md-3 col-form-label"><?php echo e(__('Gender')); ?></label>
							<div class="col-sm-6 mb-3 mb-sm-0">
								<select name="gender" class="form-control" type="select" id="navbarDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								  <option value="male">Male</option>
								  <option value="female">Female</option>
								  <option value="other">Other</option>
								</select>
							</div>
							<?php if($errors->has('gender')): ?>
								<span class="invalid-feedback" role="alert">
									<strong><?php echo e($errors->first('gender')); ?></strong>
								</span>
							<?php endif; ?>
						</div>
                
						<div class="form-group row">
							<label for="role_id" class="col-md-3 col-form-label required">Role</label>
							<div class="col-sm-6 mb-3 mb-sm-0">
							
								<select id="role_id"  class="form-control" name="role_id" required>
									<?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<option value=<?php echo e($role['_id']); ?>><?php echo e($role['display_name']); ?></option>
											<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								</select>
								
								<?php if($errors->has('role_id')): ?>   
								<b style="color:red"><?php echo e($errors->first('role_id')); ?></b>
								<?php endif; ?>
							
							</div>
						</div>               
					<button type="submit" value="Save" class="btn btn-primary btn-user">Save</button>                
                </form>
				
				

				
				</div>
			</div>
		</div>
	</div>
		</div>	</div>
		</div>
<!-- set up the modal to start hidden and fade in and out -->
<div id="deleteModel" class="modal fade" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- dialog body -->
            <div class="modal-body">               
               Are you sure want to delete this user ?
            </div>
            <!-- dialog buttons -->
            <div class="modal-footer">
				<button type="button" onclick="closeModel('deleteModel')" class="btn btn-primary">No</button>
				<button type="button" class="btn btn-primary" onclick="deleteUser();">Yes</button>
			</div>
			
        </div>
    </div>
		
</div>
    		
		
<?php $__env->stopSection(); ?>

<script type="text/javascript">

	function deleteUserConfirmation(userId) 
	{
		//alert('xxxxxxxxxxxxxxx');
		mirId = userId;		
		$('#deleteModel').modal('show');			
	}


	function deleteUser() {		
		console.log(mirId);	
		var _token = $("input[name='_token']").val();	
		jQuery.ajax({		  
		  data: {userId:mirId, _token:_token},
		  dataType: 'json',
		  type: 'POST',
		  url: 'http://localhost/smf_techplatform_php_new/public/deleteUser',
		  success: function( res ){			  
			if (res.code == 400) {
			  jQuery('.alert-danger').show();	
			  jQuery('.alert-danger').html(res.msg);			 
			} else {
				$('#deleteModel').modal('hide');				
				location.reload(true);
			}
		  }
		});		
			
	}




</script>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>