@extends('layouts.app')

@section('content')
    @include('layouts.headers.cards')
<!-- Begin Page Content -->
<div class="container-fluid">
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
        <a href="/{{$orgId}}/entity/create" class="btn btn-primary btn-icon-split">
        <span class="icon text-white-50">
            <i class="fas fa-plus"></i>
        </span>
        <span class="text">Entity</span>
        </a>
    </h6> -->
	<a  data-toggle="modal" data-target="#exampleModal" class="btn btn-success"> <i class="fas fa-plus"></i> <span class="text">Entity</span></a>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered table-dark" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
               <th>Entity Name</th>
               <th>Display Name</th>
               <th>Is Active</th>
               <th>Action</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>Entity Name</th>
               <th>Display Name</th>
               <th>Is Active</th>
               <th>Action</th>
            </tr>
            </tfoot>
            <tbody>
                @forelse($entities as $entity)
                    <tr>
                       <td title="{{$entity->Name}}">{{str_limit($entity->Name, 30)}}  </td>
                       <td title="{{$entity->display_name}}">{{str_limit($entity->display_name, 30)}} </td>
                        @if($entity->is_active == true)
                            <td>Yes</td>
                        @else
                            <td>No</td>
                        @endif
                       <td> 
                            <div class="actions">
                                <!-- <div title="Edit Entity " style="float:left !important;padding-left:5px;">
                                    <a class="btn btn-primary btn-circle btn-sm" href={{route('entity.edit',$entity->id)}}><i class="fas fa-pen"></i></a>
                                </div>-->
								<div onclick="editEntity('{{$entity->id}}');" title="Edit Microservice" style="float:left !important;padding-left:5px;">
                                        <a class="btn btn-primary btn-circle btn-sm"  ><i class="fas fa-pen"></i></a>
                                    </div>
                                <div  title="Delete Entity "  style="float:left !important;padding-left:5px;"> 
                                   <!-- {!!Form::open(['action'=>['EntityController@destroy',$entity->id],'method'=>'DELETE','class'=>'pull-right' ])!!}
                                    <button type="submit" class="btn btn-danger btn-circle btn-sm"><i class="fas fa-trash"></i></button>
                                    {!!Form::close()!!}-->
									
									<button data-toggle="modal" onclick="deleteEntityConfirmation('{{$entity->id}}');" class="btn btn-danger btn-circle btn-sm deleteButton">
										<i class="fas fa-trash"></i>
									</button>
									
                                </div>
                                <div style="clear:both !important;"></div>    
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td>no Entities</td></tr>
                @endforelse
            </tbody>
      </table>
    </div>
    
  </div>
</div>
@include('layouts.footers.auth')
</div>



<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered  modal-dialog-scrollable" role="document">
		<div class="modal-content">
			  <div class="modal-header">
				 <h5 class="modal-title" id="exampleModalLabel">Create Entities</h5> 	
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>
				<div class="modal-body">
				
					<div class="row">				
						<div class="card-body px-lg-2 py-lg-3">	
						 <div id="errorMsg"><div class="alert alert-danger" role="alert""></div></div> 						  
						 <form  method="post" id="create_entity_form" name="create_entity_form" >
							   {{csrf_field()}}     
								<legend></legend>
								 <div class="form-group">
									<label for="entityName" class="font-weight-bold required">Name</label>
									<input type="text" name="entityName" required  placeholder="Entity Name" class="form-control" maxlength="100"/>
									<small> Note: Character limit 100</small>
									@if($errors->any())
										<b style="color:red">{{$errors->first()}}</b>
									@endif
								</div>
								
								<div class="form-group">
									<label for="displayName" class="font-weight-bold">Description</label>
									<input type="text" name="displayName" placeholder="Description" class="form-control" maxlength="1000"/>
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
									<input type="checkbox" name="active" checked/>
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
<!-- /.container-fluid -->

<div class="modal fade hide " id="editForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
         <h5 class="modal-title" id="exampleModalLabel">Edit Entity</h5> 	
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
		<div class="modal-body">
		
			<div class="row">				
				<div class="card-body px-lg-2 py-lg-3">			
				<div class="alert alert-danger" role="alert"></div>
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
               Are you sure want to delete this entity ?
            </div>
            <!-- dialog buttons -->
            <div class="modal-footer">
				<button type="button" onclick="closeModel('deleteModel')" class="btn btn-primary">No</button>
				<button type="button" class="btn btn-primary" onclick="deleteEntity();">Yes</button>
			</div>
			
        </div>
    </div>
</div>
@endsection

<script>

function deleteEntityConfirmation(entityId) {
		
		mirId = entityId;		
		$('#deleteModel').modal('show');
			
	}


	function deleteEntity() {		
		
		var _token = $("input[name='_token']").val();	
		jQuery.ajax({		  
		  data: {entityId:mirId, _token:_token},
		  dataType: 'json',
		  type: 'POST',
		  url: 'http://localhost/smf_techplatform_php_new/public/deleteEntity',
		  success: function( res ){			  
			if (res.code == 400) {
			  jQuery('.alert-danger').show();	
			  jQuery('.alert-danger').html(res.msg);			 
			} else {
				$('#deleteModel').modal('hide');				
				location.reload(true);
			}
		  }
		});		
			
	}
</script>
