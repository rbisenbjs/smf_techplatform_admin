@extends('layouts.app')

@section('content')
    @include('layouts.headers.cards')
<!-- Begin Page Content -->
<div class="container-fluid">
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
   <!-- <h6 class="m-0 font-weight-bold text-primary">
        <a href="/{{$orgId}}/jurisdiction-types/create" class="btn btn-primary btn-icon-split">
        <span class="icon text-white-50">
            <i class="fas fa-plus"></i>
        </span>
        <span class="text">Create</span>
        </a>
    </h6> -->	
	<a href="/{{$orgId}}/forms/create" class="btn btn-success"> <i class="fas fa-plus"></i> <span class="text">Create</span></a>	
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered table-dark" id="dataTable" width="100%" cellspacing="0">
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
            @forelse ($jurisdictionTypes as $jurisdictionType)
            <?php $jurisdiction = "" ?>
            <tr>
                @foreach($jurisdictionType->jurisdictions as $type)
                    @if($jurisdiction != "")
                        <?php $jurisdiction = $jurisdiction.", ".$type ?>
                    @else
                        <?php $jurisdiction = $type ?>
                    @endif
                @endforeach
                    <td>{{ $jurisdiction }}</td>
                    <td>
                    <div class="actions">
                        <div title="Edit Jurisdiction  Type" style="float:left !important;padding-left:5px;">
                            <a class="btn btn-primary btn-circle btn-sm" href="/{{$orgId}}/jurisdiction-types/{{$jurisdictionType->id}}/edit"><i class="fas fa-pen"></i></a>
                        </div>
                        <div title="Delete Jurisdiction  Type" style="float:left !important;padding-left:5px;"> 
                            {!!Form::open(['route' => ['jurisdiction-types.destroy', $orgId, $jurisdictionType->id],'method' => 'DELETE', 'class' => 'pull-right'])!!}
                            <button type="submit" class="btn btn-danger btn-circle btn-sm"><i class="fas fa-trash"></i></button>
                            {!!Form::close()!!}
                        </div>
                        <div style="clear:both !important;"></div>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td>No Jurisdiction Type created yet.</td></tr>
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
