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
   <!--  <h6 class="m-0 font-weight-bold text-primary">
        <a href="/{{$orgId}}/jurisdiction/create" class="btn btn-primary btn-icon-split">
        <span class="icon text-white-50">
            <i class="fas fa-plus"></i>
        </span>
        <span class="text">Jurisdiction</span>
        </a>
    </h6> -->
	<!--<a href="/{{$orgId}}/jurisdiction/create" class="btn btn-success"> <i class="fas fa-plus"></i> <span class="text">Jurisdiction</span></a>
  -->
	<a  onclick="createJurisditionModel();" class="btn btn-success"> 
		<i class="fas fa-plus"></i> 
		<span class="text">Jurisdiction</span>
	</a>

  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered table-dark" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>Level Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tfoot>
        <tr>
            <th>Level Name</th>
            <th>Action</th>
        </tr>
        </tfoot>
        <tbody>
            @forelse($juris as $j)
            <tr>
                <td>{{$j->levelName}}</td>
                <td>
                    <div class="actions">
                    <div style="float:left !important;padding-left:5px;">
                        <a class="btn btn-primary btn-circle btn-sm"  id="edit-jusrisdiction" value="{{$j->id}}" href={{route('jurisdictions.edit',$j->id)}}><i class="fas fa-pen"></i></a>
                        </div>
                        <div style="float:left !important;padding-left:5px;">
                        <form action="{{ url('jurisdictions', $j->id) }}" method="POST" id="delete-jusrisdiction-form">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button type="submit" class="btn btn-danger btn-circle btn-sm" id="delete-jusrisdiction" name="delJusrisButton" value="{{$j->id}}"><i class="fas fa-trash"></i></button>
                        </form>
                        </div>
                        <div style="float:left !important;padding-left:5px;">
                            <a class="btn btn-success btn-circle btn-sm" value="{{$j->id}}" href="/{{$orgId}}/jurisdictions/{{$j->id}}"><i class="fas fa-plus"></i></a>
                        </div>
                        <div style="clear:both !important;"></div>    
                    </div>   
                </td>
            </tr>
            @empty
            <tr><td>no Jurisdictions</td></tr>
            @endforelse
            </tbody>
      </table>
    </div>
    
  </div>
</div>
@include('layouts.footers.auth')
</div>
<!-- /.container-fluid -->
<!-- modal pop up code begins -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmation</h5>
                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> -->
            </div>
            <div class="modal-body">
                <p>The Jurisdiction can not be edited/deleted for it has been associated with the Jurisdiction Type !</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
	
</div>
<!-- modal pop up code ends -->

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


@endsection

<script>
	function createJurisditionModel(){
	
		var _token = $("input[name='_token']").val();			
		jQuery.ajax({
        type: "POST",
        url: "http://localhost/smf_techplatform_php_new/public/jurisdiction/create",
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