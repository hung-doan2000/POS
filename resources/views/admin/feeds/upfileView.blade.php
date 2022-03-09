@extends('admin.layouts.app')
@section('alert')
@include('admin.alert')
@stop
@section('content')
<div class="row">
    <div class="col-md-6">
        <form method='post' action="{{route('admin.feeds.upFbcode')}}" enctype='multipart/form-data'>
            {{ csrf_field() }}
            <div class="mb-3">
                <label for="formFile" class="form-label">Import Facebook Category code transfers by .csv file</label>
                <input type='file' name='fileFb'>
                <input type='submit' name='submit' value='Import'>
            </div>
        </form>
    </div>

    <div class="col-md-6">
        <form method='post' action="{{route('admin.feeds.upGgcode')}}" enctype='multipart/form-data'>
            {{ csrf_field() }}
            <div class="mb-3">
                <label for="formFile" class="form-label">Import Google Category code by .csv file</label>
                <input type='file' name='fileGg'>
                <input type='submit' name='submit' value='Import'>
            </div>
        </form>
    </div>

</div>
@stop
