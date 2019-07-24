<form action="{{route('event-type.store')}}" method="post" class="marginTop" name="etype-add-form" id="etype-add-form">
{{csrf_field()}}
<div class="form-group">
	<label for="eventTypeName" class="font-weight-bold required">Name</label>
	<input type="text" name="name" required  placeholder="Event type Name" class="form-control"/>
	@if ($errors->any())
		<div class="alert alert-danger">
			{{$errors->first()}}
		</div>
	@endif
</div>
	   
 <div class="form-group">
		<label for="assocForms" class="font-weight-bold">Forms</label>
		<select name="associatedForms[]" class="form-control" multiple="multiple">
				@foreach($forms as $form)
				<option value="{{$form->id}}" >@if(is_array($form->name)){{$form->name['default']}}@else{{$form->name}} @endif</option>
				@endforeach                                                                                                                                        
		</select>                                       
	</div>                        
<input type="submit" value="Save" class="btn btn-primary btn-user btn-block"/>
</form>                        
<script>
$( '#etype-add-form' ).submit( function(event){
		event.preventDefault();		
		var data = new FormData( $( 'form#etype-add-form' )[ 0 ] );
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
