<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.partials.head')
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">

            </ul>
            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <div class="dropdown" style="margin-right:6px">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="{{ route('admin.users.edit') }}">Chỉnh sửa thông tin</a>
                        <a class="dropdown-item" href="{{ route('admin.users.index') }}">Đổi mật khẩu</a>
                        <a class="dropdown-item" href="{{ route('admin.logout') }}">Đăng xuất</a>
                    </div>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        @include('admin.partials.sidebar')

        <div class="content-wrapper">

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    @include('admin.alert')
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-12">
                            <!-- jquery validation -->
                            <div class="card card-primary mt-3">
                                <div class="card-header">
                                    <h3 class="card-title">Doanh thu 12 tháng qua</h3>
                                </div>
                                <div>
                                    <canvas id="myChart1"></canvas>
                                </div>

                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="card card-primary mt-3">
                                <div class="card-header">
                                    <h3 class="card-title">5 sản phẩm bán chạy nhất tháng
                                        <select class="form-select" aria-label="Default select example" id="select_month">
                                            @foreach ($select_months as $month)
                                            <option value={{$month}}> {{$month }}</option>
                                            @endforeach
                                        </select>
                                    </h3>
                                </div>
                                <div id="5products_monthly">

                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card card-primary mt-3">
                                <div class="card-header">
                                    <h3 class="card-title">5 sản phẩm bán chạy nhất năm
                                        <select class="form-select" aria-label="Default select example" id="select_year">
                                            @foreach ($select_years as $i)
                                            <option value={{$i}}> {{$i }}</option>
                                            @endforeach
                                        </select>
                                    </h3>
                                </div>
                                <div id="5products_yearly">

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.row -->
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> 3.1.0
            </div>

        </footer>

    </div>
    <!-- ./wrapper -->
    @include('admin.partials.footer')

    <script>
        //Doanh thu 12 tháng qua
        $(document).ready(function() {
            $.ajax({
                url: "{{ route('admin.chart_month') }}",
                type: "POST",
                data: {
                    "_token": "{{csrf_token()}}",
                    month: <?php echo $current_month ?>,
                },
                success: function(bar_graph) {
                    $('#5products_monthly').html(bar_graph);
                    $('#graph').chart = new Chart($("#graph"), $('#graph').data("settings"));
                }
            });

            $('#select_month').change(function() {
                var month = $(this).val();
                $.ajax({
                    url: "{{ route('admin.chart_month') }}",
                    type: "POST",
                    data: {
                        "_token": "{{csrf_token()}}",
                        month: month,
                    },
                    success: function(bar_graph) {
                        $('#5products_monthly').html(bar_graph);
                        $("#graph").chart = new Chart($("#graph"), $("#graph").data("settings"));

                    }
                });
            })

            $.ajax({
                url: "{{ route('admin.chart_year') }}",
                type: "POST",
                data: {
                    "_token": "{{csrf_token()}}",
                    year: <?php echo $year ?>,
                },
                success: function(bar_graph) {
                    $('#5products_yearly').html(bar_graph);
                    $('#graph2').chart = new Chart($("#graph2"), $('#graph2').data("settings"));
                }
            });

            $('#select_year').change(function() {
                var year = $(this).val();
                $.ajax({
                    url: "{{ route('admin.chart_year') }}",
                    type: "POST",
                    data: {
                        "_token": "{{csrf_token()}}",
                        year: year,
                    },
                    success: function(bar_graph2) {
                        $('#5products_yearly').html(bar_graph2);
                        $("#graph2").chart = new Chart($("#graph2"), $("#graph2").data("settings"));

                    }
                });
            })

            const labels1 = new Array();
            <?php foreach ($sales as $sale) {
                $month = $sale->month . '/' . $sale->year; ?>
                labels1.unshift('<?php echo $month; ?>');
            <?php } ?>

            const money = new Array();
            <?php foreach ($sales as $sale) { ?>
                money.unshift('<?php echo $sale->totalmoney; ?>');
            <?php } ?>;
            const data1 = {
                labels: labels1,
                datasets: [{
                    label: 'Doanh thu 12 tháng vừa qua',
                    backgroundColor: 'rgb(255, 99, 132)',
                    borderColor: 'rgb(255, 99, 132)',
                    data: money,
                }]
            };
            const config = {
                type: 'line',
                data: data1,
                options: {}
            };
            var myChart1 = new Chart(
                document.getElementById('myChart1'),
                config
            );


        })
    </script>

</body>

</html>