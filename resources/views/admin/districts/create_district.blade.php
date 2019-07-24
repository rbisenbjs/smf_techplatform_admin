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
                        <h3>Create District</h3>
                    <form action="{{route('district.store')}}" method="post">
                           {{csrf_field()}}     
                        <legend></legend>
                             <div class="form-group">
                                 <label for="districtName">District Name</label>
                                 <input type="text" name="districtName" placeholder="name of the district" class="form-control"/>
                                 @if($errors->any())
                                 <b style="color:red">{{$errors->first()}}</b>
                                 @endif
                             </div>
                             <div>
                                <h4>State</h4>
                                    <select name="state_id" class="form-control">
                                            @foreach($states as $s)
                                                <option value={{$s->id}}>{{$s->Name}}</option>
                                            @endforeach 
                                    </select>
                            </div>
                            <input type="submit" class="btn btn-success"/>
                         </form>                        
                </div>
            </div>
        </div>
    </div>
</div>
@endsection