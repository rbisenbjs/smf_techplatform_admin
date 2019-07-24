@extends('layouts.userBased')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">{{$levelNameData}}s</h1>
    <p class="mb-4">
        @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif
    </p>

    <!-- DataTables Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary" style="float:left;">
                
                <a href="/{{$orgId}}/jurisdictionlevel/create/{{$levelNameData}}" class="btn btn-primary btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">{{$levelNameData}}</span>
                </a>
            </h6>
            <h6 class="m-0 font-weight-bold text-primary" style="float:right;">
                <a href="/{{$orgId}}/jurisdictions" class="btn btn-primary btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-arrow-left"></i>
                </span>
                <span class="text">Back to Jusrisdictions</span>
                </a>
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>{{$levelNameData}} Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>{{$levelNameData}} Name</th>
                        <th>Action</th>
                    </tr>
                    </tfoot>
                    <tbody>
                  
                        @forelse($collectionData as $collectionKey => $collectionVal)
                        <tr>
                        
                            <td>{{$collectionVal['name']}}</td>
                            <td>
                                <div class="actions">
                                    <div style="float:left !important;padding-left:5px;">
                                        <a class="btn btn-primary btn-circle btn-sm" href="{{route('jurisdictionlevel.edit', ['id' => $collectionVal['_id'],'levelNameData' => $levelNameData] )}}"><i class="fas fa-pen"></i></a>
                                    </div>
                                    <div style="float:left !important;padding-left:5px;">
                                    <form action="{{ url('jurisdictionlevel', $collectionVal['_id'] ) }}" method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <input type="hidden" name="levelNameData" value="{{$levelNameData}}" />
                                    <button type="submit" class="btn btn-danger btn-circle btn-sm" ><i class="fas fa-trash"></i></button>
                                    </form>
                                    
                                    </div>
                                    <div style="clear:both !important;"></div>  
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td>No {{$levelNameData}}s</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
@endsection