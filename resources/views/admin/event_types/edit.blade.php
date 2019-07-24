{!! Form::model($event_type, [ 'id' => 'eType-edit-form', 'class' => 'marginTop']) !!}

	{{csrf_field()}} 
	<div class="form-group">
		<label for="eventTypeName" class="font-weight-bold required">Name</label>
		<input maxlength="100" type="text" required name="name" id="name" class="form-control" value="{{$event_type->name}}"/>
		<small> Note: Character limit 100</small>
	</div>
	@if ($errors->any())
		<div class="alert alert-danger">
			{{$errors->first()}}
		</div>
	@endif

	<div class="form-group">
			<label for="assocForms" class="font-weight-bold">Forms</label>
			<select name="associatedForms[]" class="form-control" multiple="multiple">
					@foreach($forms as $form)
					<option value="{{$form->id}}" @if(in_array($form->id,$event_type->survey_ids)) selected ="selected" @endif>@if(is_array($form->name)){{$form->name['default']}} @else {{$form->name}} @endif</option>
					@endforeach                                                                                                                                                
			</select>                                       
	</div>   
	<input type="hidden" value="{{$event_type->id}}" id="id" name="id"/>
	<input type="submit" value="Save" class="btn btn-primary btn-user btn-block"/>

{!! Form::close() !!} 
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