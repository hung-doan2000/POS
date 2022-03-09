@extends('admin.layouts.app')
@section('alert')
@include('admin.alert')
@stop
@section('content')
<div class="row">
    <div class="col-md-6">
        <form method='post' action="{{route('admin.purchases.uploadFile')}}" enctype='multipart/form-data'>
            {{ csrf_field() }}
            <div class="mb-3">
                <label for="formFile" class="form-label">Import products to purchases by .csv file</label>
                <input type='file' name='file'>
                <input type='submit' name='submit' value='Import'>
            </div>
        </form>
    </div>
    <div class="col-md-6">
        <a href="{{route('admin.purchases.complete_purchases')}}" type="button" class="btn btn-default" style="margin-Top: 20px">Đơn đã hoàn thành</a>
    </div>
</div>
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
            <td>
                <a href="{{ route('admin.purchases.detail',$purchase->purchase_id)}}" type="button" class="btn btn-primary"><i class="fas fa-info"></i></a>
                <a href="{{ route('admin.purchases.edit',$purchase->purchase_id)}}" type="button" class="btn btn-success"><i class="fas fa-edit"></i></a>
                <button type="button" class="delete btn btn-danger" data={{$purchase->id}}><i class="fas fa-trash"></i></button>
            </td>
        </tr>
        @endforeach
    </tbody>
    <div class="card-footer clearfix">
        {!! $purchases->links() !!}
    </div>
</table>
@stop
@section('js')
<script type="text/javascript">
    $(document).ready(function() {
        $('.delete').click(function() {
            $('#id').val($(this).attr('data'))
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
            <form action="{{route('admin.purchases.delete_purchase')}}" method="post">
                @csrf
                @method('DELETE')
                <input type="hidden" name="id" id="id" value="0">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete purchase !</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you want to delete this purchase?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop
