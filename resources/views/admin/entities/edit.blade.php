{!! Form::model($entity, ['route' => [ 'entity.update', $entity->id ], 'method'=>'PUT', 'id' => 'entity-edit-form', 'class' => 'marginTop']) !!}

{{csrf_field()}} 
<legend></legend>                            
	 <div class="form-group">
		<label for="Name" class="font-weight-bold required">Name</label>
		<input maxlength="100" type="text" name="Name" required placeholder="Entity Name" value="{{$entity->Name}}" class="form-control"/>
		<input  type="hidden" id="id" name="id" value="{{ $entity->id}}"	>
		<small> Note: Character limit 100</small>		
	</div>
	<div class="form-group">
		<label for="display_name" class="font-weight-bold">Display Name</label>
		<input maxlength="1000" type="text" name="display_name" placeholder="Display Name" value="{{$entity->display_name}}" class="form-control"/>
		<small> Note: Character limit 1000</small>
	</div>
	<div class="form-group">
		<label for="entityActive" class="font-weight-bold">Is Active</label>
		@if($entity->is_active == true)
		<input type="checkbox" name="active"  checked/>
		@else
		<input type="checkbox" name="active" />
		@endif
	</div>       
	<input type="submit" value="Save" class="btn btn-primary btn-user btn-block"/>

{!! Form::close() !!} 
