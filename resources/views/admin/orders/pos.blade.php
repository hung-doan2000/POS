<!DOCTYPE HTML>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="author" content="Bootstrap-ecommerce by Vosidiy">
	<title>RHUST POS</title>
	<link rel="shortcut icon" type="image/x-icon" href="{{ asset('template/web/images/favicon.png')}}">
	<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('template/web/images/favicon.png')}}">
	<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('template/web/images/favicon.png')}}">
	<!-- jQuery -->
	<!-- Bootstrap4 files-->
	<link href="{{ asset('assets/css/bootstrap.css')}}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('assets/css/ui.css')}}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('assets/fonts/fontawesome/css/fontawesome-all.min.css')}}" type="text/css" rel="stylesheet">
	<link href="{{ asset('assets/css/OverlayScrollbars.css')}}" type="text/css" rel="stylesheet" />

	<!-- Font awesome 5 -->
	<style>
		.avatar {
			vertical-align: middle;
			width: 35px;
			height: 35px;
			border-radius: 50%;
		}

		.bg-default,
		.btn-default {
			background-color: #f2f3f8;
		}

		.btn-error {
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
								<a href="{{route('admin.logout')}}" class="btn btn-primary m-btn m-btn--icon m-btn--icon-only">
									<i class="fa fa-sign-out-alt"></i> Logout</a>
							</a>
							</a>
						</div> <!-- widget  dropdown.// -->
					</div> <!-- widgets-wrap.// -->
				</div> <!-- col.// -->
			</div> <!-- row.// -->
			<!-- container.// -->
	</section>
	<!-- ========================= SECTION CONTENT ========================= -->
	<section class="section-content padding-y-sm bg-default ">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-8 card padding-y-sm card ">
					<span id="items">
						<div class="row">
							@foreach($stocks as $stock)
							<div class="col-md-3">
								<figure class="card card-product">
									<span class="badge-new"> NEW </span>
									<div class="img-wrap">
										<img src="{{asset('assets/images/items/3.jpg')}}">
									</div>
									<figcaption class="info-wrap">
										<a href="#" class="title">{{$stock->name}}</a>
										<div class="action-wrap">
											<a href="{{ route('admin.orders.add-to-cart', $stock->id) }}" class="btn btn-primary btn-sm float-right"> <i class="fa fa-cart-plus"></i> Add </a>
											<div class="price-wrap h5">
												<span class="price-new">{{$stock->price}}</span>
											</div> <!-- price-wrap.// -->
										</div> <!-- action-wrap -->
									</figcaption>
								</figure> <!-- card // -->
							</div> <!-- col // -->
							@endforeach
						</div> <!-- row.// -->
					</span>
				</div>
				<div class="col-md-4">
                    <div class="card">
                        <h5 class="text-center">Customer</h5>
                        <table class="table table-hover shopping-cart-wrap">
                            <thead class="text-muted">
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Phone</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <input name="name" class="form-control">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input name="phone" class="form-control">
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
					<div class="card">
						<span id="cart">
							<table class="table table-hover shopping-cart-wrap">
								<thead class="text-muted">
									<tr>
										<th scope="col">Item</th>
										<th scope="col" width="200">Qty</th>
										<th scope="col" width="120">Price</th>
										<th scope="col" width="100">Total</th>
										<th scope="col" class="text-right" width="200">Delete</th>
									</tr>
								</thead>
								<tbody>
									@php $total = 0 @endphp
									@if(session('cart'))
									@foreach(session('cart') as $id => $details)
									@php $total += $details['price'] * $details['quantity'] @endphp
									<tr data-id="{{ $id }}">
										<td data-th="Product">
											<figure class="media">
												<figcaption class="media-body">
													<h6 class="title text-truncate text-center">{{ $details['name'] }} </h6>
												</figcaption>
											</figure>
										</td>
										<td class="text-center" data-th="Quantity">
											<div class="form-group">
												<input type="number" value="{{$details['quantity']}}" class="form-control quantity update-cart">
											</div>
										</td>
										<td data-th="Price">
											<div class="price-wrap">
												<var class="price">${{ $details['price'] }}</var>
											</div> <!-- price-wrap .// -->
										</td>
										<td>
											<div class="price-wrap">
												<var class="price">${{ $details['price'] * $details['quantity'] }}</var>
											</div> <!-- price-wrap .// -->
										</td>
										<td class="text-right actions" data-th="">
											<button class="btn btn-sm btn-outline-danger remove"> <i class="fa fa-trash"></i></button>
										</td>
									</tr>
									@endforeach
									@endif

								</tbody>
							</table>
						</span>
					</div> <!-- card.// -->
					<div class="box">
						<dl class="dlist-align">
							<dt>Discount:</dt>
							<dd class="text-right"><a href="#">0%</a></dd>
						</dl>
						<dl class="dlist-align">
							<dt>Total: </dt>
							<dd class="text-right h4 b"> ${{ $total }} </dd>
						</dl>
						<div class="row">
							<div class="col-md-6">
								<a href="{{ route('admin.orders.cancel') }}" class="btn  btn-default btn-error btn-lg btn-block "><i class="fa fa-times-circle "></i> Cancel </a>
							</div>
							<div class="col-md-6">
								<a href="{{ route('admin.orders.charge') }}" class="btn  btn-primary btn-lg btn-block"><i class="fa fa-shopping-bag"></i> Charge </a>
							</div>
						</div>
					</div> <!-- box.// -->
				</div>
			</div>
		</div><!-- container //  -->
	</section>

	<!-- ========================= SECTION CONTENT END// ========================= -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<script type="text/javascript">
		$(".update-cart").change(function(e) {
			e.preventDefault();

			var ele = $(this);

			$.ajax({
				url: '{{ route('admin.orders.update-cart') }}',
				method: "patch",
				data: {
					_token: '{{ csrf_token() }}',
					id: ele.parents("tr").attr("data-id"),
					quantity: ele.parents("tr").find(".quantity").val()
				},
				success: function(response) {
					window.location.reload();
				}
			});
		});

		$(".remove").click(function(e) {
			e.preventDefault();
			var ele = $(this);
			if (confirm("Are you sure want to remove?")) {
				$.ajax({
					url: '{{ route('admin.orders.remove-from-cart')}}',
					method: "DELETE",
					data: {
						_token: '{{ csrf_token() }}',
						id: ele.parents("tr").attr("data-id")
					},
					success: function(response) {
						window.location.reload();
					}
				});
			}
		});
	</script>
	<script src="{{asset('assets/js/jquery-2.0.0.min.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/js/bootstrap.bundle.min.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/js/OverlayScrollbars.js')}}" type="text/javascript"></script>

	<script>
		$(function() {
			//The passed argument has to be at least a empty object or a object with your desired options
			//$("body").overlayScrollbars({ });
			$("#items").height(552);
			$("#items").overlayScrollbars({
				overflowBehavior: {
					x: "hidden",
					y: "scroll"
				}
			});
			$("#cart").height(445);
			$("#cart").overlayScrollbars({});
		});
	</script>


</body>

</html>
