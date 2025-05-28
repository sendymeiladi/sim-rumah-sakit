<footer class="content-footer footer bg-footer-theme">
    <div class="container-xxl">
        <div
            class="footer-container d-flex align-items-center justify-content-between py-3 flex-md-row flex-column">
            <div class="mb-2 mb-md-0">
                ©
                <script>
                    document.write(new Date().getFullYear());
                </script>
                , SIM-RS by
                <a href="https://pixinvent.com" target="_blank"
                   class="footer-link fw-medium">Sendy Meiladi</a>
            </div>
        </div>
    </div>
</footer>
<!-- / Footer -->

<div class="content-backdrop fade"></div>
</div>
<!-- Content wrapper -->
</div>
<!-- / Layout page -->
</div>

<!-- Overlay -->
<div class="layout-overlay layout-menu-toggle"></div>

<!-- Drag Target Area To SlideIn Menu On Small Screens -->
<div class="drag-target"></div>
</div>
<!-- / Layout wrapper -->

<!-- Core JS -->
<!-- build:js assets/vendor/js/core.js')}} -->
<script src="{{asset('/assets/vendor/libs/jquery/jquery.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/printThis/1.15.0/printThis.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="{{asset('/assets/vendor/libs/popper/popper.js')}}"></script>
<script src="{{asset('/assets/vendor/js/bootstrap.js')}}"></script>
<script src="{{asset('/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>
<script src="{{asset('/assets/vendor/libs/node-waves/node-waves.js')}}"></script>

<script src="{{asset('/assets/vendor/libs/hammer/hammer.js')}}"></script>
<script src="{{asset('/assets/vendor/libs/i18n/i18n.js')}}"></script>
<script src="{{asset('/assets/vendor/libs/typeahead-js/typeahead.js')}}"></script>

<script src="{{asset('/assets/vendor/js/menu.js')}}"></script>
<!-- endbuild -->

<!-- Vendors JS -->
<script src="{{asset('/assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>
<script src="{{asset('/assets/vendor/libs/swiper/swiper.js')}}"></script>
<script src="{{asset('/assets/vendor/libs/toastr/toastr.js')}}"></script>
<script src="{{asset('/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
<script src="{{asset('/assets/vendor/libs/sweetalert2/sweetalert2.js')}}"></script>

<script src="{{asset('/assets/vendor/libs/toastr/toastr.js')}}"></script>
<script src="{{asset('/assets/vendor/libs/select2/select2.js')}}"></script>

<script src="{{asset('/assets/vendor/libs/jquery-repeater/jquery-repeater.js')}}"></script>

<script src="{{asset('/assets/vendor/libs/sweetalert2/sweetalert2.js')}}"></script>
<script src="{{asset('/assets/vendor/libs/flatpickr/flatpickr.js')}}"></script>
<script src="{{asset('/assets/vendor/libs/moment/moment.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<!-- Main JS -->
<script src="{{asset('/assets/js/main.js')}}"></script>

<!-- Page JS -->
<script src="{{asset('/assets/js/dashboards-analytics.js')}}"></script>

<script>
    const BASE_URL = `{{url('/')}}`
</script>

@stack("my-scripts")

</body>
</html>
