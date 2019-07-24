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
                        <h3>Edit State</h3>
                        {!! Form::model($state, ['route' => [ 'state.update', $state->id ], 'method'=>'PUT', 'id' => 'state-edit-form']) !!}
                        
                        {{csrf_field()}} 
                        <legend></legend>
                             <div class="form-group">
                                    <label for="stateName">State Name</label>
                                    <input type="text" name="stateName" placeholder="Name of the state"class="form-control" value="{{$state->Name}}"/>
                            </div>
                            <div class="form-group">
                                <h4>Jurisdiction</h4>
                                @foreach($jurisdiction as $jurisdict)
                                    <?php $c = false; ?>
                                    @foreach($state_jurisdictions as $s)
                                        @if($jurisdict->id == $s->jurisdiction_id)
                                            <?php $c = true; ?>
                                        @endif
                                    @endforeach
                                    <input type="checkbox" {{($c)?"checked":""}} name="jurisdiction[]" value="{{$jurisdict->id}}"/>{{$jurisdict->levelName}}<br/>
                                @endforeach 
                            </div>
                            <input type="submit" class="btn btn-success"/>
                       
                    
                        {!! Form::close() !!} 
                        
                </div>
            </div>
        </div>
    </div>
</div>
@endsection