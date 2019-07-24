@extends('layouts.app')

@section('content')
    @include('layouts.headers.cards')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Reports</h1>
    <p class="mb-4">
        @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif
    </p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <a href="{{route('reports.create', $orgId)}}" class="btn btn-primary btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">Report</span>
                </a>
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>URL</th>
                            <th>Category</th>
                            <th>Is Active</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>URL</th>
                        <th>Category</th>
                        <th>Is Active</th>
                        <th>Action</th>
                    </tr>
                    </tfoot>
                    <tbody>
                        @forelse($reports as $report)
                        <tr>
                            <td>{{$report->name}}</td>
                            <td>{{$report->description}}</td>
                            <td>{{$report->url}}</td>
                            <td>{{ $report->category['name']['default'] }}</td>
                            <td>@if ($report->active == 1)
                                    {{'Active'}}
                                @else
                                    {{'Inactive'}}
                                @endif
                            </td>
                            <td>
                                <div class="actions">
                                    <div style="float:left !important;padding-left:5px;">
                                        <a class="btn btn-primary btn-circle btn-sm" href={{route('reports.edit', ['orgId' => $orgId, 'id' => $report->id])}}><i class="fas fa-pen"></i></a>
                                    </div>
                                    <div style="float:left !important;padding-left:5px;">
                                    {!!Form::open(['route' => ['reports.destroy', $orgId, $report->id],'method' => 'DELETE', 'class' => 'pull-right'])!!}
                                        <button type="submit" class="btn btn-danger btn-circle btn-sm"><i class="fas fa-trash"></i></button>
                                    {!!Form::close()!!}
                                    </div>
                                    <div style="clear:both !important;"></div>  
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td>No Reports Found !!</td></tr>
                        @endforelse
                        </tbody>
                </table>
            </div>
        </div>
    </div>
@include('layouts.footers.auth')
</div>
<!-- /.container-fluid -->
@endsection