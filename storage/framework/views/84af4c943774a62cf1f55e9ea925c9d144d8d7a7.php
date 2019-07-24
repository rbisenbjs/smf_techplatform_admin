<form action="<?php echo e(route('jurisdictions.store')); ?>" id="jurisdictions-add-form" name="jurisdictions-add-form" method="post" class="marginTop">
   <?php echo e(csrf_field()); ?>     
<legend></legend>
	 <div class="form-group">
		 <label for="levelName" class="font-weight-bold required">Level Name</label>
		 <input type="text" required name="levelName" placeholder="Please enter Level Name" class="form-control"/>
	 </div>
	<input type="submit" value="Save" class="btn btn-primary btn-user btn-block"/>
 </form> 
<script>
$( '#jurisdictions-add-form' ).submit( function(event){
		event.preventDefault();		
		var data = new FormData( $( 'form#jurisdictions-add-form' )[ 0 ] );
	    $.ajax({
		  processData: false,
		  contentType: false,
		  data: data,
		  dataType: 'json',
		  type: 'POST',
		  url: 'http://localhost/smf_techplatform_php_new/public/saveEtype',
		  success: function( res ){			  
			if (res.code == 400) {
			  jQuery('#errorMsg').show();
			  jQuery('#errorMsg .alert-danger').show();	
			  jQuery('#errorMsg .alert-danger').html(res.msg);			 
			} else {					 
				location.reload(true);
			}
		  }
		});			
	 });


</script>          
 
