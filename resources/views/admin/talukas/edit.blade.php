@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                        <h3>Edit Taluka</h3>
                        {!! Form::model($taluka, ['route' => [ 'taluka.update', $taluka->id ], 'method'=>'PUT', 'id' => 'taluka-edit-form']) !!}
                        
                        {{csrf_field()}} 
                        <legend></legend>
                             <div class="form-group">
                                    <label for="talukaName">Taluka Name</label>
                             <input type="text" name="talukaName" placeholder="Name of the taluka" value="{{$taluka->Name}}" class="form-control"/>
                            </div>
                            <div>
                                    <h4>State</h4>
                                    <select name="state_id" class="form-control" id="state_id">
                                            @foreach($states as $state)
                                                <option value={{$state->id}} {{ ($taluka->state_id == $state->id) ? "selected":""}}>{{$state->Name}}</option>
                                            @endforeach 
                                    </select>
                            </div>
                            <div>
                                <h4>Districts</h4>
                                <select name="District" class="form-control">
                                        @foreach($districts as $district)
                                            <option value={{$district->id}} {{ ($taluka->district_id == $district->id) ? "selected":""}}>{{$district->Name}}</option>
                                        @endforeach 
                                </select>
                            </div>
                            
                            <input type="submit" class="btn btn-success"/>
                    
                        {!! Form::close() !!} 
                        
                </div>
            </div>
        </div>
    </div>
</div>
@endsection