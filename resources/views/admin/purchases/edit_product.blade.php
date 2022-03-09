@extends('admin.layouts.app')
@section('alert')
@include('admin.alert')
@stop
@section('content')
<form action="{{route('admin.purchases.update_product', ['purchase_id'=>$product->purchase_id,'product_id'=>$product->product_id])}}" method="post">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="menu">Purchase ID</label>
                    <input type="text" name="purchase_id" value="{{$product->purchase_id}}" class="form-control" disabled>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="menu">Product</label>
                    <input type="text" name="product_id" value="{{$product->product_id}}" class="form-control" disabled>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="menu">Số lượng</label>
                    <input type="text" name="quantity" value="{{old('quantity',$product->quantity)}}" class="form-control" placeholder="Nhập số lượng">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="menu">Giá trị </label>
                    <input type="text" name="money" value="{{old('money',$product->money)}}" class="form-control" placeholder="Nhập giá tiền">
                </div>
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Lưu</button>
        </div>
        @csrf
</form>
@stop
