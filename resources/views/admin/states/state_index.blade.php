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

                        <div class="row">
                                <h3 class="col-md-9">States</h3>
                                <a class ="btn btn-success"href="{{route('state.create')}}">State   <i class="fas fa-plus"></i></a>
                            </div>
                        
                        <table class="table">
                        <tr>
                            {{-- <th>State ID</th> --}}
                            <th>State Name</th>
                            <th>Actions</th>
                        </tr>
                        @forelse($states as $state)
                        <tr>
                            {{-- <td>{{$state->id}}</td> --}}
                            <td>{{$state->Name}}</td>
                            <td><div class="actions">
                                    <a class="btn btn-primary"  href={{route('state.edit',$state->id)}}><i class="fas fa-pen"></i></a>
                            {!!Form::open(['action'=>['StateController@destroy',$state->id],'method'=>'DELETE','class'=>'pull-right' ])!!}
                        
                            <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>
                            {!!Form::close()!!}
                            </div>
                            </td>
                        </tr>
                        @empty
                            <tr><td>No States</td></tr>
                        @endforelse
                        </table>   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection