<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin</title>
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
  <link href="{{ mix('css/admin.css') }}" type="text/css" rel="stylesheet" />
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" type="text/css" rel="stylesheet" />
  <link rel="shortcut icon" type="image/x-icon" href="assets/images/logos/squanchy.jpg">
  <link rel="apple-touch-icon" sizes="180x180" href="assets/images/logos/squanchy.jpg">
  <link rel="icon" type="image/png" sizes="32x32" href="assets/images/logos/squanchy.jpg">
  <!-- jQuery -->
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Bootstrap4 files-->
  <link href="/assets/css/bootstrap.css" rel="stylesheet" type="text/css" />
  <link href="/assets/css/ui.css" rel="stylesheet" type="text/css" />
  <link href="/assets/fonts/fontawesome/css/fontawesome-all.min.css" type="text/css" rel="stylesheet">
  <link href="/assets/css/OverlayScrollbars.css" type="text/css" rel="stylesheet" />
  <link rel="stylesheet" href="/template/plugins/fontawesome-free/css/all.min.css">
  <!-- daterange picker -->
  <link rel="stylesheet" href="/template/plugins/daterangepicker/daterangepicker.css">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="/template/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="/template/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="/template/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="/template/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="/template/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- Bootstrap4 Duallistbox -->
  <link rel="stylesheet" href="/template/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
  <!-- BS Stepper -->
  <link rel="stylesheet" href="/template/plugins/bs-stepper/css/bs-stepper.min.css">
  <!-- dropzonejs -->
  <link rel="stylesheet" href="/template/plugins/dropzone/min/dropzone.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/template/dist/css/adminlte.min.css">

 

  <meta name="csrf-token" value="{{ csrf_token() }}" />
  @if (Auth::check())
  <meta name="user_id" content="{{ Auth::user() }}" />
  @endif
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div id="admin">
    <example-component></example-component>
  </div>
  <script src="{{ mix('js/admin.js') }}" type="text/javascript"></script>

  <script src="/template/plugins/jquery/jquery.min.js"></script>

  <script src="/template/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <!-- jQuery Knob Chart -->
  <script src="/template/plugins/jquery-knob/jquery.knob.min.js"></script>
  <!-- daterangepicker -->
  <script src="/template/plugins/moment/moment.min.js"></script>
  <script src="/template/plugins/daterangepicker/daterangepicker.js"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="/template/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
  <!-- Summernote -->
  <script src="/template/plugins/summernote/summernote-bs4.min.js"></script>
  <!-- SweetAlert2 -->
  <script src="/template/plugins/sweetalert2/sweetalert2.min.js"></script>
  <!-- Toastr -->
  <script src="/template/plugins/toastr/toastr.min.js"></script>
  <!-- overlayScrollbars -->
  <script src="/template/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <script src="/template/plugins/daterangepicker/daterangepicker.js"></script>



  <!-- overlayScrollbars -->



  <!-- AdminLTE App -->
  <script src="/template/dist/js/adminlte.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="/template/dist/js/demo.js"></script>
  <script src="/template/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>

</html>