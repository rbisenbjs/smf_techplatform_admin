<?php echo Form::model($event_type, [ 'id' => 'eType-edit-form', 'class' => 'marginTop']); ?>


	<?php echo e(csrf_field()); ?> 
	<div class="form-group">
		<label for="eventTypeName" class="font-weight-bold required">Name</label>
		<input maxlength="100" type="text" required name="name" id="name" class="form-control" value="<?php echo e($event_type->name); ?>"/>
		<small> Note: Character limit 100</small>
	</div>
	<?php if($errors->any()): ?>
		<div class="alert alert-danger">
			<?php echo e($errors->first()); ?>

		</div>
	<?php endif; ?>

	<div class="form-group">
			<label for="assocForms" class="font-weight-bold">Forms</label>
			<select name="associatedForms[]" class="form-control" multiple="multiple">
					<?php $__currentLoopData = $forms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $form): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<option value="<?php echo e($form->id); ?>" <?php if(in_array($form->id,$event_type->survey_ids)): ?> selected ="selected" <?php endif; ?>><?php if(is_array($form->name)): ?><?php echo e($form->name['default']); ?> <?php else: ?> <?php echo e($form->name); ?> <?php endif; ?></option>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                                                                                                                                                
			</select>                                       
	</div>   
	<input type="hidden" value="<?php echo e($event_type->id); ?>" id="id" name="id"/>
	<input type="submit" value="Save" class="btn btn-primary btn-user btn-block"/>

<?php echo Form::close(); ?> 
<script>
 jQuery( '#eType-edit-form' ).submit( function(event){
		
		event.preventDefault();		
		var data = new FormData( $( 'form#eType-edit-form' )[ 0 ] );
	    jQuery.ajax({
		  processData: false,
		  contentType: false,
		  data: data,
		  dataType: 'json',
		  type: 'POST',
		  url: 'http://localhost/smf_techplatform_php_new/public/updateEtype',
		  success: function( res ){			  
			if (res.code == 400) {
			  jQuery('.alert-danger').show();	
			  jQuery('.alert-danger').html(res.msg);			 
			} else {					 
				location.reload(true);
			}
		  }
		});			
	 });
</script>