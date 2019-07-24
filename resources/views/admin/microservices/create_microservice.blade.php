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
					<strong>Create Microservice</strong>
					</h5>
                    <form  name="create_mroservice_form" id="create_mroservice_form">
                           {{csrf_field()}}     
                        <legend></legend>
                             <div class="form-group">
                                    <label for="microserviceName" class="font-weight-bold required">Name</label>
                                    <input required type="text" name="name" placeholder="Name"class="form-control"/>
                                    @if($errors->any())
                                        <b style="color:red">{{$errors->first()}}</b>
                                    @endif
                            </div>
							
                            <div class="form-group">
                                <label for="microserviceDescription" class="font-weight-bold">Description</label>
                                <input type="text" name="description" placeholder="Description" class="form-control"/>                                
                        </div>   
                        <div class="form-group">
                            <label for="microserviceUrl" class="font-weight-bold required">Base url</label>
                            <input type="url" name="url" required placeholder="Base url"class="form-control"/>
							@if($errors->any())
                                <b style="color:red">{{$errors->first()}}</b>
                            @endif
						</div>  
						<div class="form-group">
							<label for="microserviceRoute" class="font-weight-bold">Route</label>
							<input type="text" name="route" placeholder="Route"class="form-control"/>
						</div>        
                    
                    <div class="form-check">
                        <input class="form-check-input" id="report-active" type="checkbox" name="active" value="1" id="defaultCheck1" checked>
                        <label class="form-check-label font-weight-bold" for="microserviceActive">
                            Active
                        </label>
                    </div>
                    <div>&nbsp;</div>              
                    <input type="submit" value="Save" class="btn btn-primary btn-user btn-block"/>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
	@include('layouts.footers.auth')
</div>
@endsection