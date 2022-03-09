@extends('admin.layouts.app')
@section('alert')
@include('admin.alert')
@stop
@section('content')
<table>
    <thead>
        <tr>
            <td>Purchase ID</td>
            <td>Title</td>
            <td>Giá trị đơn hàng</td>
            <td>Đặt hàng từ</td>
            <td>Xuất hàng tới</td>
            <td></td>
        </tr>
    </thead>
    <tbody>
        @foreach($purchases as $purchase)
        <tr>
            <td>{{$purchase->purchase_id}}</td>
            <td>{{$purchase->title}}</td>
            <td>{{$purchase->money}}</td>
            <td>{{$purchase->place_order}}</td>
            <td>{{$purchase->stock_id}}</td>
            <td><a href="{{ route('admin.transfers.detail_purchase_order',$purchase->purchase_id)}}" type="button" class="btn btn-primary"><i class="fas fa-info"></i></a></td>
        </tr>
        @endforeach
    </tbody>
    <div class="card-footer clearfix">
        {!! $purchases->links() !!}
    </div>
</table>
@stop
