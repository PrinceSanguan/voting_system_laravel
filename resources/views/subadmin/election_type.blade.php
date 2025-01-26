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
                            <div class="col-lg-4 my-2">
                                <div class="card shadow-lg">
                                    <div class="card-header bg-dark py-3 text-light font-weight-bold">
                                       <b>Election Title: </b> {{ $key->election_title }}
                                    </div>
                                    <a href="{{ route('subadmin.to_candidate', [

                                        'id' => $key->id,
                                        'election_title' => $key->election_title

                                        ]) }}" class="text-center text-dark py-3 font-weight-semibold">
                                        <p>
                                            Continue <i class="fa fa-arrow-right"></i>
                                        </p>
                                    </a>
                                </div>
                            </div>
                            @empty

                            <div class="py-3 alert alert-danger text-center w-100 text-danger font-weight-bold">
                                No Upcomming Election
                            </div>
                            <div class="card col-12">
                                <div class="card-header font-weight-bold">
                                    Candidate List:
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Position</th>
                                                <th>Organization</th>
                                                <th>Year</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $i = 1;
                                            @endphp
                                            @forelse($candidates as $candidate)
                                            <tr>
                                                <td>{{ $i }}</td>
                                                <td>{{ $candidate->first_name }} {{ $candidate->last_name }}</td>
                                                <td>{{ $candidate->position }}</td>
                                                <td>{{ $candidate->organization }}</td>
                                                <td>{{ $candidate->election_year }}</td>
                                            </tr>
                                            @php
                                            $i++;
                                            @endphp
                                            @empty
                                                <tr>
                                                    <td colspan="4">No Data Found</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                </div>
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
