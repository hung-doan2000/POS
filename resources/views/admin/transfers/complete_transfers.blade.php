@extends('admin.layouts.app')
@section('alert')
@include('admin.alert')
@stop
@section('content')
<table>
    <thead>
        <tr>
            <td>Transfer ID</td>
            <td>Title</td>
            <td>Store send</td>
            <td>Store take</td>
            <td></td>
        </tr>
    </thead>
    <tbody>
        @foreach($transfers as $transfer)
        <tr>
            <td>{{$transfer->id}}</td>
            <td>{{$transfer->title}}</td>
            <td>{{$transfer->store_send}}</td>
            <td>{{$transfer->store_take}}</td>
            <td>
                <a href="{{ route('admin.transfers.detail_transfer_order',$transfer->id)}}" type="button" class="btn btn-primary"><i class="fas fa-info"></i></a>
            </td>
        </tr>
        @endforeach
    </tbody>
    <div class="card-footer clearfix">
        {!! $transfers->links() !!}
    </div>
</table>
@stop
