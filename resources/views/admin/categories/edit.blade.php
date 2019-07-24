<form id="category-edit-form" name="category-edit-form" method="post">

	{{csrf_field()}} 
	<h4>Name</h4>
	@foreach ($locale as $localeIdentifier => $localeLabel)
		<div class="form-group ml-4">
			<label for="{{$localeIdentifier}}">{{$localeLabel}}</label>
			<input maxlength="100" type="text" name="name[{{$localeIdentifier}}]" id="{{$localeIdentifier}}" class="form-control" value="{{$category->name[$localeIdentifier]}}"/>
			<small> Note: Character limit 100</small>
		</div>
	@endforeach
	@if ($errors->any())
		<div class="alert alert-danger">
			{{$errors->first()}}
		</div>
	@endif
	<div class="form-group">
		<label for="categoryType" class="font-weight-bold">Type</label>
		<select name="categoryType" class="form-control">			
			<option value="Form" @if($category->type === "Form") selected="selected" @endif> Form </option>                                            
			<option value="Reports" @if($category->type === "Reports") selected="selected" @endif> Reports </option>                                                                                                                                           
	</select>                                       
	</div>   
	<input id="id" name="id" value="{{$category->id}}" type="hidden">
	<input type="submit" value="Save" class="btn btn-primary btn-user btn-block"/>

</form>
<script>
 jQuery( '#category-edit-form' ).submit( function(event){
		
		event.preventDefault();		
		var data = new FormData( $( 'form#category-edit-form' )[ 0 ] );
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