 <!-- jquery vendor -->
    <script src=" {{ asset('asset/js/lib/jquery.min.js') }}"></script>
    <script src=" {{ asset('asset/js/lib/jquery.nanoscroller.min.js') }}"></script>
    <!-- nano scroller -->
    <script src=" {{ asset('asset/js/lib/menubar/sidebar.js') }}"></script>
    <script src=" {{ asset('asset/js/lib/preloader/pace.min.js') }}"></script>
    <!-- sidebar -->

    <script src=" {{ asset('asset/js/lib/bootstrap.min.js') }}"></script>
    <script src=" {{ asset('asset/js/scripts.js') }}"></script>
    <!-- bootstrap -->

    <script src=" {{ asset('asset/js/lib/calendar-2/moment.latest.min.js') }}"></script>
    <!-- <script src=" {{ asset('asset/js/lib/calendar-2/pignose.calendar.min.js') }}"></script> -->
    <!-- <script src=" {{ asset('asset/js/lib/calendar-2/pignose.init.js') }}"></script> -->

    <script src="{{ asset('asset/plugins/summernote/summernote-bs4.min.js')}}"></script>
    <!-- <script src=" {{ asset('asset/js/lib/weather/jquery.simpleWeather.min.js') }}"></script> -->
    <!-- <script src=" {{ asset('asset/js/lib/weather/weather-init.js') }}"></script> -->
    <script src=" {{ asset('asset/js/lib/circle-progress/circle-progress.min.js') }}"></script>
    <script src=" {{ asset('asset/js/lib/circle-progress/circle-progress-init.js') }}"></script>
    <!-- <script src=" {{ asset('asset/js/lib/chartist/chartist.min.js') }}"></script> -->
    <!-- <script src=" {{ asset('asset/js/lib/sparklinechart/jquery.sparkline.min.js') }}"></script> -->
    <!-- <script src=" {{ asset('asset/js/lib/sparklinechart/sparkline.init.js') }}"></script> -->
    <script src=" {{ asset('asset/js/lib/owl-carousel/owl.carousel.min.js') }}"></script>
    <script src=" {{ asset('asset/js/lib/owl-carousel/owl.carousel-init.js') }}"></script>
    <!-- scripit init-->
    <!-- <script src="{{ asset('asset/js/dashboard2.js') }}"></script> -->
    <!-- scripit init-->
    <script src="{{ asset('asset/js/lib/data-table/datatables.min.js') }}"></script>
    <script src="{{ asset('asset/js/lib/data-table/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('asset/js/lib/data-table/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('asset/js/lib/data-table/jszip.min.js') }}"></script>
    <script src="{{ asset('asset/js/lib/data-table/pdfmake.min.js') }}"></script>
    <script src="{{ asset('asset/js/lib/data-table/vfs_fonts.js') }}"></script>
    <script src="{{ asset('asset/js/lib/data-table/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('asset/js/lib/data-table/buttons.print.min.js') }}"></script>
    <script src="{{ asset('asset/js/lib/data-table/datatables-init.js') }}"></script>
    <script src="{{ asset('asset/plugins/summernote/summernote-bs4.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <!-- <script src=" {{ asset('asset/js/lib/sweetalert/sweetalert.init.js') }}"></script> -->
    <script src=" {{ asset('asset/js/lib/sweetalert/sweetalert.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    <script>
        $(document).ready(function()
        {
            $(".select2").select2();
        });

        function redirecturl_fun(link)
        {
            var url="{{ url('/') }}"+link;
            window.location.href=url;
        }
    </script>
