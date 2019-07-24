@extends('layouts.app')

@section('content')
<meta name="csrf-token" content="">
<!-- Begin Page Content -->
<div class="container-fluid">

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Users</h1>
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
        <a href="{{route('users.create')}}" class="btn btn-primary btn-icon-split">
        <span class="icon text-white-50">
            <i class="fas fa-plus"></i>
        </span>
        <span class="text">User</span>
        </a>
    </h6>
  </div>
  {{-- <div class="col-sm-12 col-md-6">
    <select  name="organisations" id="organisationOfUser" class="form-horizontal">
      <option value=""></option>
      @foreach($organisations as $organisation)
    <option value="{{$organisation->_id}}">{{ $organisation->name }}</option>
      @endforeach
  </select> --}}



  {{-- <button type="submit" class="btn btn-primary btn-circle btn-sm" onclick="myFunction()"><i class="fas fa-trash"></i></button> --}}
  {{-- <input type="submit" class="btn btn-primary btn-circle btn-sm"><i class="fas fa-trash"></i></input> --}}
  {{-- <button type="button" class="btn btn-primary btn-circle btn-sm"><i class="fas fa-trash"></i></button> --}}
  


{{-- </div> --}}
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>Name</th>
            <th>Email</th>
			<th>Phone</th>
            <th>Action</th>
          </tr>
        </thead>
        <tfoot>
         <tr>
            <th>Name</th>
            <th>Email</th>
			<th>Phone</th>
            <th>Action</th>
          </tr>
        </tfoot>
        <tbody id="userTable">





        @forelse($users as $user)
        <tr>
            <td>{{$user->name}}</td>
            <td>{{$user->email}}</td>
			<td>{{$user->phone}}</td>
            <td>
                <div class="actions">
                  <div style="float:left !important;padding-left:5px;">
                      <a class="btn btn-primary btn-circle btn-sm" href={{route('users.edit',$user->id)}}><i class="fas fa-pen"></i></a>
                  </div>
                  <div style="float:left !important;padding-left:5px;">
                    <form action="{{ url('user',$user->id) }}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button type="submit" class="btn btn-danger btn-circle btn-sm"><i class="fas fa-trash"></i></button>
                    </form>
                  </div>
                  <div style="clear:both !important;"></div>
                </div>
            </td>
        </tr>
        @empty
            <tr><td>no users</td></tr>
        @endforelse





        </tbody>
      </table>
    </div>
  </div>
</div>

</div>
<!-- /.container-fluid -->

@endsection