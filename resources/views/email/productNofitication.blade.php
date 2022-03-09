<h1>Out of stock Nofitication Email</h1>
<h3>Sản phẩm còn dưới 10</h3>
<table id="example3" class="display nowrap" cellspacing="0" width="100%">
        <thead>
            <tr style="font-weight:600">
                <td>Tên sản phẩm</td>
                <td>Cửa hàng</td>
                <td>Số lượng</td>
            </tr>
        </thead>
        <tbody>
        @forelse($warehouses as $stock)
            <tr>
                <td> {{$stock->product->name}}</td>
                <td> {{$stock->store->name}}</td>
                <td> {{$stock->quantity}}</td>
            </tr>
        @empty
            <tr>
                <td colspan="5"><p>No product</p></td>
            </tr>
        @endforelse
        </tbody>
    </table>
