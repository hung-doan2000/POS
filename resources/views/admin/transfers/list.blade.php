@extends('admin.layouts.app')
@section('alert')
@include('admin.alert')
@stop
@section('content')
<form id="form" action="{{route('admin.transfers.add_transfer')}}" method="post">
    @csrf
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="menu">Title</label>
                    <input type="text" name="title" value="{{old('title')}}" class="form-control">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="menu">Cửa hàng gửi</label>
                    <select class="form-control" name="store_send" aria-label="Default select example">
                        @foreach ($stores as $store)
                        <option value="{{$store->id}}">{{$store->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="menu">Cửa hàng nhận</label>
                    <select class="form-control" name="store_take" aria-label="Default select example">
                        @foreach ($stores as $store)
                        <option value="{{$store->id}}">{{$store->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="menu">Mô tả</label>
                    <input type="textarea" name="description" value="{{old('description')}}" class="form-control">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Lưu</button>
        </div>

    </div>
</form>
<div class="row">
    <div class="col-md-6">
        <form method='post' action="{{route('admin.transfers.uploadFile')}}" enctype='multipart/form-data'>
            {{ csrf_field() }}
            <div class="mb-3">
                <label for="formFile" class="form-label">Import products to transfers by .csv file</label>
                <input type='file' name='file'>
                <input type='submit' name='submit' value='Import'>
            </div>
        </form>
    </div>
    <div class="col-md-6">
        <a href="{{route('admin.transfers.complete_transfers')}}" type="button" class="btn btn-default" style="margin-Top: 20px">Đơn đã hoàn thành</a>
    </div>

</div>
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
                <a href="{{route('admin.transfers.detail',$transfer->id)}}" type="button" class="btn btn-primary"><i class="fas fa-info"></i></a>
                <a href="{{route('admin.transfers.edit_transfer',$transfer->id)}}" type="button" class="btn btn-success"><i class="fas fa-edit"></i></a>
                <button type="button" class="delete btn btn-danger" data={{$transfer->id}}><i class="fas fa-trash"></i></button>
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
            <form action="{{route('admin.transfers.delete_transfer')}}" method="post">
                @csrf
                @method('DELETE')
                <input type="hidden" name="id" id="id" value="0">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete transfer !</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you want to delete this transfer?
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
