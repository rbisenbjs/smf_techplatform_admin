@extends('layouts.app')

@section('content')
    @include('layouts.headers.cards')
<!-- Begin Page Content -->
<div class="container-fluid">

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Event Types</h1>
<p class="mb-4">
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif
    </p>

<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
  <!--<a href="/{{$orgId}}/event-type/create" class="btn btn-success"> <i class="fas fa-plus"></i> <span class="text">Event Type</span></a>
  -->
  <a  onclick="createETypeModel();" class="btn btn-success"> 
		<i class="fas fa-plus"></i> 
		<span class="text">Event Type</span>
	</a>

  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered table-dark" id="dataTable" width="100%" cellspacing="0">
        <thead>
        <tr>
            <th>Name</th>
            <th>Action</th>
        </tr>
        </thead>
        <tfoot>
         <tr>
            <th>Name</th>
            <th>Action</th>
          </tr>
        </tfoot>
        <tbody>
            @forelse($event_types as $event_type)
                <tr>
                    <td>{{$event_type->name}}</td>
                    <td> 
                        <div class="actions">
                            <!-- <div  title="Edit Event Type" style="float:left !important;padding-left:5px;">
                                <a class="btn btn-primary btn-circle btn-sm" href={{route('event-type.edit',$event_type->id)}}><i class="fas fa-pen"></i></a>
                            </div> -->
							
							<div onclick="editEtype('{{$event_type->id}}');" title="Edit Microservice" style="float:left !important;padding-left:5px;">
                               <a class="btn btn-primary btn-circle btn-sm"  ><i class="fas fa-pen"></i></a>
                            </div>                              
							
                          <!--  <div title="Delete Event Type" style="float:left !important;padding-left:5px;">
                                {!!Form::open(['action'=>['EventTypeController@destroy',$event_type->id],'method'=>'DELETE','class'=>'pull-right' ])!!}
                                <button type="submit" class="btn btn-danger btn-circle btn-sm"><i class="fas fa-trash"></i></button>
                                {!!Form::close()!!}
                            </div> -->
							
							<button data-toggle="modal" onclick="deleteEtypeConfirmation('{{$event_type->id}}');" class="btn btn-danger btn-circle btn-sm deleteButton">
								<i class="fas fa-trash"></i>
							</button>
							
                            <div style="clear:both !important;"></div>     
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td>No Event Types</td></tr>
            @endforelse
            </tbody>
      </table>
    </div>
    
  </div>
</div>
@include('layouts.footers.auth')
</div>
<!-- /.container-fluid -->

<div class="modal fade" id="categoryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
						 <div id="errorMsg"><div class="alert alert-danger" role="alert"></div></div> 						  
						 <div id="createCate"></div>					
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
         <h5 class="modal-title" id="exampleModalLabel">Edit Category</h5> 	
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
               Are you sure want to delete this Event Type ?
            </div>
            <!-- dialog buttons -->
            <div class="modal-footer">
				<button type="button" onclick="closeModel('deleteModel')" class="btn btn-primary">No</button>
				<button type="button" class="btn btn-primary" onclick="deleteEtype();">Yes</button>
			</div>
			
        </div>
    </div>
</div>
@endsection

<script>
function createETypeModel(){
	
	var _token = $("input[name='_token']").val();			
		jQuery.ajax({
        type: "POST",
        url: "http://localhost/smf_techplatform_php_new/public/eventTypes",
		//dataType: "json",
        data: { _token:_token},
        success:function(res) {
			jQuery('#categoryModal').modal('show');
			jQuery('.alert-danger').hide();			
            jQuery('#createCate').html(res);			
        }
      });
	
	
}

function editEtype(etypeId) {
		 
		var _token = $("input[name='_token']").val();			
		jQuery.ajax({
        type: "POST",
        url: "http://localhost/smf_techplatform_php_new/public/editEtype",
		//dataType: "json",
        data: { etypeId:etypeId, _token:_token},
        success:function(res) {
			jQuery('#editForm').modal('show');
			jQuery('.alert-danger').hide();			
            jQuery('#editMcrs').html(res);			
        }
      });		 
	 }

function deleteEtypeConfirmation(etypeId) {
		
		mirId = etypeId;		
		$('#deleteModel').modal('show');
			
	}


	function deleteEtype() {		
		
		var _token = $("input[name='_token']").val();	
		jQuery.ajax({		  
		  data: {etypeId:mirId, _token:_token},
		  dataType: 'json',
		  type: 'POST',
		  url: 'http://localhost/smf_techplatform_php_new/public/deleteEtype',
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