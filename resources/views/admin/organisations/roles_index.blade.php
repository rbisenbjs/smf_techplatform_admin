@extends('layouts.app')

@section('content')
    @include('layouts.headers.cards')
<!-- Begin Page Content -->
<div class="container-fluid">

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Organisation Roles</h1>
<p class="mb-4">
@if (session('status'))
  <div class="alert alert-success">
      {{ session('status') }}
  </div>
@endif
</p>

<!-- DataTales Example -->
<div class="card shadow mb-4">
  
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>Name</th>
                <th>Action</th>
            </tr>
        </tfoot>
        <tbody>
            @forelse($roles as $role)
                <tr>
                    <td>{{$role->display_name}}</td>
                    <td> 
                        <div>
                            <a class="btn btn-primary"  href='/{{$orgId}}/roles/{{$role->id}}'>Configure</a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td>No Roles Found</td></tr>
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