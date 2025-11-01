
    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">

        <div class="copyright ">
            A Web Solution by <a href="https://jjahanzab.github.io/resume/index.html" target="blank"
                class="fw-bold">Jahanzab</a>.

        </div>

    </footer><!-- End Footer -->

    <!-- jQuery -->
    <script src="{{asset('backend_assets/plugins/jquery/jquery.min.js')}}"></script>
    <!-- jQuery UI 1.11.4 -->

    <script src="{{asset('backend_assets/plugins/jquery-ui/jquery-ui.min.js')}}"></script>

    <script src="{{asset('backend_assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
    <script src="{{asset('backend_assets/bootstrap/dist/js/bootstrap.min.js')}}"></script>
    <!-- Yajra datatable -->
    <script src="{{asset('backend_assets/YajraBox/datatable.bootstrap.min.js')}}"></script>
    <!-- icon picker JS -->
    <script src="{{asset('backend_assets/iconpicker/fontawesome-browser.js')}}"></script>
    <!-- icon picker JS End-->
    <!-- Toasts -->
    <script src="{{asset('backend_assets/Toasts/toasts.js')}}"></script>
    <!-- Toasts End -->
    <!-- Vendor JS Files -->
        <script src="{{asset('backend_assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

    <!--  Main JS File -->
    <script src="{{asset('backend_assets/js/main.js')}}"></script>
    <!-- Swiper js -->
    <script src="{{asset('backend_assets/Swiper/swiper.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <!-- Editor js End-->
    <script src="{{asset('backend_assets/Print/print.js')}}"></script>
 

    {{-- chrome://settings/content/sound --}}
  <audio loop id="beep" src="{{asset('backend_assets/audio/beep.wav')}}"  preload="auto" style="visibility:hidden;"></audio>

    <!-- Datatable End -->
    <script type="text/javascript">

        @if(Session()->has('msg'))
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
            Toast.fire({
                icon: "success",
                title: "{{session()->get('msg')}}",
                showCloseButton: true
            });
        @endif

    // Route Defines here
    const route                     = "{!! route('admin.order') !!}";
    const  view_order               =  "{!!route('admin.vieworder')!!}";
    const  cancel_order             =  "{!!route('admin.order.cancelorder')!!}";
    const  multi_checkbox           =  "{!!route('multicheckbox') !!}";
    const  order_print              =  "{!!route('orderprint')!!}";
    const  paid_order               =  "{!!route('admin.order.paidorder')!!}";
    const  order_remove_highlight   =  "{!!route('admin.order.remove-order-highlight')!!}";
    const  ordersoundbeep           = "{!!route('ordersoundbeep')!!}";
    const order_soundbeep_off       =      "{!!route('ordersoundbeepoff')!!}"
    </script>
    
    {{-- Custome order js --}}
    <script src="{{asset('backend_assets/custom-js/order.js')}}"></script>
</body>

</html>