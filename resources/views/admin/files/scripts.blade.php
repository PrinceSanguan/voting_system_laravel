    <script src="{{asset('assets/js/pace.js')}}"></script>
    <script src="{{asset('assets/js/jquery-3.3.1.min.js')}}"></script>
    <script src="{{asset('assets/libs/popper/popper.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap.js')}}"></script>
    <script src="{{asset('assets/js/sidenav.js')}}"></script>
    <script src="{{asset('assets/js/layout-helpers.js')}}"></script>
    <script src="{{asset('assets/js/material-ripple.js')}}"></script>

    <!-- Libs -->
    <script src="{{asset('assets/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>

    <!-- Demo -->
    <script src="{{asset('assets/js/demo.js')}}"></script>
    <!-- <script src="{{asset('assets/js/analytics.js')}}"></script> -->
    <script>
        const ip  = `{{ session()->get('ip') }}`;
        console.log(ip)
    </script>