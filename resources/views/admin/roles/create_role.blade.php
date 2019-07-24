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
                    <h3>Create Role</h3>
                    <form action="{{route('role.store')}}" method="post">
                           {{csrf_field()}}     
                        <legend></legend>
                             <div class="form-group">
                                 <label for="name">Role Name</label>
                                 <input type="text" name="name" placeholder="Role Name"class="form-control"/>
                                    @if ($errors->has('name'))
                                        <b style="color:red">{{$errors->first('name')}}</b>
                                    @endif
                             </div>
                             <div class="form-group">
                                    <label for="display_name">Display Name</label>
                                    <input type="text" name="display_name" placeholder="Display Name"class="form-control"/>
                            </div>
                             <div class="form-group">
                                <label for="description">Description</label>
                                 <input type="text" name="description" placeholder="Description"class="form-control"/>
                            </div>
                            <div class="form-group sub-con">
                            <div  class="form-group" >
                            <label for="organisation">Organisation</label>
                            
                                <select name="org_id" id ="orgid" class="form-control">
                                    <option value=""></option>
                                    @foreach($orgs as $org)
                                        <option value={{$org->id}}>{{strtoupper($org->name)}}</option>
                                    @endforeach 
                                </select>
                                    @if ($errors->has('org_id'))   
                                        <b style="color:red">{{$errors->first('org_id')}}</b>
                                    @endif
                                <br/>
                                <label for="projects">Projects</label>
                                
                                <select name="project_id" id="project_id" class="form-control">
                                    <option value=""></option>
                                </select>
                        </div>
                        </div>
                            <input type="submit" class="btn btn-primary btn-user btn-block"/>
                         </form>
                        
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
	@include('layouts.footers.auth')
</div>
@endsection