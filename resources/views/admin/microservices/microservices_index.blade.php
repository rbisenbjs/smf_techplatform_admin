@extends('layouts.app')

@section('content')
    @include('layouts.headers.cards')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->   
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
                <a href="{{route('microservice.create')}}" class="btn btn-primary btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">Microservice</span>
                </a>
            </h6>  href="{{route('microservice.create')}}" -->
			<a  data-toggle="modal" data-target="#exampleModal" class="btn btn-success"> <i class="fas fa-plus"></i> <span class="text">Microservice</span></a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-dark" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Base_url</th>
                            <th>Route</th>
                            <th>Is active</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                    <tr>
						<th>Name</th>
						<th>Description</th>
						<th>Base_url</th>
						<th>Route</th>
						<th>Is active</th>
						<th>Action</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @forelse($microservices as $microservice)
                        <tr>
                            <td>{{$microservice->name}}</td>
                            <td title="{{$microservice->description}}">{{str_limit($microservice->description, 15)}}</td>
                            <td>{{$microservice->base_url}}</td>
                            <td>{{$microservice->route}}</td>
                            @if($microservice->is_active == true)
                            <td>Yes</td>
                            @else
                            <td>No</td>
                            @endif
                            <td>
                                <div class="actions">
								   <!-- href={{route('microservice.edit',$microservice->id)}} -->
                                    <div onclick="editMicroService('{{$microservice->id}}');" title="Edit Microservice" style="float:left !important;padding-left:5px;">
                                        <a class="btn btn-primary btn-circle btn-sm"  ><i class="fas fa-pen"></i></a>
                                    </div>
                                    <div title="Delete Microservice" style="float:left !important;padding-left:5px;">    
                                      <!--  {!!Form::open(['action'=>['MicroservicesController@destroy',$microservice->id],'method'=>'DELETE','class'=>'pull-right' ])!!}
                                        -->
										<button data-toggle="modal" onclick="deleteMicroservicesConfirmation('{{$microservice->id}}');" class="btn btn-danger btn-circle btn-sm deleteButton"><i class="fas fa-trash"></i></button> 
                                     						
										<!--{!!Form::close()!!}-->
                                    </div>
                                    <div style="clear:both !important;"></div>    
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td>No data vaialable</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
	@include('layouts.footers.auth')
</div><!-- /.container-fluid -->


<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered  modal-dialog-scrollable" role="document">
		<div class="modal-content">
			  <div class="modal-header">
				 <h5 class="modal-title" id="exampleModalLabel">Create Microservice</h5> 	
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>
				<div class="modal-body">
				
					<div class="row">				
						<div class="card-body px-lg-2 py-lg-3">	
						<div class="alert alert-danger" role="alert""></div>
						   <form  method="post" id="create_mroservice_form" name="create_mroservice_form" >
							   {{csrf_field()}}     
								<legend></legend>
								 <div class="form-group">
									<label for="microserviceName" class="font-weight-bold required">Name</label>
									<input required type="text" name="name" placeholder="Name"class="form-control" maxlength="100"/>
									<small> Note: Character limit 100</small>
									@if($errors->any())
										<b style="color:red">{{$errors->first()}}</b>
									@endif
								</div>
								
								<div class="form-group">
									<label for="microserviceDescription" class="font-weight-bold">Description</label>
									<input type="text" name="description" placeholder="Description" class="form-control" maxlength="1000"/>
									<small> Note: Character limit 1000</small>                                
								</div>   
							   <!-- <div class="form-group">
									<label for="microserviceUrl" class="font-weight-bold required">Base url</label>
									<input type="url" name="url" required placeholder="Base url"class="form-control"/>
									@if($errors->any())
										<b style="color:red">{{$errors->first()}}</b>
									@endif
								</div>  
								<div class="form-group">
									<label for="microserviceRoute" class="font-weight-bold">Route</label>
									<input type="text" name="route" placeholder="Route"class="form-control"/>
								</div> -->       
						
								<div class="form-check">
									<input class="form-check-input" id="report-active" type="checkbox" name="active" value="1" id="defaultCheck1" checked>
									<label class="form-check-label font-weight-bold" for="microserviceActive">
										Active
									</label>
								</div>
								<div>&nbsp;</div>              
								<input type="submit"  value="Save" class="btn btn-primary btn-user btn-block"/>
							</form>						
						</div>

					</div>
				</div>
		</div>
	</div>
</div>



<div class="modal fade hide " id="editForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
         <h5 class="modal-title" id="exampleModalLabel">Edit Form</h5> 	
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
		<div class="modal-body">
		
			<div class="row">				
				<div class="card-body px-lg-2 py-lg-3">			
				<div class="alert alert-danger" role="alert""></div>
				<div id="editMcrs">
				
				</div>
				</div>				
			</div>

		</div>
	</div>
</div></div></div>

<!-- set up the modal to start hidden and fade in and out -->
<div id="deleteModel" class="modal fade hide" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- dialog body -->
            <div class="modal-body">               
               Are you sure want to delete this microservice ?
            </div>
            <!-- dialog buttons -->
            <div class="modal-footer">
				<button type="button" onclick="closeModel('deleteModel')" class="btn btn-primary">No</button>
				<button type="button" class="btn btn-primary" onclick="deleteMicroservices();">Yes</button>
			</div>
			
        </div>
    </div>
</div>
        

@endsection
