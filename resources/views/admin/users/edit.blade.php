@extends('layouts.app')

@section('content')
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
                        <h3>Edit User</h3>
                 
                      
                        

                        {!! Form::model($user, ['route' => [ 'users.update', $user->id ], 'method'=>'PUT', 'id' => 'user-edit-form']) !!}
                        
                        {{csrf_field()}} 
                        <legend></legend>
                             <div class="form-group">
                                 <label for="name">Name</label>
                                 <input type="text" name="name" placeholder="name"class="form-control"value="{{$user->name}}"/>
                             </div>
                             <div class="form-group">
                                    <label for="email">email</label>
                                    <input type="email" name="email" placeholder="email"class="form-control" value="{{$user->email}}"/>
                            </div>
                            
                            <div class="form-group{{ $errors->has('org_id') ? ' has-error' : '' }} ">
                                <label for="org_id" class="col-md-4 col-form-label ">Organisation</label>
    
                                <div >
                                    <select id="org_id"  class="form-control" name="org_id" required>
                                        <option value=0></option>
                                            @foreach($orgs as $org)
                                                 @if ($org->id ===$orgId))
                                                <option value={{$org->id}} selected>{{$org->name}}</option>
                                                @else
                                                <option value={{$org->id}} >{{$org->name}}</option>
                                                @endif
                                                
                                             @endforeach 
                                    </select>
    
                                    @if ($errors->has('org_id'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('org_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('role_id') ? ' has-error' : '' }}">
                                    <label for="role_id" class="col-md-4 col-form-label ">Role</label>
                                   
                                  
                                    <div >
                                        <select id="role_id"  class="form-control" name="role_id" required>
                                            <option value="0"></option>
                                            <option value={{$role->id}} selected>{{$role->name}}</option>
                                        </select>
        
                                        @if ($errors->has('role_id'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('role_id') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                            </div>
                            <div class="form-group">
                                <div>
                                <input type="checkbox" name="is_admin" @if($user->is_admin) checked @endif />
                                <label for="is_admin" class="col-md-4 col-form-label "><b>Is Org Admin</b></label>
                                </div>
                            </div>
                            <div class="form-group">
                                    <div>
                                    @if($user->approve_status == 'approved')
                                    <input type="checkbox" name="approved"  checked disabled/>
                                    @else
                                    <input type="checkbox" name="approved" />
                                    @endif
                                    <label for="userActive" class="col-md-4 col-form-label ">Is Approved</label>
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
</div>
@endsection