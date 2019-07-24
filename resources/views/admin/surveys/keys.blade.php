@extends('layouts.userBased',compact('orgId'))
@section('content')
<div class="container">
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default" style="padding-left:50px;padding-top:40px;padding-bottom:75px;">
                        <div class="panel-body">
                            <form action="{{url('form/storeKeys')}}" method="post">
                                {{csrf_field()}}     
                                <h2>Selecting Unique Keys</h2><br/>
                                @for($i=0;$i<$numberOfKeys;$i++)
                                <label><b>                
                                <input type="checkbox" value="{{$keys[$i]}}" name="primaryKeys[]"/>&nbsp;&nbsp;{{$keys[$i]}}
                                </b></label>
                                <br/>
                                @endfor

                                <br/><br/>
                                <h3>Form Title Structure</h3>
                                <div class="form-group">
                                    <label for="pretextName">PreText</label>
                                    <input type="text" name="pretext_title" placeholder="Title Pretext" class="form-control"/>
                                </div>
                                <div class="form-group">
                                    <label for="title_fields">Title Fields</label>
                                    <select multiple="multiple" name="title_fields[]" id="title_fields" style="max-width:100%;">
                                        @for($i=0;$i<$numberOfKeys;$i++)
                                        <option value="{{$keys[$i]}}" >{{$keys[$i]}}</option>
                                        @endfor
                                    </select>
                                </div>                                 
                                <div class="form-group">
                                    <label for="posttextName">PostText</label>
                                    <input type="text" name="posttext_title" placeholder="Title Posttext" class="form-control"/>
                                </div>   
                                <div class="form-group">
                                    <label for="separator">Separator</label>
                                    <select name="separator" id ="separator" class="form-control">
                                        <option value='' selected disabled hidden>--Please Select--</option>
                                        <option value=" ">Blank Space</option>
                                        <option value="-">Hyphen</option>
                                    </select>
                                </div>      
                                <input type="hidden" name="surveyID" value="{{$survey_id}}" />
                                <input type="submit" class="btn btn-success"/>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
