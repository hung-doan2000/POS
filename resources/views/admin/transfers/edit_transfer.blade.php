@extends('admin.layouts.app')
@section('alert')
@include('admin.alert')
@stop
@section('content')
<form action="{{route('admin.transfers.update_transfer', $transfer->id)}}" method="post">
    @csrf
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="menu">Title</label>
                    <input type="text" name="title" value="{{old('title',$transfer->title)}}" class="form-control">
                </div>
            </div>
            <div class="col-md-6">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="menu">Cửa hàng gửi</label>
                        <input type="text" value="{{$store_send? $store_send->name:''}}" class="form-control" disabled>
                        <input type="hidden" name="store_send" value="{{$transfer->store_send}}" class="form-control">
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="menu">Description</label>
                    <input type="text" name="description" value="{{old('description',$transfer->description)}}" class="form-control">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="menu">Cửa hàng nhận</label>
                    <select class="form-control" name="store_take" aria-label="Default select example">
                        @foreach ($stores as $store)
                        <option value="{{$store->id}}" <?php echo $transfer->store_take == $store->id ? 'selected' : '' ?>>{{$store->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Lưu</button>
        </div>
        @csrf
</form>
@stop
