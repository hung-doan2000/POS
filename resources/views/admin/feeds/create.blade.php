@extends('admin.layouts.app')
@section('alert')
@include('admin.alert')
@stop
@section('css')

<link rel="stylesheet" href="/template/plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="/template/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
<!-- Bootstrap4 Duallistbox -->
<link rel="stylesheet" href="/template/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
<!-- BS Stepper -->
<link rel="stylesheet" href="/template/plugins/bs-stepper/css/bs-stepper.min.css">
<!-- dropzonejs -->
<link rel="stylesheet" href="/template/plugins/dropzone/min/dropzone.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="/template/dist/css/adminlte.min.css">

@stop
@section('content')
<form action="" method="post">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="menu">My Category</label>
                <select name="category_id" class="form-control select2" style="width: 100%;">
                    <option value=''>Vui lòng chọn</option>
                    @foreach($categories as $category)
                    <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="menu">FB_category</label>
                <select name="fb_cate_id" class="form-control select2" style="width: 100%;">
                    <option value=''>Vui lòng chọn</option>
                    @foreach($fbcategories as $category)
                    <option value="{{$category->fb_cate_id}}">{{$category->fb_category}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-6">
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="menu">GG_category</label>
                <select name="gg_cate_id" class="form-control select2" style="width: 100%;">
                <option value=''>Vui lòng chọn</option>
                    @foreach($ggcategories as $category)
                    <option value="{{$category->gg_cate_id}}">{{$category->gg_category}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="card-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
    @csrf
</form>

<table id="example2" class="display nowrap" cellspacing="0" width="100%">
    <thead>
        <tr style="font-weight:600">
            <td>My_Category</td>
            <td>FB_category</td>
            <td>GG_category</td>
        </tr>
    </thead>
    <tbody>
    @forelse($feedscategories as $category)
        <tr>
            <td>{{$category->name}}</td>
            <td>{{$category->fb_category}}</td>
            <td>{{$category->gg_category}}</td>
        </tr>
        @empty
            <tr>
                <td colspan="4"><p>No stores</p></td>
            </tr>
        @endforelse
    </tbody>
</table>
@stop
@section('js')
<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.11.2/js/jquery.dataTables.min.js"></script>

<script src="/template/plugins/jquery/jquery.min.js"></script>
<script src="/template/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/template/plugins/select2/js/select2.full.min.js"></script>
<script src="/template/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>

<script>
$(function() {
    //Initialize Select2 Elements
    $('.select2').select2()
    //Initialize Select2 Elements
    $('.select2bs4').select2({
        theme: 'bootstrap4'
    })
    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()
})
</script>
@stop