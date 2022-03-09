@extends('admin.layouts.app')
@section('alert')
@include('admin.alert')
@stop
@section('content')
<form id="form" action="{{route('admin.transfers.add_product')}}" method="post">
    @csrf
    <div class="card-body">
        <div class="row">
            <div class="col-md-5">
                <div class="form-group">
                    <label for="menu">Product Id</label>
                    <input type="hidden" name="transfer_id" value="{{$transfer_id}}">
                    <input type="text" name="product_id" value="{{old('product_id')}}" class="form-control">
                </div>
            </div>
            <div class="col-md-5">
                <div class="form-group">
                    <label for="menu">Quantity</label>
                    <input type="text" name="quantity" value="{{old('quantity')}}" class="form-control">
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Lưu</button>
    </div>
</form>

<table>
    <thead>
        <tr>
            <td>Product ID</td>
            <td>Quantity</td>
            <td></td>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $product)
        <tr>
            <td>{{$product->product_id}}</td>
            <td>{{$product->quantity}}</td>
            <td>
                <button type="button" class="delete btn btn-danger" data={{$product->id}}><i class="fas fa-trash"></i></button>
            </td>
        </tr>
        @endforeach
    </tbody>
    <div class="card-footer clearfix">
        {!! $products->links() !!}
    </div>
</table>
@stop
@section('js')
<script type="text/javascript">
    $(document).ready(function() {
        $('.delete').click(function() {
            $('#id').val($(this).attr('data'))
            console.log($('#product_id').val())
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
            <form action="{{route('admin.transfers.delete_product')}}" method="post">
                @csrf
                @method('DELETE')
                <input type="hidden" name="id" id="id" value="0">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete product !</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you want to delete this product?
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

