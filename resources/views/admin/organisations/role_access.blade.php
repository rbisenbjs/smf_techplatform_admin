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
                    @if (session('message'))
                        <div class="alert alert-success">
                            {{ session('message') }}
                        </div>
                    @endif
                    <h3>Role Name: {{$role->display_name}}</h3>
                    <form id="role-config" action="http://localhost/smf_techplatform_php/public/updateroleconfig/{{$role->id}}" method="post" class="form-horizontal">
                        {{csrf_field()}}  
                        <input type="hidden" name="org_id" value={{$orgId}} />  
                    <br/> <br/>
                        <div class="row form-group">
                            <div class="form-group col-md-12 row">
                                <label  class="col-md-3" for="name">Projects:</label>
                                <div class="col-md-9" >
                                <select name="assigned_projects" id="assigned_projects">
                                @foreach($projects as $project)
                                        <option value="{{$project['_id']}}"  @if($project['_id'] == $role->project_id) selected='selected'  @endif>{{$project['name']}}</option>
                                @endforeach
                                </select>
                                </div>
                                
                            </div>
                        </div>
                        
                        <div class="row form-group">
                            <div class="form-group col-md-12 row">
                                <label for="email" class="col-md-3" >Jurisdiction Type:</label>
                                <div class="col-md-9">
                                    <input type="text" name="jurisdiction_type_id" id="jurisdiction_type_id" jurisdictionId="" class="form-control" disabled/>
                                    
                                    {{-- <select  name="jurisdiction_type_id" id="jurisdiction_type_id">
                                        <option value=""></option>
                                        @foreach($jurisdictionTypes as $type)
                                        <option value="{{$type->_id}}" @if($type == $role->project['jurisdiction_type_id']) selected='selected'   @endif>{{ json_encode($type->jurisdictions)}} 
                                             $levels = $type->jurisdictions ?>
                                        </option>
                                        @endforeach
                                    </select> --}}
                                </div>
                            </div>   
                        </div>  

                        <div id="jurisdiction_id"></div>

                        <div class="row form-group">
                            <div class="form-group col-md-12 row">
                                <label for="email" class="col-md-3" >Level:</label>
                                <div class="col-md-9">
                                <select name="levelNames" id="levelNames" value="{{ $jurisdictionName }}">
                                        {{-- <option value=""></option>
                                        
                                        @foreach($jurisdictions as $jurisdiction)
                                            @if(in_array($jurisdiction->levelName,$levels))
                                                <option value="{{$jurisdiction->id}}" @if($jurisdiction->id == $roleConfig['level']) selected='selected'   @endif>{{$jurisdiction->levelName}}</option>
                                            @endif
                                        @endforeach --}}
                                    </select>
                                </div>
                            </div>   
                        </div>  

                        <div class="row form-group">
                            <div class="form-group col-md-12 row">
                                    <label for="email" class="col-md-3" >Default Modules:</label>
                                    <div class="col-md-9">
                                <select multiple="multiple" name="default_modules[]" id="default_modules">
                                @foreach($modules as $module)
                                @if (!empty($module['name']))
                                        <option value="{{$module['_id']}}" @if(in_array($module['_id'],$role_default_modules)) selected='selected'  @endif>{{$module['name']['default']}}</option>
                                @endif
                                @endforeach
                                </select>
                                    </div>
                            </div>
                        </div>

                        <div class="row form-group">
                             <div class="form-group col-md-12 row">
                                    <label for="email" class="col-md-3" >On Approve Modules:</label>
                                    <div class="col-md-9">
                                <select multiple="multiple" name="on_approve[]" id="on_approve">
                                @foreach($modules as $module)
                                @if (!empty($module['name']))
                                        <option value="{{$module['_id']}}" @if(in_array($module['_id'],$role_onapprove_modules)) selected='selected'  @endif>{{$module['name']['default']}}</option>
                                @endif
                                @endforeach
                                </select>
                                    </div>
                            </div>   
                        </div>                            

                        <div class="row form-group">
                            <div class="form-group col-md-12 row">
                                <label for="email" class="col-md-3" >Approver Role:</label>
                                <div class="col-md-9">
                                    <select  name="approver_role" id="approver_role">
                                        <option value=""></option>
                                        @foreach($org_roles as $org_role)
                                        <option value="{{$org_role['_id']}}" @if($org_role['_id'] == $approver_role) selected='selected'  @endif>{{$org_role['display_name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>   
                        </div>  
                        
                        <div class="row form-group">
                                <div class="form-group col-md-12 row">
                                       <label for="email" class="col-md-3" >Associate:</label>
                                       <div class="col-md-9">
                                   <select  name="associate">
                                       <option value=""></option>
                                   @foreach($associates as $associate)
                                       <option value="{{$associate->id}}" @if($associate->id == $associate_id) selected='selected'  @endif>{{$associate->name}}</option>
                                   @endforeach
                                   </select>
                               </div>
                               </div>   
                           </div>    
                        
                        </div>
                            <input type="submit" class="btn btn-primary btn-user btn-block"/>
                            <br/>
                    </form>
                        
                </div>
            </div>
        </div>
    </div>
    <!-- </div>
    </div> -->
</div>
@include('layouts.footers.auth')
@endsection