@extends('layouts.app',compact('orgId','surveyJson','surveyID'))
@section('content')
    @include('layouts.headers.cards')
<?php
    $survey_details = explode(" ",$surveys);
?>
<div class="container">
	<div class="card o-hidden border-0 shadow-lg my-5">
		<div class="card-body p-0">
		<div class="row">
		<div class="panel panel-default">
			<h5 class="card-header info-color white-text text-center py-4">
				<strong>Edit Form</strong>
			</h5>
			<div class="panel-heading"></div>
			<div class="card-body px-lg-5 py-lg-5">	

				<div class="form-row">					
					<div class="form-row mb-4">					
						<div class="col-sm-4">
							<label for="sel1" class="font-weight-bold">Category</label>
							<select id='cat_id' class="form-control">
								<option value='' selected disabled hidden>--Please Select--</option>
								@foreach($categories as $category)
									@if($survey_details[1] == $category['_id'])
										<option value={{$category['_id']}} selected="selected">{{ $category['name']['default'] }}</option>
									@else
										<option value={{$category['_id']}}>{{ $category['name']['default'] }}</option>
									@endif
								@endforeach
							</select>							
							<a href="/{{$orgId}}/category/create" class="createicon icon-shape bg-success text-white rounded-circle shadow">
							<i class="fas fa-plus"></i>{{-- <span class="text">Create Entity</span> --}}</a>
						</div>	

						<div class="col">
							<label class="font-weight-bold">Allowed Roles</label>
							<select multiple="multiple" name="assigned_roles[]" id="assigned_roles" class="form-control">
							@foreach($org_roles as $org_role)
								@if(is_array($roles) && in_array($org_role->id, $roles))
									<option value={{$org_role->id}} selected="selected">{{$org_role->display_name}}</option>
								@else
									<option value="{{$org_role->id}}" >{{$org_role->display_name}}</option>
								@endif
							@endforeach
							</select>
						</div>						
					
						<!-- <div class="col-sm-4">
							<label class="font-weight-bold">Project</label>
							<select id='pid' class="form-control">							
								<option value='' selected disabled hidden>--Please Select--</option>
								@foreach($projects as $project)
									@if($survey_details[0] == $project['_id'])
										<option value={{$project['_id']}} selected="selected">{{ $project['name'] }}</option>
									@else
										<option value={{$project['_id']}}>{{ $project['name'] }}</option>
									@endif
								@endforeach
							</select>
							
							<a href="/{{$orgId}}/project/create" class="createicon icon-shape bg-success text-white rounded-circle shadow">
								<i class="fas fa-plus"></i>{{-- <span class="text">Create Entity</span> --}} </a>
						</div> -->				
					
						<!--<div  class="col-sm-4">
							<label class="font-weight-bold">Microservices</label>
							<select id='service_id' class="form-control">								<
								<option value='' selected disabled hidden>--Please Select--</option>
								@foreach($microservices as $microservice)
									@if($survey_details[2] == $microservice['_id'])
										<option value={{$microservice['_id']}} selected="selected">{{ $microservice['name'] }}</option>
									@else
										<option value={{$microservice['_id']}}>{{ $microservice['name'] }}</option>
									@endif
								@endforeach
							</select>
							<a href="/microservice/create" class="createicon icon-shape bg-success text-white rounded-circle shadow">
								<i class="fas fa-plus"></i>{{-- <span class="text">Create Entity</span> --}}</a>			
						</div> -->					
					</div>
				</div> <!-- div form ends here -->		
				
				<!--<div class="form-row mb-4">
					<div class="col">	
						<label class="font-weight-bold"> Entities </label>						
						<select id='entity_id' class="form-control">
							<option value=''>--Please Select--</option>
							@foreach($entities as $entity)
								@if($survey_details[6] == $entity['_id'])
									<option value={{$entity['_id']}} selected="selected">{{ $entity['display_name'] }}</option>
								@else
									<option value={{$entity['_id']}}>{{ $entity['display_name'] }}</option>
								@endif
							@endforeach
						</select>
						<a href="/{{$orgId}}/entity/create" class="createicon icon-shape bg-success text-white rounded-circle shadow">
						<i class="fas fa-plus"></i>{{-- <span class="text">Create Entity</span> --}}</a>		
					</div>	
			
				
			</div>-->	
			<div class="form-row">
				<div class="col">
					<label><b> Is Active:</b>
					<?php
						//echo Form::checkbox('active', '',$active,['id'=>'active']); 
						if ($active !== 'false') {
							$checkVal = true;
						} else {
							$checkVal = false;
						}  
					?>
					<input type="checkbox" name="active" id="active" <?php if($checkVal) { ?> checked <?php   } ?> />
					</label>
				</div>
				
				<div class="col">
					<label><b> Is Editable:</b></label>
					<?php
					//echo Form::checkbox('editable', '',$editable,['id'=>'editable']);  
					if ($editable !== 'false') {
						$checkVal = true;
					} else {
						$checkVal = false;
					}
					?>
					<input type="checkbox" name="editable" id="editable" <?php if($checkVal) { ?> checked <?php   } ?> />
				</div>
				<div class="col">
					<label><b> Is Deletable:</b></label>
					<?php
						//echo Form::checkbox('deletable', '',$deletable,['id'=>'deletable']); 
						if ($deletable !== 'false') {
							$checkVal = true;
						} else {
							$checkVal = false;
						}  
					?>
					<input type="checkbox" name="deletable" id="deletable" <?php if($checkVal) { ?> checked <?php   } ?> />
				</div>
				<div class="col">					
						<label><b> Is Multiple Entry Allowed:</b>
						<?php
							//echo Form::checkbox('multiple_entry', '',$multiple_entry, ['id'=>'multiple_entry']);    
							if ($multiple_entry !== 'false') {
								$checkVal = true;
							} else {
								$checkVal = false;
							} 
						?>
						<input type="checkbox" name="multiple_entry" id="multiple_entry" <?php if($checkVal) { ?> checked <?php   } ?> />
						</label>

					{{-- <input type="hidden" id="previousURL" value="{{URL::previous()}}"/> --}}
					</div>
				</div>
			</div>

        <div id="surveyContainer">
			<div id="editorElement">
		</div>
		
		</div>
		</div>
		</div>
		</div>
	</div>
	@include('layouts.footers.auth')
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/edit_survey.js') }}" value="{{$surveyJson}}" id="id" surveyID="{{ $surveyID }}"></script>
@endpush
