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
					<h5 class="card-header info-color white-text text-center py-4">
						<strong>Edit Jurisdiction Type</strong>
					</h5>
                    @if (count($jurisdictions))
                        <form action="{{route('jurisdiction-types.update', ['orgId' => $orgId, 'jurisdiction_type' => $jurisdictionType->id])}}" method="POST" class="marginTop">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="jurisdictions" class="font-weight-bold required">Select Jurisdictions</label>
                                <select required multiple name="jurisdictions[]" class="form-control" id="jurisdictions">
                                    @foreach ($jurisdictions as $jurisdiction)
                                        <option value="{{ $jurisdiction->levelName }}" {{in_array($jurisdiction->levelName, $jurisdictionType->jurisdictions) ? 'selected="selected"' : ''}}>{{ $jurisdiction->levelName }}</option>
                                    @endforeach
                                </select>
                                @if($errors->any())
                                    <b style="color:red">{{$errors->first()}}</b>
                                @endif
                            </div>
                            <input type="submit" value="Save" class="btn btn-primary btn-user btn-block"/>
                        </form>
                    @else
                        <p>Please create Jurisdiction first to edit Jurisdiction Types.</p>
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