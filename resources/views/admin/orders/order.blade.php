<!DOCTYPE HTML>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="author" content="Bootstrap-ecommerce by Vosidiy">
<title>RHUST POS</title>
<link rel="shortcut icon" type="image/x-icon" href="{{ asset('template/web/images/favicon.png')}}" >
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('template/web/images/favicon.png')}}">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('template/web/images/favicon.png')}}">
<!-- jQuery -->
<!-- Bootstrap4 files-->
<link href="{{ asset('assets/css/bootstrap.css')}}" rel="stylesheet" type="text/css"/> 
<link href="{{ asset('assets/css/ui.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('assets/fonts/fontawesome/css/fontawesome-all.min.css')}}" type="text/css" rel="stylesheet">
<link href="{{ asset('assets/css/OverlayScrollbars.css')}}" type="text/css" rel="stylesheet"/>

<!-- Font awesome 5 -->
<style>
	.avatar {
  vertical-align: middle;
  width: 35px;
  height: 35px;
  border-radius: 50%;
}
.bg-default, .btn-default{
	background-color: #f2f3f8;
}
.btn-error{
	color: #ef5f5f;
}
</style>
<!-- custom style -->
</head>
<body>
<section class="header-main">
	<div class="container">
<div class="row align-items-center">
	<div class="col-lg-3">
	<div class="brand-wrap">
		<img class="logo" src="{{ asset('template/web/images/favicon.png')}}">
		<h2 class="logo-text">RHUST POS</h2>
	</div> <!-- brand-wrap.// -->
	</div>
	<div class="col-lg-6 col-sm-6">
		<form action="#" class="search-wrap">
			<div class="input-group">
			    <input type="text" class="form-control" placeholder="Search">
			    <div class="input-group-append">
			      <button class="btn btn-primary" type="submit">
			        <i class="fa fa-search"></i>
			      </button>
			    </div>
		    </div>
		</form> <!-- search-wrap .end// -->
	</div> <!-- col.// -->
	<div class="col-lg-3 col-sm-6">
		<div class="widgets-wrap d-flex justify-content-end">
			<div class="widget-header">
				<a href="#" class="icontext">
					<a href="{{route('admin.dashboard')}}" class="btn btn-primary m-btn m-btn--icon m-btn--icon-only">
															<i class="fa fa-home"></i>
														</a>
				</a>
			</div> <!-- widget .// -->
			<div class="widget-header dropdown">
				<a href="#" class="ml-3 icontext" data-toggle="dropdown" data-offset="20,10">
				@if (Auth::user()->photo)
                    <img class="avatar" src="{{ asset(Auth::user()->photo) }}" alt="">
                @else<img src="/template/dist/img/user2-160x160.jpg" class="avatar" alt="">
                @endif
				</a>	
				<div class="dropdown-menu dropdown-menu-right">
						<a class="dropdown-item" href="#"><i class="fa fa-sign-out-alt"></i> Logout</a>
				</div> <!--  dropdown-menu .// -->
			</div>
			<div class="widget-header">
				<a href="#" class="icontext">
					<a href="{{route('admin.dashboard')}}" class="btn btn-primary m-btn m-btn--icon m-btn--icon-only">
					<i class="fa fa-sign-out-alt"></i> Logout</a>
														</a>
				</a>
			</div> <!-- widget  dropdown.// -->
		</div>	<!-- widgets-wrap.// -->	
	</div> <!-- col.// -->
</div> <!-- row.// -->
	 <!-- container.// -->
</section>


<section class="section-content padding-y-sm bg-default ">
<!-- row.// -->

<div class="col-md-8 center">
<table class="table table-hover shopping-cart-wrap">
<thead class="text-muted">
<tr>
  <th scope="col"  >Item</th>
  <th scope="col"  >Qty</th>
  <th scope="col"  >Price</th>
  <th scope="col" class="text-right"  >Total</th>
  
</tr>
</thead>
<tbody>
@php $total = 0 @endphp
@if(session('cart'))
        @foreach(session('cart') as $id => $details)
        @php $total += $details['price'] * $details['quantity'] @endphp
<tr data-id="{{ $id }}">
    <td data-th="Product">
    {{ $details['name'] }} 
	</td>
	<td > 		        
        {{$details['quantity']}}     
	</td>
	<td data-th="Price"> 
		<div class="price-wrap"> 
			<var class="price">${{ $details['price'] }}</var> 
		</div> <!-- price-wrap .// -->
	</td>
    <td class="text-right"> 
		<div class="price-wrap"  > 
			<var class="price">${{ $details['price'] * $details['quantity'] }}</var> 
		</div> <!-- price-wrap .// -->
	</td>
	
</tr>
@endforeach
@endif
</tbody>
</table>
 <!-- card.// -->
<div class="box">

<dl class="dlist-align">
  <dt>Discount:</dt>
  <dd class="text-right"><a href="#">0%</a></dd>
</dl>
<dl class="dlist-align">
  <dt>Total: </dt>
  <dd class="text-right h4 b"> ${{ $total }} </dd>
</dl>

<form action="{{ route('admin.orders.save') }}" method="get">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 ">
                    <div class="form-group ">
                    <label >Tên Khách hàng</label>
                    <input type="text" name="name"  class="form-control" placeholder="">
                    </div>
                </div>
                
                <div class="col-md-6 ">
                    <div class="form-group ">
                    <label >Số điện thoại</label>
                    <input type="text" name="phone"  class="form-control" placeholder="">
                    </div>               
                </div>
            </div>
        </div>
        <div class="center col-md-1">
            <button type="submit"class="btn  btn-primary btn-lg btn-block"><i class="fa fa-shopping-bag"></i>  </button>
        </div>       
        @csrf
</form>
<div class="col-12">
    <a href="{{route('admin.orders.print')}}" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                  
</div>
</div> 
</div><!-- box.// -->
	
<!-- container //  -->
</section>

<script src="{{asset('assets/js/jquery-2.0.0.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/js/bootstrap.bundle.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/js/OverlayScrollbars.js')}}" type="text/javascript"></script>

<script>
	$(function() {
	//The passed argument has to be at least a empty object or a object with your desired options
	//$("body").overlayScrollbars({ });
	$("#items").height(552);
	$("#items").overlayScrollbars({overflowBehavior : {
		x : "hidden",
		y : "scroll"
	} });
	$("#cart").height(445);
	$("#cart").overlayScrollbars({ });
});
</script>


</body>
</html>