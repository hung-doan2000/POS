<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>RHUST SHOP</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('template/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('template/dist/css/adminlte.min.css')}}">
</head>
<body>
<div class="wrapper">
  <!-- Main content -->
  <section class="invoice">
    <!-- title row -->
    <div class="row">
      <div class="col-12">
        <h2 class="page-header">
          <i class="fas fa-globe"></i>RHUST, Inc.
          <small class="float-right" >Date: <p>
          <script> document.write(new Date().toLocaleDateString()); </script>
          </p>
          </small>
        </h2>
      </div>
      <!-- /.col -->
    </div>


    <!-- Table row -->
    <div class="row">
      <div class="col-12 table-responsive">
        <table class="table table-striped ">
          <thead>
          <tr>
            <th  >Product</th>
            <th  >Qty</th>
            <th  >Price</th>
            <th  >Total</th>
          </tr>
          </thead>
          <tbody>
          @php $total = 0 @endphp
          @if(session('cart'))
          @foreach(session('cart') as $id => $details)
          @php $total += $details['price'] * $details['quantity'] @endphp
          <tr>
            <td>{{ $details['name'] }}</td>
            <td >{{ $details['quantity'] }}</td>
            <td>{{ $details['price'] }}</td>
            <td>${{ $details['price'] * $details['quantity'] }}</td>
          </tr>
          @endforeach
          @endif
          
          </tbody>
        </table>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="row">
      <!-- accepted payments column -->
      <div class="col-6">
        <p class="lead">Payment Methods:</p>
        <img src="{{asset('template/dist/img/credit/visa.png')}}" alt="Visa">
        <img src="{{asset('template/dist/img/credit/mastercard.png')}}" alt="Mastercard">
        <img src="{{asset('template/dist/img/credit/american-express.png')}}" alt="American Express">
        <img src="{{asset('template/dist/img/credit/paypal2.png')}}" alt="Paypal">
      </div>
      <!-- /.col -->
      <div class="col-6">
        <div class="table-responsive">
          <table class="table">

            <tr>
              <th>Discount (0%)</th>
              <td>$0</td>
            </tr>
            <tr>
              <th>Total:</th>
              <td>${{$total}}</td>
            </tr>
          </table>
        </div>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
<!-- Page specific script -->
<script>
  window.addEventListener("load", window.print());
</script>
</body>
</html>
