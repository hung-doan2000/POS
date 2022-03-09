<!-- jQuery -->
<script src="/template/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
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
<!-- overlayScrollbars -->
<!-- SweetAlert2 -->
<script src="/template/plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="/template/plugins/toastr/toastr.min.js"></script>
<!-- AdminLTE App -->
<script src="/template/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="/template/dist/js/demo.js"></script>

<script src="/template/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>

<script>
    $(function() {
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });
    });
</script>


@yield('js')
@yield('modal')

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
{{--Upload File--}}
<script>
    $('#upload').change(function (){
        const form = new FormData();
        form.append('file',$(this)[0].files[0]);
        $.ajax({
            contentType:false,
            processData: false,
            type:'POST',
            dataType:'JSON',
            data:form,
            url: '/admin/upload',
            success:function (results){
                if (results.error===false){
                    $('#image_show').html('<a href="' + results.url +'"target="_blank">'+
                        '<img class = "img-thumbnail" src="'+results.url+'" width="200px"></a>');
                    $('#photo').val(results.url);
                }else{
                    alert('Upload file lỗi');
                }
            }
        })
    })
</script>

