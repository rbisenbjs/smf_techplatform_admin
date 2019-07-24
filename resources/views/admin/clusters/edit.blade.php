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
                        <h3>Edit Cluster</h3>
                        {!! Form::model($cluster, ['route' => [ 'cluster.update', $cluster->id ], 'method'=>'PUT', 'id' => 'cluster-edit-form']) !!}
                        
                        {{csrf_field()}} 
                        <legend></legend>
                             <div class="form-group">
                                    <label for="clusterName">Cluster Name</label>
                             <input type="text" name="clusterName" placeholder="Name of the cluster" value="{{$cluster->Name}}" class="form-control"/>
                            </div>
                            <div>
                                    <h4>State</h4>
                                    <select id="state_id" name="state_id" class="form-control">
                                            @foreach($states as $state)
                                                <option value={{$state->id}} {{ ($cluster->state_id == $state->id) ? "selected":""}}>{{$state->Name}}</option>
                                            @endforeach 
                                    </select>
                            </div>
                            <div>
                                <h4>Districts</h4>
                                <select id="District" name="District" class="form-control">
                                        @foreach($districts as $district)
                                            <option value={{$district->id}} {{ ($cluster->district_id == $district->id) ? "selected":""}}>{{$district->Name}}</option>
                                        @endforeach 
                                </select>
                            </div>
                            <div>
                                <h4>Talukas</h4>
                                <select id="Taluka" name="Taluka" class="form-control">
                                        @foreach($talukas as $taluka)
                                            <option value={{$taluka->id}} {{ ($cluster->taluka_id == $taluka->id) ? "selected":""}}>{{$taluka->Name}}</option>
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