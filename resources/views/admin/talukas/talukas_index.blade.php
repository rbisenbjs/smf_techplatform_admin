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
                            <h3 class="col-md-9">Talukas</h3>
                            <a class ="btn btn-success"href="{{route('taluka.create')}}">Taluka <i class="fas fa-plus"></i></a>
                    </div>
                       
                        <table class="table">
                            <tr>
                                {{-- <th>Taluka ID</th> --}}
                                <th>Taluka Name</th>
                                <th>State Name</th>
                                <th>District Name</th>
                                <th>Action</th>
                            </tr>
                            @forelse($talukas as $taluka)
                                <tr>
                                    {{-- <td>{{$t->id}}</td> --}}
                                    <td>{{$taluka->Name}}</td>
                                    <td>{{App\Taluka::find($taluka->id)->state['Name']}}</td>
                                    <td>{{App\Taluka::find($taluka->id)->district['Name']}}</td>
                                    <td> <div class="actions">
                                            <a class="btn btn-primary" href={{route('taluka.edit',$taluka->id)}}><i class="fas fa-pen"></i></a>
                                        {!!Form::open(['action'=>['TalukaController@destroy',$taluka->id],'method'=>'DELETE','class'=>'pull-right' ])!!}
                                            
                                        <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>
                                        {!!Form::close()!!}
                                        </div>    
                                    </td>
                                </tr>
                                @empty
                                <tr><td>no Talukas</td></tr>
                            @endforelse
                        </table>   
                        
                </div>
            </div>
        </div>
    </div>
</div>
@endsection