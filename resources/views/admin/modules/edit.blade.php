@extends('layouts.userBased')

@section('content')
<div class="container">
<div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default" style="padding-left:50px;padding-top:40px;padding-bottom:75px;">
                <div class="panel-body">
                    <h3>Edit Module</h3>
                    <form action="{{route('modules.update', ['orgId' => $orgId, 'module' => $module->id])}}" method="POST">
                        @csrf
                        @method('PUT')
                        <h4>Name</h4>
						@foreach ($locale as $localeIdentifier => $localeLabel)
						<div class="form-group ml-4">
							<label for="{{$localeIdentifier}}">{{$localeLabel}}</label>
							<input type="text" name="name[{{$localeIdentifier}}]" id="{{$localeIdentifier}}" class="form-control" value="{{$module->name[$localeIdentifier]}}"/>
						</div>
						@endforeach
						@if ($errors->any())
							 <div class="alert alert-danger">
								 {{$errors->first()}}
							 </div>
						@endif
                        <input type="submit" class="btn btn-primary btn-user btn-block" value="Update"/>
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