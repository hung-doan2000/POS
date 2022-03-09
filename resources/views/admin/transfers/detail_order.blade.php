@extends('admin.layouts.app')
@section('alert')
@include('admin.alert')
@stop
@section('content')
<table>
    <thead>
        <tr>
            <td>Product ID</td>
            <td>Quantity</td>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $product)
        <tr>
            <td>{{$product->product_id}}</td>
            <td>{{$product->quantity}}</td>
        </tr>
        @endforeach
    </tbody>
    <div class="card-footer clearfix">
        {!! $products->links() !!}
    </div>
</table>
@stop
