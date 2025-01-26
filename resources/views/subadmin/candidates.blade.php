<!DOCTYPE html>

<html lang="en" class="material-style layout-fixed">

@include('subadmin.files.head')

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
                        <h4 class="font-weight-bold py-3 mb-0">{{ $label }} for {{ request()->query('election_title') }}</h4>
                        <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#"><i class="feather icon-home"></i></a></li>
                                <li class="breadcrumb-item active">{{ $label }} for {{ request()->query('election_title') }}</li>
                            </ol>
                        </div>
                        <hr class="border-light container-m--x my-0">

                        <div class="row mt-4">
                            @forelse($positions as $position)
                            <div class="col-lg-4 my-2">
                                <div class="card shadow-lg">
                                    <div class="card-header bg-primary py-3 text-light font-weight-bold">
                                       <b>Running For: </b> {{ $position->position }}
                                    </div>
                                    <div class="card-body d-flex justify-content-center align-items-center">
                                        <b>Number of Candidate: </b> <i class="fa fa-user px-2 text-primary"></i> 
                                        {{ $counts[$position->position] }}
                                    </div>
                                    <a href="{{ route('candidate.position',[ 

                                    'position' => $position->position,

                                    'id' => request()->query('id'),

                                    'election_title' => request()->query('election_title'),

                                    'required' => $required
                                    
                                    ]
                                    ) }}" class="text-center pb-3 font-weight-semibold">
                                        <p>
                                            View Candidates <i class="fa fa-arrow-right"></i>
                                        </p>
                                    </a>
                                </div>
                            </div>
                            @empty

                                <div class="col-12 bg-danger rounded text-center text-white py-3" style="font-size: 30px">
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
</body>

</html>
