@extends('layouts.userBased')
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
                                <h2>Selecting Unique Keys</h2>
                                @for($i=0;$i<$numberOfKeys;$i++)
                                    @if(in_array($keys[$i],$primaryKeySet))
                                        <label><b>                
                                        <input type="checkbox" value="{{$keys[$i]}}" name="form_keys[]" checked/>&nbsp;&nbsp;{{$keys[$i]}}
                                        </b></label>
                                    @else
                                        <label><b>                
                                        <input type="checkbox" value="{{$keys[$i]}}" name="form_keys[]"/>&nbsp;&nbsp;{{$keys[$i]}}
                                        </b></label><br/>
                                    @endif
                                @endfor
                                <br/><br/>
                                <h3>Form Title Structure</h3>
                                <div class="form-group">
                                    <label for="pretextName">PreText</label>
                                    <input type="text" name="pretext_title" placeholder="Title Pretext" class="form-control" value="{{$pretext_title}}"/>
                                </div>
                                <div class="form-group">
                                    <label for="title_fields">Title Fields</label>
                                <input type="text" class="form-control" id="tokenfield" value="{{$title_fields_str}}" name="title_fields"/>
                                </div>                                 
                                <div class="form-group">
                                    <label for="posttextName">PostText</label>
                                    <input type="text" name="posttext_title" placeholder="Title Posttext" class="form-control" value="{{$posttext_title}}"/>
                                </div>   
                                <div class="form-group">
                                    <label for="separator">Separator</label>
                                    <select name="separator" id ="separator" class="form-control">
                                        <option value=''disabled hidden>--Please Select--</option>
                                        <option value=" " @if($separator == '') selected @endif >Blank Space</option>
                                        <option value="-" @if($separator == '-') selected @endif>Hyphen</option>
                                    </select>
                                </div>                                  
                                <input type="hidden" name="surveyID" value="{{$survey_id}}" />
                                {{-- <input type="hidden" name="redirectTo" value="{{$redirectUrl}}" /> --}}
                                <br/>
                                <input type="submit" class="btn btn-primary"/>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('css')
    {{-- <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">  --}}
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css"> 
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tokenfield/0.12.0/css/bootstrap-tokenfield.min.css">
@endpush

@push('scripts')
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tokenfield/0.12.0/bootstrap-tokenfield.js"></script>
    <script type="text/javascript">
        var primaryKeys = new Array('<?php echo implode(",", $keys); ?>');
        primaryKeys = primaryKeys[0].split(",");
$('#tokenfield').tokenfield(    
  {
  autocomplete: {
    source: primaryKeys,
    delay: 100
  },
  showAutocompleteOnFocus: true
});
console.log($('#tokenfield').tokenfield('getTokensList'));
    </script>
@endpush
