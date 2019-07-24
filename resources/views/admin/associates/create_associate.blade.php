@extends('layouts.userBased')

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
                    <h3>Create Associate</h3>
                    <form action="{{route('associates.store',['orgId' => $orgId])}}" method="post">
                           {{csrf_field()}}     
                        
                             <div class="form-group">
                                 <label for="name">Name</label>
                                 <input type="text" name="name" placeholder="Associate Name"class="form-control"/>
                             </div>
                             <div class="form-group">
                                    <label for="display_name">Display Name</label>
                                    <input type="text" name="display_name" placeholder="Display Name"class="form-control"/>
                            </div>
                             <div class="form-group">
                                <label for="type">Type</label>
                                <select name="type" class="form-control">
                                        <option value="0"></option>
                                        <option value="donor"> Donor </option>                                                                                               
                                        <option value="vendor"> Vendor </option>                                                                                               
                                        <option value="partner"> Partner </option>                                                                                               
                                </select>    
                            </div>
                            
                            <div  class="form-group" >
                                <label for="contact_person">Contact Person</label>
                                <input type ="text" name="contact_person" placeholder="Contact Person" class="form-control">
                            </div>
                            <div class="form-group">
                                    <label for="contact_number">Contact Number</label>
                                    <input type="text" name="contact_number" placeholder="Contact Number"class="form-control"/>
                            </div>
                            <input type="submit" class="btn btn-primary btn-user btn-block"/>
                    </form>
                        
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
</div>
@endsection