@extends('layouts.app')

@section('content')
    @include('layouts.headers.cards')
<!-- Begin Page Content -->
<div class="container-fluid">

<!-- Page Heading -->
<!-- <h1 class="h3 mb-2 text-gray-800">Forms</h1>-->
<p class="mb-4">
@if (session('status'))
  <div class="alert alert-success">
      {{ session('status') }}
  </div>
@endif
</p>

<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <!-- <h6 class="m-0 font-weight-bold text-primary">
        <a href="/{{$orgId}}/forms/create" class="btn btn-primary btn-icon-split">
        <span class="icon text-white-50">
            <i class="fas fa-plus"></i>
        </span>
        <span class="text">Form</span>
        </a>
    </h6> -->
	<a  data-toggle="modal" data-target="#exampleModal" class="btn btn-success"> <i class="fas fa-plus"></i> <span class="text">Form</span></a>
	
	
	
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered table-dark" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>Name</th>
                <th>Category</th>
                <th>Project</th>                                
                <th>Microservice</th>
                <th>Entity</th>
                <th>Action</th>
            </tr>
        </thead>
        <tfoot>
         <tr>
            <th>Name</th>
            <th>Category</th>
            <th>Project</th>                                
            <th>Microservice</th>
            <th>Entity</th>
            <th>Action</th>
          </tr>
        </tfoot>
        <tbody>
            @forelse($surveys as $survey)
                <tr>
                    <td title="{{is_array($survey->name) ? $survey->name['default']  : $survey->name}}">
                        {{ is_array($survey->name) ? str_limit($survey->name['default'], 15)  : str_limit($survey->name, 20) }}
                    </td>
                    <td title="{{$survey->category['name']['default']}}">
                        {{str_limit($survey->category['name']['default'], 15)}} 
					</td>
                    <td>
                       {{ $survey->project['name'] }}
                    </td>                                    
                    <td>
                        {{ $survey->microservice['name'] }}
                    </td>
                    <td>
                        {{ $survey->entity['display_name'] }}
                    </td>
                    <td>
                        <div class="actions">
                            <div style="float:left !important;">
							<!-- onClick="editFormData('{{$orgId}}','{{$survey->id}}');" -->
                                <a class="btn btn-primary btn-circle btn-sm" href="/{{$orgId}}/editForm/{{$survey->id}}"  ><i class="fas fa-pen"></i></a>
                            </div>
                            <div style="float:left !important;padding-left:5px;">
                                {!!Form::open(['action'=>array('SurveyController@destroy',$survey->id),'method'=>'DELETE','class'=>'pull-right' ])!!}
                                    <button type="submit" class="btn btn-danger btn-circle btn-sm"><i class="fas fa-trash"></i></button>
                                {!!Form::close()!!}
                            </div>
                            <div style="clear:both;"></div>
                        </div>
                    </td>                                   
                </tr>
            @empty
                <tr><td>No data available</td></tr>
            @endforelse
        </tbody>
      </table>
    </div>
   
  </div>
   @include('layouts.footers.auth')
</div>

</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
         <h5 class="modal-title" id="exampleModalLabel">Create Form</h5> 	
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">	  
		<div class="row">			
			<div class="card-body px-lg-2 py-lg-0">

				<div class="alert alert-danger" role="alert"">
			        
				</div>
				<div class="form-row">			
					<div class="form-row mb-4">
						 <div class="col">
							<label for="cat_id" class="font-weight-bold required">Category</label>
							<select  required id='cat_id' class="form-control">
								<option value='' selected disabled hidden>--Please Select--</option>
								@foreach($categories as $category)
								<option value={{$category['_id']}}>{{ $category['name']['default'] }}</option>
								@endforeach
							</select>
							
							<a href="/{{$orgId}}/category/create" class="createicon icon-shape bg-success text-white rounded-circle shadow">
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
						 <!--  <div class="col-sm-4">
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
						</div> -->
					</div>
				</div> <!-- form-row ends here -->
			
				<div class="form-row mb-4">
					 <!-- <div class="col">	
						<label class="font-weight-bold"> Entities </label>
						<select id='entity_id' class="form-control">
							<option value='' selected disabled hidden>--Please Select--</option>
							@foreach($entities as $entity)
							<option value={{$entity['_id']}}>{{ $entity['display_name'] }}</option>
							@endforeach
						</select>
					
						<a href="/{{$orgId}}/entity/create" class="createicon icon-shape bg-success text-white rounded-circle shadow">
						<i class="fas fa-plus"></i></a>			
					</div> -->

					
					
				</div>
		
				<div class="form-row">
					<div class="col">	
						<label><b>Active</b>
						<?php echo Form::checkbox('active', '',true,['id'=>'active']); ?>
						</label>
					</div>
					
					<div class="col">	
						<label><b>Editable</b></label>
						<?php echo Form::checkbox('editable','',false,['id'=>'editable']); ?>					
					</div>
					
					<div class="col">	
						<label><b>Deletable</b></label>						
						{{-- <input type="checkbox" name="deletable"/> --}}
						<?php echo Form::checkbox('deletable','',false,['id'=>'deletable']);?>						
					</div>
					<div class="col">	
						<label><b>Multiple Entry Allowed</b></label>					
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
</div>
</div>
<!-- /.container-fluid -->


<!-- edit form model ends here --->
<!-- edit form model start here ----------->
<!-- edit form model start here ----------->
<div class="modal fade hide " id="editForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
         <h5 class="modal-title" id="exampleModalLabel">Create Form</h5> 	
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
		<div class="modal-body">
		
			<div class="row">				
				<div class="card-body px-lg-5 py-lg-5">
				<div id="surveyContainer">
				<div id="editorElement">
				</div>

				</div>
				
			</div>

		</div>
	</div>
</div></div></div>
@endsection

@push('scripts')
<script src="{{ asset('js/create_survey.js') }}" id="id" class="{{ Auth::user()->id }}"></script>
@endpush