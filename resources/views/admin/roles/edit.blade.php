@extends('layouts.app')

@section('content')
    @include('layouts.headers.cards')
<div class="container">
<div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default" style="padding-left:50px;padding-top:40px;padding-bottom:75px;">
               
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                        <h3>Edit Role</h3>

                        {!! Form::model($role, ['route' => [ 'role.update', $role->id ], 'method'=>'PUT', 'id' => 'role-edit-form']) !!}
                        
                        {{csrf_field()}} 
                        <legend></legend>
                             <div class="form-group">
                                    <label for="display_name">Role Name</label>
                                    <input type="text" name="display_name" placeholder="Display Name"class="form-control" value="{{$role->display_name}}"/>
                            </div>
                             <div class="form-group">
                                <label for="description">Description</label>
                                 <input type="text" name="description" placeholder="description"class="form-control"value="{{$role->description}}"/>
                            </div>
                            <div class="form-group sub-con">
                            <div class="form-group" >
                            <label for="organisation">Organisation</label>
                                <select name="org_id" id ="orgidedit" class="form-control">
                                    @foreach($orgs as $org)
                                        <option value={{$org->id}}  {{ ($org->id===$role->org_id) ?"selected":""}}>{{strtoupper($org->name)}}</option>
                                    @endforeach 
                                </select>
                                <br/>
                                <label for="projects">Projects</label>
                                <select name="project_id" id="project_id" class="form-control">
                                    @foreach($projects_arr as $proj_arr)
                                        <?php $selected_attrb_flag = false; ?>
                                        @if($proj_arr['_id'] == $project_id)
                                            <?php $selected_attrb_flag = true; ?>
                                        @endif
                                        <option value="{{$proj_arr['_id']}}" {{ $selected_attrb_flag ? "selected":""}}>{{$proj_arr['name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                            </div>
                            <input type="submit" class="btn btn-primary btn-user btn-block"/>
                       {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
	@include('layouts.footers.auth')
</div>
@endsection