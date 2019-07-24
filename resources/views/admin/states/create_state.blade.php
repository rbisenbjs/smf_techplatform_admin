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
                        <h3>Create State</h3>
                    <form action="{{route('state.store')}}" method="post">
                           {{csrf_field()}}     
                        <legend></legend>
                             <div class="form-group">
                                    <label for="stateName">State Name</label>
                                    <input type="text" name="Name" placeholder="Name of the state"class="form-control"/>
                                    @if($errors->any())
                                        <b style="color:red">{{$errors->first()}}</b>
                                    @endif
                            </div>
                            <div class="form-group">
                                <h4>Jurisdiction</h4>
                                <div id="levels" >

                                </div>
                                <p id="addLevel" class="btn btn-sm btn-primary">Add Level <i class="fas fa-plus"></i></p>
                            </div>
                            <input type="submit" class="btn btn-success"/>
                         </form>
                        
                </div>
            </div>
        </div>
    </div>
</div>
@endsection