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
                                <h3 class="col-md-9">Clusters</h3>
                                <a class ="btn btn-success col"href="{{route('cluster.create')}}">Cluster   <i class="fas fa-plus"></i></a>
                        </div>
                     
                        <table class="table">
                            <tr>
                                {{-- <th>Cluster ID</th> --}}
                                <th>Cluster Name</th>
                                <th>State Name</th>
                                <th>District Name</th>
                                <th>Taluka ID</th>
                                <th>Action</th>
                            </tr>
                            @forelse($clusters as $cluster)
                                <tr>
                                    {{-- <td>{{$c->id}}</td> --}}
                                    <td>{{$cluster->Name}}</td>
                                    <td>{{App\Cluster::find($cluster->id)->state['Name']}}</td>
                                    <td>{{App\Cluster::find($cluster->id)->district['Name']}}</td>
                                    <td>{{App\Cluster::find($cluster->id)->taluka['Name']}}</td>
                                    <td>
                                            <div class="actions">
                                                    <a class="btn btn-primary"  href={{route('cluster.edit',$cluster->id)}}><i class="fas fa-pen"></i></a>
                                            {!!Form::open(['action'=>['ClusterController@destroy',$cluster->id],'method'=>'DELETE','class'=>'pull-right' ])!!}
                                            
                                            <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>
                                            {!!Form::close()!!}
                                         
                                        </div>  
                                    </td>
                                </tr>
                                @empty
                                <tr><td>no Clusters</td></tr>
                            @endforelse
                        </table>   
                        
                </div>
            </div>
        </div>
       
    </div>
</div>
@endsection