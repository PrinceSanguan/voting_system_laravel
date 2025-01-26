<!DOCTYPE html>

<html lang="en" class="material-style layout-fixed">

@include('subadmin.files.head')
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css"> -->
<link rel="stylesheet" href="https://cdn.datatables.net/2.1.4/css/dataTables.bootstrap4.css">

<body>
    <!-- [ Preloader ] Start -->
    <div class="page-loader">
        <div class="bg-primary"></div>
    </div>
    <!-- [ Preloader ] Ebd -->

    <!-- [ Layout wrapper ] Start -->
    <div class="layout-wrapper layout-2">
        <div class="layout-inner">
            <!-- [ Layout sidenav ] Start -->
            @include('subadmin.files.sidebar')
            <!-- [ Layout sidenav ] End -->
            <!-- [ Layout container ] Start -->
            <div class="layout-container">
                <!-- [ Layout navbar ( Header ) ] Start -->
                @include('subadmin.files.navbar')
                <!-- [ Layout navbar ( Header ) ] End -->

                <!-- [ Layout content ] Start -->
                <div class="layout-content">

                    <!-- [ content ] Start -->
                    <div class="container-fluid flex-grow-1 container-p-y">
                        <h4 class="font-weight-bold py-3 mb-0">{{ $label }}</h4>
                        <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#"><i class="feather icon-home"></i></a></li>
                                <li class="breadcrumb-item active">{{ $label }}</li>
                            </ol>
                        </div>
                        <hr class="border-light container-m--x my-0">
                    
                        <div class="row mt-4">
                            @forelse($data as $key)
                            <div class="col-lg-3">
                                <div class="card shadow p-3" style="border-top: 8px solid #171057;">
                                <span><b>Election Title:</b> {{ $key->election_title }}</span>
                                <span><b>Year:</b> {{ $key->tbl_year }}</span>
                                <span><b>Organization:</b> {{ $key->department }}</span>
                                <span class="{{ $key->status == 'started' ? 'text-success' : 'text-danger' }}"><b>Status:</b> {{ $key->status }}</span>
                                @if($key->status == 'pending')

                                    <p class="text-danger font-weight-bold">Action: Waiting to start this election</p>
                                @else
                                    <a target="_blank" href="{{ route('view_result', [
                                        'election_title' => $key->election_title,
                                        'election_year' => $key->tbl_year,
                                        'status' => $key->status
                                    ]) }}" class="btn btn-primary my-2">View Result</a>
                                @endif
                                
                                </div>
                            </div>
                            @empty
                                <div class="py-3 col-12 alert alert-danger text-center">
                                    No Data Found
                                </div>
                            @endforelse
                        </div>

                    </div>
                    <!-- [ content ] End -->

                    <!-- [ Layout footer ] Start -->
                    @include('subadmin.files.footer')
                    <!-- [ Layout footer ] End -->

                </div>
                <!-- [ Layout content ] Start -->

            </div>
            <!-- [ Layout container ] End -->
        </div>
        <!-- Overlay -->
        <div class="layout-overlay layout-sidenav-toggle"></div>
    </div>
    <!-- [ Layout wrapper ] end -->

    <!-- Core scripts -->
@include('subadmin.files.scripts')
<script type="text/javascript" src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/2.1.4/js/dataTables.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/2.1.4/js/dataTables.bootstrap4.js"></script>
<script type="text/javascript">     
    new DataTable('#example');
</script>



</body>

</html>
