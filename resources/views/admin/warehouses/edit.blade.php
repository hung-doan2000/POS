@extends('admin.layouts.app')
@section('alert')
    @include('admin.alert')
@stop
@section('search')
    <!-- <div class="container-fluid">
        <div class="row">
            <div class="col offset">
                <form action="{{ route('admin.warehouses.search') }}" method="GET">
                    <div class="input-group">
                        <input type="search" class="form-control form-control-lg" name="query" id="query" value="{{ old('name') }}" placeholder="Tìm kiếm">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-lg btn-default" href="{{ route('admin.warehouses.search') }}">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
    $(document).ready(function(){

    $('#query').keyup(function(){ //bắt sự kiện keyup khi người dùng gõ từ khóa tim kiếm
    var query = $(this).val(); //lấy gía trị ng dùng gõ
    if(query != '') //kiểm tra khác rỗng thì thực hiện đoạn lệnh bên dưới
    {
        var _token = $('input[name="_token"]').val(); // token để mã hóa dữ liệu
        $.ajax({
        url:"{{ route('admin.warehouses.search') }}", // đường dẫn khi gửi dữ liệu đi 'search' là tên route mình đặt bạn mở route lên xem là hiểu nó là cái j.
        method:"POST", // phương thức gửi dữ liệu.
        data:{query:query, _token:_token},
        success:function(data){ //dữ liệu nhận về
        $('#queryList').fadeIn();
        $('#queryList').html(data); //nhận dữ liệu dạng html và gán vào cặp thẻ có id là countryList
                }
            });
        }
    });

    $(document).on('click', 'li', function(){
        $('#query').val($(this).text());
        $('queryList').fadeOut();
    });
});
</script> -->
@stop
@section('content')
    <table id="example3" class="display nowrap" cellspacing="0" width="100%">
        <thead>
            <tr style="font-weight:600">
                <td>Tên sản phẩm</td>
                <td>Giá nhập</td>
                <td>Giá bán</td>
                <td>Số lượng</td>
            </tr>
        </thead>
        <tbody>
        @forelse($stocks as $stock)
            <tr>
                <td> {{$stock->name}}</td>
                <td> {{$stock->import_price}}</td>
                <td> {{$stock->price}}</td>
                <td> {{$stock->quantity}}</td>
            </tr>
        @empty
            <tr>
                <td colspan="5"><p>No product</p></td>
            </tr>
        @endforelse
        </tbody>
    </table>
@stop
@section('js')
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.2/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
        $('#example3').DataTable( {
            "info": true,
        } );
    } );
    </script>
@stop
