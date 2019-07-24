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
                    <h3>Create Jurisdiction Type</h3>
                    @if (count($jurisdictions))
                        <form action="{{route('jurisdiction-types.store', ['orgId' => $orgId])}}" method="POST" class="marginTop">
                            @csrf
                            <div class="form-group">
                                <label for="jurisdictions" class="font-weight-bold required">Select Jurisdictions</label>
                                <select required multiple name="jurisdictions[]" class="form-control" id="jurisdictions">
                                    @foreach ($jurisdictions as $jurisdiction)
                                        <option value="{{ $jurisdiction->levelName }}">{{ $jurisdiction->levelName }}</option>
                                    @endforeach
                                </select>
                                @if($errors->any())
                                    <b style="color:red">{{$errors->first()}}</b>
                                @endif
                            </div>
                            <input type="submit"  value="Save"  class="btn btn-primary btn-user btn-block"/>
                        </form>
                    @else
                        <p>Please create Jurisdiction first to create Jurisdiction Type.</p>
                    @endif
                    
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
	@include('layouts.footers.auth')
</div>
@endsection