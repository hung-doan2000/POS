@extends('admin.layouts.app')
@section('alert')
@include('admin.alert')
@stop
@section('content')
<form id="form" action="{{route('admin.purchases.add_payment')}}" method="post">
    @csrf
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="menu">Purchase ID</label>
                    <input type="text" class="form-control" name="purchase_id" id="purchase_id" placeholder="Nhập purchase_id">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="menu">Hình thức thanh toán</label>
                    <select class="form-control" name="name_code" aria-label="Default select example">
                        <option value="1">Tiền mặt</option>
                        <option value="2">Chuyển khoản</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="menu">Mã</label>
                    <input type="text" id="code" name="code" class="form-control" placeholder="Nhập mã">
                </div>
            </div>
            <button type="submit" id="add_payment" class="btn btn-primary">Lưu</button>
        </div>

    </div>
</form>
<table>
    <thead>
        <tr>
            <td>Purchase ID</td>
            <td>Title</td>
            <td>Giá trị đơn hàng</td>
            <td>Hình thức thanh toán</td>
            <td>Mã giao dịch</td>
            <td></td>
        </tr>
    </thead>
    <tbody id="body">
        @foreach($payments as $payment)
        <tr>
            <td>{{$payment->purchase_id}}</td>
            <td>{{$payment->purchase?$payment->purchase->title:''}}</td>
            <td>{{$payment->purchase?$payment->purchase->money:''}}</td>
            <td>{{$payment->code_bill?'Tiền mặt':'Chuyển khoản'}}</td>
            <td>{{$payment->code_bill?$payment->code_bill:$payment->trade_code}}</td>
            <td>
            <td><a href="{{route('admin.purchases.edit_payment',$payment->purchase_id)}}" type="button" class="btn btn-success"><i class="fas fa-edit"></i></a>
                <button type="button" class="delete btn btn-danger" data="{{$payment->id}}"><i class="fas fa-trash"></i></button>
            </td>
            </td>
        </tr>
        @endforeach
    </tbody>
    <div class="card-footer clearfix">
        {!! $payments->links() !!}
    </div>
</table>
@stop
@section('js')
<script type="text/javascript">
    $(document).ready(function() {
        $('.delete').click(function() {
            $('#payment_id').val($(this).attr('data'))
            $('#deleteModal').modal({
                keyboard: false
            })
            $('#deleteModal').modal('show');
        });
    });
</script>
@stop
@section('modal')
<!-- Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{route('admin.purchases.delete_payment')}}" method="post">
                @csrf
                @method('DELETE')
                <input type="hidden" name="payment_id" id="payment_id" value="0">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete payment !</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you want to delete this payment?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="submit_delete">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop
