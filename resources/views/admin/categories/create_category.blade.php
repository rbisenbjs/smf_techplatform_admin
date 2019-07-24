<form  method="post" id="create_category_form" name="create_category_form">
{{csrf_field()}}
<h4>Name</h4>
@foreach ($locale as $localeIdentifier => $localeLabel)
<div class="form-group ml-4">
	<label for="{{$localeIdentifier}}" class="required">{{$localeLabel}}</label>
	<input maxlength="100"  type="text" required name="name[{{$localeIdentifier}}]" id="{{$localeIdentifier}}" class="form-control" value="{{old('name.'.$localeIdentifier)}}"/>
	<small> Note: Character limit 100</small>
</div>
@endforeach
@if ($errors->any())
	 <div class="alert alert-danger">
		 {{$errors->first()}}
	 </div>
@endif
	   
 <div class="form-group">
		<label for="categoryType" class="font-weight-bold required">Type</label>
		<select required name="categoryType" class="form-control">
				<option value="Form"> Form </option>                                            
				<option value="Reports"> Reports </option>                                                                                                                                           
		</select>                                       
	</div>                        
<input type="submit" value="Save" class="btn btn-primary btn-user btn-block"/>
</form>  
<script>
$( '#create_category_form' ).submit( function(event){
		event.preventDefault();		
		var data = new FormData( $( 'form#create_category_form' )[ 0 ] );
	    $.ajax({
		  processData: false,
		  contentType: false,
		  data: data,
		  dataType: 'json',
		  type: 'POST',
		  url: 'http://localhost/smf_techplatform_php_new/public/storecategory',
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
