@extends('layouts.app')

@section('content')
    @include('layouts.headers.cards')
<div class="container">
<div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default" style="padding-left:50px;padding-top:40px;padding-bottom:75px;">
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif                   
					<h5 class="card-header info-color white-text text-center py-4">
						<strong>Create Entity</strong>
					</h5>
                    <form action="{{route('entity.store')}}" method="post" class="marginTop">
					   {{csrf_field()}}     
					   <legend></legend>
						<div class="form-group">
							 <label for="entityName" class="font-weight-bold required">Entity Name</label>
							 <input type="text" name="entityName" required  placeholder="Entity Name" class="form-control"/>
							 @if($errors->any())
							 <b style="color:red">{{$errors->first()}}</b>
							 @endif
						</div>    
						<div class="form-group">
							<label for="displayName" class="font-weight-bold">Display Name</label>
							<input type="text" name="displayName" placeholder="Display Name" class="form-control"/>
							@if($errors->any())
							<b style="color:red">{{$errors->first()}}</b>
							@endif
						</div>     
						<div class="form-group">
							<label for="entityActive" class="font-weight-bold">Is Active</label>
							<input type="checkbox" name="active" checked/>
						</div>                         
						<input type="submit" value="Save" class="btn btn-primary btn-user btn-block"/>
                    </form>                        
                </div>
            </div>
        </div>
    </div>
    </div>
	@include('layouts.footers.auth')
</div>
@endsection