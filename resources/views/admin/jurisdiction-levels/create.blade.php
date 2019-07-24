@extends('layouts.userBased')

@section('content')
<div class="container">
<div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default" style="padding-left:50px;padding-top:40px;padding-bottom:75px;">
                <div class="panel-heading"></div>
                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        <h3>Create {{$levelNameData}}</h3>
                        <form action="{{route('jurisdictionlevel.store', ['orgId' => $orgId, 'levelNameData' => $levelNameData ])}}" method="post">
                        {{csrf_field()}}     
                            <legend></legend>
                            <input type="hidden" name="levelNameData" class="form-control" value="{{$levelNameData}}"/>
                            <div class="form-group">
                                <label for="{{$levelNameData}}">{{$levelNameData}} Name</label>
                                <input type="text" name="name" placeholder="Name of the {{$levelNameData}}" class="form-control"/>
                                @if($errors->any())
                                 <b style="color:red">{{$errors->first('name')}}</b>
                                @endif
                            </div>
                            <div class="form-group" style="clear:both;"></div>
                            <input type="submit" class="btn btn-primary btn-user btn-block" value="Create"/>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- </div> -->
    </div>
</div>
@endsection