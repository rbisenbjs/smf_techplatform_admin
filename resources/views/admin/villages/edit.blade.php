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
                        <h3>Edit Village</h3>
                        {!! Form::model($village, ['route' => [ 'village.update', $village->id ], 'method'=>'PUT', 'id' => 'village-edit-form']) !!}
                        
                        {{csrf_field()}} 
                        <legend></legend>
                             <div class="form-group">
                                    <label for="clusterName">Village Name</label>
                             <input type="text" name="villageName" placeholder="Name of the Village" value="{{$village->Name}}" class="form-control"/>
                            </div>
                            <div>
                                    <h4>State</h4>
                                    <select id="state_id" name="state_id" class="form-control">
                                            @foreach($states as $s)
                                                <option value={{$s->id}} {{ ($village->state_id == $s->id) ? "selected":""}}>{{$s->Name}}</option>
                                            @endforeach
                                    </select>
                            </div>
                            <div>
                                <h4>Districts</h4>
                                <select id="District" name="District" class="form-control">
                                        @foreach($districts as $district)
                                            <option value={{$district->id}} {{ ($village->district_id == $district->id) ? "selected":""}}>{{$district->Name}}</option>
                                        @endforeach 
                                </select>
                            </div>
                            <div>
                                <h4>Talukas</h4>
                                <select id="Taluka" name="Taluka" class="form-control">
                                        @foreach($talukas as $taluka)
                                            <option value={{$taluka->id}} {{ ($village->taluka_id == $taluka->id) ? "selected":""}}>{{$taluka->Name}}</option>
                                        @endforeach 
                                </select>
                            </div>
                            <div>
                                @if(isset($clusters))
                                <h4>Clusters</h4>
                                <select id="Cluster" name="Cluster" class="form-control">
                                        @foreach($clusters as $cluster)
                                            <option value={{$cluster->id}} {{ ($village->cluster_id == $cluster->id) ? "selected":""}}>{{$cluster->clusterName}}</option>
                                        @endforeach 
                                </select>
                                @endif
                            </div>
                            <input type="submit" class="btn btn-success"/>
                    
                        {!! Form::close() !!} 
                        
                </div>
            </div>
        </div>
    </div>
</div>
@endsection