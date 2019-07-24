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
                        <h3>Edit Project</h3>
                        {!! Form::model($project, ['route' => [ 'project.update', $project->id ], 'method'=>'PUT', 'id' => 'entity-edit-form']) !!}
                        
                        {{csrf_field()}} 
                        <legend></legend>                            
                             <div class="form-group">
                                    <label for="Name">Project Name</label>
                             <input type="text" name="name" placeholder="Project name" value="{{$project->name}}" class="form-control"/>
                             @if($errors->has('name'))
                            <b style="color:red">{{$errors->first('name')}}</b>
                            @endif
                            </div>
                        <div class="form-group">
                            <label for="jurisdictionType">Jurisdiction Type</label>
                            <select class="form-control" id="jurisdictionType" name="jurisdictionType">
                                <option value="">Select Jurisdiction Type</option>
                                @foreach ($jurisdictionTypes as $type)
                                <option value="{{$type->id}}" {{$type->id === $project->jurisdiction_type_id ? 'selected="selected"' : ''}}>{{json_encode($type->jurisdictions)}}</option>
                                @endforeach
                            </select>
                            @if($errors->has('jurisdictionType'))
                            <b style="color:red">{{$errors->first('jurisdictionType')}}</b>
                            @endif
                        </div>
                            <input type="submit" class="btn btn-primary btn-user btn-block"/>
                    
                        {!! Form::close() !!} 
                        
                </div>
            </div>
        </div>
       
    </div>
    </div>
    </div>
	@include('layouts.footers.auth')
</div>
@endsection