
<form method="POST"  accept-charset="UTF-8" id="microservice-edit-form" class="marginTop">
	{{csrf_field()}} 
	<legend></legend>
	<div class="form-group">
		<label for="microserviceName" class="font-weight-bold required">Name</label>
		<input type="text" name="name"  required placeholder="Name of the microservice"class="form-control" value="{{$microservice->name}}"/>
		<small> Note: Character limit 100</small> 
	</div>   
	<div class="form-group">
		<label for="microserviceDescription" class="font-weight-bold">Description</label>
		<input type="text" name="description"  placeholder="Description"class="form-control" value="{{$microservice->description}}"/>
		<input  type="hidden" id="id" name="id" value="{{ $microservice->id}}"	>
		<small> Note: Character limit 1000</small> 
	</div>   
		  
	<div class="form-check">
	@if($microservice->is_active == true)
		<input type="checkbox" name="active"  checked/>
		@else
		<input type="checkbox" name="active" />
		@endif
		<label for="microserviceActive" class="font-weight-bold">Active</label>
	</div>                 
	<input type="submit" value="Save" class="btn btn-primary btn-user btn-block"/>
	</form>


 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
 <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" ></script>
 <script src="{{ asset('js/index.js') }}"></script> 
@stack('scripts')