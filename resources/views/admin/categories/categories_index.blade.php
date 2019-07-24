@extends('layouts.app')

@section('content')
    @include('layouts.headers.cards')
<!-- Begin Page Content -->
<div class="container-fluid">

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Categories</h1>
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
    <!-- <h6 class="m-0 font-weight-bold text-primary">
        <a href="/{{$orgId}}/category/create" class="btn btn-primary btn-icon-split">
        <span class="icon text-white-50">
            <i class="fas fa-plus"></i>
        </span>
        <span class="text">Category</span>
        </a>
    </h6> -->	
	<!--<a href="/{{$orgId}}/category/create" class="btn btn-success"> <i class="fas fa-plus"></i> <span class="text">Category</span></a>
	--><a  onclick="createCategoryModel();" class="btn btn-success"> 
		<i class="fas fa-plus"></i> 
		<span class="text">Category</span>
	</a>

  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered table-dark" id="dataTable" width="100%" cellspacing="0">
        <thead>
        <tr>
            <th>Name</th>
            <th>Type</th>
            <th>Action</th>
        </tr>
        </thead>
        <tfoot>
         <tr>
            <th>Name</th>
            <th>Type</th>
            <th>Action</th>
          </tr>
        </tfoot>
        <tbody>
            @forelse($categories as $category)
                <tr>
                    <td title="{{$category->name['default']}} ">{{str_limit($category->name['default'],60)}} </td>
                    <td>{{$category->type}}</td>
                    <td> 
                        <div class="actions">
                           <!-- <div title="Edit Category" style="float:left !important;padding-left:5px;">
                                <a class="btn btn-primary btn-circle btn-sm" href={{route('category.edit',$category->id)}}><i class="fas fa-pen"></i></a>
                            </div> -->
							
							<div onclick="editCategory('{{$category->id}}');" title="Edit Microservice" style="float:left !important;padding-left:5px;">
                               <a class="btn btn-primary btn-circle btn-sm"  ><i class="fas fa-pen"></i></a>
                            </div>                              
							
							
                          <!--  <div title="Delete Category" style="float:left !important;padding-left:5px;">
                                {!!Form::open(['action'=>['CategoryController@destroy',$category->id],'method'=>'DELETE','class'=>'pull-right' ])!!}
                                <button type="submit" class="btn btn-danger btn-circle btn-sm"><i class="fas fa-trash"></i></button>
                                {!!Form::close()!!}
                            </div> -->
							<button data-toggle="modal" onclick="deleteCategoryConfirmation('{{$category->id}}');" class="btn btn-danger btn-circle btn-sm deleteButton">
								<i class="fas fa-trash"></i>
							</button>
									
                            <div style="clear:both !important;"></div>     
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td>No data available.</td></tr>
            @endforelse
            </tbody>
      </table>
    </div>
    
  </div>
</div>
@include('layouts.footers.auth')
</div>

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
               Are you sure want to delete this category ?
            </div>
            <!-- dialog buttons -->
            <div class="modal-footer">
				<button type="button" onclick="closeModel('deleteModel')" class="btn btn-primary">No</button>
				<button type="button" class="btn btn-primary" onclick="deleteEntity();">Yes</button>
			</div>
			
        </div>
    </div>
</div>


<!-- /.container-fluid -->
@endsection

<script>
function createCategoryModel(){
	
	var _token = $("input[name='_token']").val();			
		jQuery.ajax({
        type: "POST",
        url: "http://localhost/smf_techplatform_php_new/public/category/create",
		//dataType: "json",
        data: { _token:_token},
        success:function(res) {
			jQuery('#categoryModal').modal('show');
			jQuery('.alert-danger').hide();			
            jQuery('#createCate').html(res);			
        }
      });
	
	
}

function editCategory(cateId) {
		 
		var _token = $("input[name='_token']").val();			
		jQuery.ajax({
        type: "POST",
        url: "http://localhost/smf_techplatform_php_new/public/editCategory",
		//dataType: "json",
        data: { cateId:cateId, _token:_token},
        success:function(res) {
			jQuery('#editForm').modal('show');
			jQuery('.alert-danger').hide();			
            jQuery('#editMcrs').html(res);			
        }
      });		 
	 }

function deleteCategoryConfirmation(catId) {
		
		mirId = catId;		
		$('#deleteModel').modal('show');
			
	}


	function deleteEntity() {		
		
		var _token = $("input[name='_token']").val();	
		jQuery.ajax({		  
		  data: {catId:mirId, _token:_token},
		  dataType: 'json',
		  type: 'POST',
		  url: 'http://localhost/smf_techplatform_php_new/public/deleteCategory',
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