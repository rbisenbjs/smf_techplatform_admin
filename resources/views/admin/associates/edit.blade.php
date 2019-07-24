@extends('layouts.userBased',compact('orgId'))

@section('content')
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
                        <h3>Edit Associate</h3>
                        {!! Form::open(['route' => [ 'associates.update', $orgId, $associate->id ], 'method'=>'PUT', 'id' => 'associate-edit-form']) !!}
                        {{csrf_field()}} 
                        <legend></legend>                           
                             <div class="form-group">
                                    <label for="Name">Associate Name</label>
                                    <input type="text" name="name" value="{{$associate->name}}" class="form-control"/>
                                    <b style="color:red">{{$errors->first('name')}}</b>
                            </div>
                            <div class="form-group">
                                <label for="type">Type</label>
                                <select name="type" class="form-control">
                                        <option value="0"></option>
                                        <option value="donor" @if($associate->type == 'donor') selected="selected" @endif > Donor </option>                                                                                               
                                        <option value="vendor" @if($associate->type == 'vendor') selected="selected" @endif> Vendor </option>                                                                                               
                                        <option value="partner" @if($associate->type == 'partner') selected="selected" @endif> Partner </option>
                                    </select>
                            </div>
                            <div class="form-group">
                                <label for="entityActive">Contact Person</label>
                                <input type ="text" name="contact_person" value="{{$associate->contact_person}}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="entityActive">Contact Number</label>
                                <input type ="text" name="contact_number" value="{{$associate->contact_number}}" class="form-control">
                            </div>    
                            <input type="submit" class="btn btn-primary btn-user btn-block"/>
                    
                        {!! Form::close() !!} 
                        
                </div>
            </div>
        </div>
       
    </div>
    </div>
    </div>
</div>
@endsection