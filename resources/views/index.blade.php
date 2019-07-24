@extends('layouts.app')

@section('content')
    @include('layouts.headers.cards')
<div class="container">
	<div class="card o-hidden border-0 shadow-lg my-5">
		<div class="card-body p-0">
		<div class="row">
			<div class="panel panel-default">
			<h5 class="card-header info-color white-text text-center py-4">
				<strong>Create Form</strong>
			</h5>
			<div class="panel-heading"></div>		
			
			<div class="card-body px-lg-5 py-lg-5">				
				<div class="form-row">			
					<div class="form-row mb-4">
						 <div class="col-sm-4">
							<label for="cat_id" class="font-weight-bold">Category</label>
							<select id='cat_id' class="form-control">
								<option value='' selected disabled hidden>--Please Select--</option>
								@foreach($categories as $category)
								<option value={{$category['_id']}}>{{ $category['name']['default'] }}</option>
								@endforeach
							</select>
							
							<a href="/{{$orgId}}/category/create" class="createicon icon-shape bg-success text-white rounded-circle shadow">
							<i class="fas fa-plus"></i></a>
						</div>		
						<div class="col-sm-4">
							<label class="font-weight-bold">Project</label>
							<select id='pid' class="form-control">
							<option value='' selected disabled hidden>--Please Select--</option>
							@foreach($projects as $project)
							<option value={{$project['_id']}}>{{ $project['name'] }}</option>
							@endforeach
							</select>
							<a href="/{{$orgId}}/project/create" class="createicon icon-shape bg-success text-white rounded-circle shadow">
							<i class="fas fa-plus"></i>
							</a>
						</div>
						<div class="col-sm-4">
							<label class="font-weight-bold">Microservices</label>
							<select id='service_id' class="form-control">
								<option value='' selected disabled hidden>--Please Select--</option>
								@foreach($microservices as $microservice)
								<option value={{$microservice['_id']}}>{{ $microservice['name'] }}</option>
								@endforeach
							</select>
							<a href="/microservice/create" class="createicon icon-shape bg-success text-white rounded-circle shadow">
							<i class="fas fa-plus"></i></a>					
						</div>
					</div>
				</div> <!-- form-row ends here -->
			
				<div class="form-row mb-4">
					<div class="col">	
						<label class="font-weight-bold"> Entities </label>
						<select id='entity_id' class="form-control">
							<option value='' selected disabled hidden>--Please Select--</option>
							@foreach($entities as $entity)
							<option value={{$entity['_id']}}>{{ $entity['display_name'] }}</option>
							@endforeach
						</select>
					
						<a href="/{{$orgId}}/entity/create" class="createicon icon-shape bg-success text-white rounded-circle shadow">
						<i class="fas fa-plus"></i></a>			
					</div>

					<div class="col">
					<label class="font-weight-bold">Allowed Roles</label>
					<select class="form-control" multiple="multiple" name="assigned_roles[]" id="assigned_roles">
						@foreach($org_roles as $org_role)
						<option value="{{$org_role->id}}" >{{$org_role->display_name}}</option>
						@endforeach
					</select>
					</div>
					
				</div>
		
				<div class="form-row">
					<div class="col">	
						<label><b> Is Active</b>
						<?php echo Form::checkbox('active', '',true,['id'=>'active']); ?>
						</label>
					</div>
					
					<div class="col">	
						<label><b> Is Editable</b></label>
						<?php echo Form::checkbox('editable','',false,['id'=>'editable']); ?>					
					</div>
					
					<div class="col">	
						<label><b> Is Deletable</b></label>						
						{{-- <input type="checkbox" name="deletable"/> --}}
						<?php echo Form::checkbox('deletable','',false,['id'=>'deletable']);?>						
					</div>
					<div class="col">	
						<label><b> Is Multiple Entry Allowed</b></label>					
						<?php echo Form::checkbox('multiple_entry','',false, ['id'=>'multiple_entry']);?>						
					</div>
				</div>				
				<div id="surveyContainer">
					<div id="editorElement"></div>		
				</div>
			</div>
		</div>
		</div>
	</div>
	@include('layouts.footers.auth')
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/create_survey.js') }}" id="id" class="{{ Auth::user()->id }}"></script>
@endpush


