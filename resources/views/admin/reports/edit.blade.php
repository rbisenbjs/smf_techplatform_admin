@extends('layouts.app')

@section('content')
    @include('layouts.headers.cards')
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
                        
                        <h3>Edit Report</h3>
                        {!! Form::model($report, ['route' => ['reports.update', $orgId, $report->id], 'method'=>'PUT', 'id' => 'report-edit-form']) !!}
                        {{csrf_field()}} 
                        <legend></legend>
                        <div class="form-group">
                            <label for="name">Report Name</label>
                            <input type="text" name="name" placeholder="Report Name"class="form-control" value="{{$report->name}}"/>
                            @if($errors->any())
                                <b style="color:red">{{$errors->first('name')}}</b>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <input type="text" name="description" placeholder="description"class="form-control"value="{{$report->description}}"/>
                        </div>
                        <div class="form-group">
                            <label for="url">URL</label>
                            <input type="text" name="url" placeholder="URL"class="form-control"value="{{$report->url}}"/>
                            @if($errors->any())
                                 <b style="color:red">{{$errors->first('url')}}</b>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="category">Category</label>
                            <select name="category" class="form-control">
                                <option value="0"></option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" @if($category->id == $report->category_id) selected="selected" @endif> {{ $category->name['default'] }} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" id="report-active" type="checkbox" name="active" value="1" id="defaultCheck1" {{ $report->active == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="report-active">
                                Active
                            </label>
                        </div>
                        
                        <div class="form-group" style="clear:both;"></div>
                        <input type="submit" class="btn btn-primary btn-user btn-block" value="Update"/>
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