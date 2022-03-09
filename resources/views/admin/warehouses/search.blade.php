@extends('admin.layouts.app')
@section('alert')
    @include('admin.alert')
@stop
@section('content')
    <table >
        <thead>
            <tr style="font-weight:600">    
                <td>  </td>           
                <td>Tên sản phẩm</td>
                <td>Số lượng</td>
            </tr>
        </thead>
        <tbody>
        @forelse($products as $product)
            <tr>
                <td>   </td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->quantity }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="5"><p> No product</p></td>
            </tr>
        @endforelse
        </tbody>
    </table>
@stop
