@extends('admin.layouts.app')
@section('alert')
@include('admin.alert')
@stop
@section('content')
<form action="{{route('admin.purchases.update_payment',$payment->id)}}" method="post">
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="menu">Purchase ID</label>
                    <input type="text" class="form-control" value="{{old('purchase_id',$payment->purchase_id)}}" placeholder="Nhập purchase_id" disabled>
                    <input type="hidden" class="form-control" name="purchase_id"  value="{{$payment->purchase_id}}" placeholder="Nhập purchase_id">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="menu">Hình thức thanh toán</label>
                    <select class="form-control" name="name_code" aria-label="Default select example">
                        <option value="1" <?php echo $payment->code_bill?'selected':'' ?> >Tiền mặt</option>
                        <option value="2" <?php echo $payment->trade_code?'selected':'' ?>>Chuyển khoản</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="menu">Mã / Code</label>
                    <input type="text" name="code"  value="{{old('code',$payment->code_bill?$payment->code_bill:$payment->trade_code)}}" class="form-control" placeholder="Nhập mã">
                </div>
            </div>
            <button type="submit" id="add_payment" class="btn btn-primary">Lưu</button>
        </div>

    </div>
    @csrf
</form>
@stop
