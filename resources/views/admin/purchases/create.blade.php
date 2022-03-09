@extends('admin.layouts.app')
@section('alert')
    @include('admin.alert')
@stop
@section('content')
    <form action="{{route('admin.purchases.store')}}" method="post">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="menu">Purchase ID</label>
                        <input type="text" name="purchase_id" value="{{old('purchase_id')}}" class="form-control" placeholder="Nhập mã đơn hàng">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="menu">Tên Đơn hàng</label>
                        <input type="text" name="title" value="{{old('title')}}" class="form-control" placeholder="Nhập tên đơn hàng">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="menu">Nơi nhập hàng</label>
                        <input type="text" name="place_order" value="{{old('place_order')}}" class="form-control" placeholder="Nơi đặt hàng">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="menu">Xuất tới kho</label>
                        <input type="text" name="stock_id" value="{{old('stock_id')}}" class="form-control" placeholder="Nhập kho nhận hàng">
                    </div>
                </div>
            </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Tạo đơn hàng</button>
        </div>
        @csrf
    </form>
@stop
