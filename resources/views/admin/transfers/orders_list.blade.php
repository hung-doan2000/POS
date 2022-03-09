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
            <td></td>
        </tr>
    </thead>
    <tbody>
        @foreach($transfers as $transfer)
        <tr>
            <td>{{$transfer->id}}</td>
            <td>{{$transfer->title}}</td>
            <td>{{$transfer->store_send}}</td>
            <td>
            <a href="{{ route('admin.transfers.detail_transfer_order',$transfer->id)}}" type="button" class="btn btn-primary"><i class="fas fa-info"></i></a>
                <button type="button" class="take_transfer btn-warning" data={{$transfer->id}}>Nhận hàng</button>
            </td>
        </tr>
        @endforeach
    </tbody>
    <div class="card-footer clearfix">
        {!! $transfers->links() !!}
    </div>
</table>

<table>
    <thead>
        <tr>
            <td>Purchase ID</td>
            <td>Title</td>
            <td>Value</td>
            <td>Place send</td>
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
            <td>
            <a href="{{ route('admin.transfers.detail_purchase_order',$purchase->purchase_id)}}" type="button" class="btn btn-primary"><i class="fas fa-info"></i></a>
                <button type="button" class="take_purchase btn-warning" data={{$purchase->id}}>Nhận hàng</button>
            </td>
        </tr>
        @endforeach
    </tbody>
    <div class="card-footer clearfix">
        {!! $transfers->links() !!}
    </div>
</table>
@stop
@section('js')
<script type="text/javascript">
    $(document).ready(function() {
        $('.take_transfer').click(function() {
            $('#trans_id').val($(this).attr('data'))
            $('#pur_id').val(0)
            $('#takeModal').modal({
                keyboard: false
            })
            $('#takeModal').modal('show');
        });

        $('.take_purchase').click(function() {
            $('#trans_id').val(0)
            $('#pur_id').val($(this).attr('data'))
            $('#takeModal').modal({
                keyboard: false
            })
            $('#takeModal').modal('show');
        });
    });
</script>
@stop
@section('modal')
<!-- Modal -->
<div class="modal fade" id="takeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{route('admin.transfers.take_order')}}" method="post">
                @csrf
                <input type="hidden" name="trans_id" id="trans_id" value="0">
                <input type="hidden" name="pur_id" id="pur_id" value="0">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Take order !</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you want to take order?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="submit_delete">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop
