@extends('admin.layouts.app')
@section('alert')
@include('admin.alert')
@stop
@section('content')
<form id="form">
    @csrf
    <div class="card-body">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="menu">Purchase ID</label>
                    <input type="text" value="{{$purchase_id}}" class="form-control" disabled>
                    <input type="hidden" name="purchase_id" value="{{$purchase_id}}" class="form-control">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="menu">Product ID</label>
                    <input type="text" name="product_id" value="{{old('product_id')}}" class="form-control" placeholder="Nhập mã sản phẩm">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="menu">Số lượng</label>
                    <input type="text" id="qua" name="quantity" value="{{old('quantity')}}" class="form-control" placeholder="Nhập số lượng">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="menu">Giá</label>
                    <input type="text" name="money" value="{{old('money')}}" class="form-control" placeholder="Nhập giá trị đơn hàng">
                </div>
            </div>
            <p id="error"></p>
            <button type="button" id="add_product" class="btn btn-primary">Lưu</button>
        </div>

    </div>
</form>
<table>
    <thead>
        <tr>
            <td>Purchase ID</td>
            <td>Product</td>
            <td>Số lượng</td>
            <td>Giá trị sản phẩm</td>
            <td></td>
        </tr>
    </thead>
    <tbody id="body">
        @foreach($products as $product)
        <tr name="{{$product->id}}">
            <td>{{$product->purchase_id}}</td>
            <td>{{$product->product_id}}</td>
            <td>{{$product->quantity}}</td>
            <td>{{$product->money}}</td>
            <td><a href="{{ route('admin.purchases.edit_product',['purchase_id'=>$product->purchase_id,'product_id'=>$product->product_id])}}" type="button" class="btn btn-success"><i class="fas fa-edit"></i></a>
                <button type="button" class="delete btn btn-danger" data="{{$product->id}}"><i class="fas fa-trash"></i></button>
            </td>
        </tr>
        @endforeach
    </tbody>
    <div class="card-footer clearfix">
        {{ $products->links() }}
    </div>
    <p id="test"></p>
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

        $('#submit_delete').click(function() {
            let id = $('#id').val();
            $.ajax({
                url: "{{ route('admin.purchases.delete_product') }}",
                type: "POST",
                data: {
                    "_token": "{{csrf_token()}}",
                    id: id,
                },
                success: function(rows) {
                    if (rows != "error") {
                        let str = "[name=" + rows + "]";
                        alert('Sản phẩm đã xóa thành công')
                        $(str).remove();
                        $('#deleteModal').modal('toggle');
                    } else {
                        $('#deleteModal').modal('toggle');
                        alert('Sản phẩm không tồn tại')
                    }
                }
            });
        })

        $('#add_product').click(function() {
            $.ajax({
                url: "{{ route('admin.purchases.add_product') }}",
                type: "POST",
                data: {
                    "_token": "{{csrf_token()}}",
                    product_id: $("[name='product_id']").val(),
                    quantity: $("[name='quantity']").val(),
                    money: $("[name='money']").val(),
                    purchase_id: $("[name='purchase_id']").val(),
                },
                success: function(row) {
                    let url = window.location.href;
                    let k = url.indexOf("page=");
                    if (k > 0) {
                        url = url.substring(0, k - 1);
                    }
                    url = url + "/" + $("[name='product_id']").val();
                    if (row == 'error') alert("Thêm sản phẩm không thành công do nhập thiếu dữ liệu hoặc sai định dạng")
                    else if (row == 'exist') {
                        alert("Sản phẩm đã tồn tại")
                    } else {
                        $('#body').prepend(row);
                        let para = "['purchase_id'=>" + $("[name='purchase_id']").val() + ",'product_id'=>" + $("[name='product_id']").val() + "]";
                        $('#edit').click(function() {
                            window.location = url
                        })
                        $('.delete').click(function() {
                            $('#id').val($(this).attr('data'))
                            $('#deleteModal').modal({
                                keyboard: false
                            })
                            $('#deleteModal').modal('show');
                        });
                        $('#form')[0].reset();
                    };
                }
            });

        })

    });
</script>
@stop
@section('modal')
<!-- Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form>
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
