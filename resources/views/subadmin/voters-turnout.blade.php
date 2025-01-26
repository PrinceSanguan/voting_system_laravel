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
                    <!-- {{ session()->get('organization') }} -->
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
                        <div class="row">
                            <div class="col-lg-6 mt-5">
                                <div class="card">
                                    <div class="card-header bg-dark py-2 text-white">Voter Turnout</div>
                                    <div class="card-body">
                                        @if($response)
                                        <div id="chart"></div>
                                        @else
                                            <div class="text-center alert alert-danger">
                                                {{ $message }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="card-footer bg-success py-2"></div>
                                </div>
                            </div>
                            <div class="col-lg-6 mt-5">
                                <div class="card">
                                    <div class="card-header bg-dark py-2 text-white">Votes By Gender</div>
                                    <div class="card-body">
                                        @if($response)
                                        <div id="gender"></div>
                                        @else
                                            <div class="text-center alert alert-danger">
                                                {{ $message }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="card-footer bg-success py-2"></div>
                                </div>
                            </div>
                            <div class="col-lg-12 mt-5">
                                <div class="card">
                                    <div class="card-header bg-dark py-2 text-white">Candidate Key Demographics Data</div>
                                    <div class="card-body">
                                        @if($response)
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Position</th>
                                                        <th>Name</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($candidate as $candidates)
                                                    <tr>
                                                        <td>{{ $candidates->position }}</td>
                                                        <td>{{ $candidates->first_name }} {{ $candidates->last_name }}</td>
                                                        <td>
                                                            <!-- Button trigger modal -->
                                                            <button onClick="handleModal({{ $candidates->id }})" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                                                <i class="fa fa-info"></i>
                                                            </button>
                                                            
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        @else
                                            <div class="text-center alert alert-danger">
                                                {{ $message }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="card-footer bg-success py-2"></div>
                                </div>
                            </div>
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
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
@if($response)
<script>
    var options = {
        series: [{{ $voter["voted"] }}, {{ $voter["notvoted"] }}],
        chart: {
        width: 419,
        type: 'pie',
    },
    labels: ['Voted', 'Not Voted'],
    colors: ["blue", "red"],
    responsive: [{
        breakpoint: 480,
        options: {
        chart: {
            width: 200
        },
        legend: {
            position: 'bottom'
        }
        }
    }]
    };

    var chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();
</script>
<script>
    var options = {
        series: [{
            data: [
                {
                    x: 'Male Voted',
                    y: {{ $voter["malevoted"] }},
                    fillColor: 'blue'
                },
                {
                    x: 'Male not Vote',
                    y: {{ $voter["malenotvoted"] }},
                    fillColor: 'green'
                },
                {
                    x: 'Female Voted',
                    y: {{ $voter["femalevoted"] }},
                    fillColor: 'red'
                },
                
                {
                    x: 'Female not Vote',
                    y: {{ $voter["femalenotvoted"] }},
                    fillColor: 'orange'
                }
            ]
        }],
        chart: {
            width: '100%',
            type: 'bar',
        },
        plotOptions: {
            bar: {
                distributed: true, // This allows individual bar colors
                borderRadius: 4
            }
        },
        dataLabels: {
            enabled: true
        },
        legend: {
            show: false // No need for legend since colors are tied to individual bars
        }
    };

    var chart = new ApexCharts(document.querySelector("#gender"), options);
    chart.render();
</script>
@endif
<script>
    const modal = (result) => {
        // Create the modal HTML dynamically
        const modalHTML = `
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-dark">
                            <h5 class="modal-title text-white" id="exampleModalLabel">Candidate Key Demographics Data</h5>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12 shadow p-2 my-3" style="border-left: 10px solid #4a4024; border-radius: 10px">
                                    <div class="fw-bold"><b>Votes by Gender</b></div>
                                    <div class="fw-bold">Male: ${result.gender.male}</div>
                                    <div class="fw-bold">Female: ${result.gender.female}</div>
                                </div>
                                <div class="col-md-12 shadow p-2 my-3" style="border-left: 10px solid #4a4024; border-radius: 10px">
                                    <div class="fw-bold"><b>Votes by Course</b></div>
                                    <div class="fw-bold">Math: ${result.course.math}</div>
                                    <div class="fw-bold">Filipino: ${result.course.filipino}</div>
                                    <div class="fw-bold">English: ${result.course.english}</div>
                                    <div class="fw-bold">Soc. Stud.: ${result.course.socstud}</div>
                                    <div class="fw-bold">Beed: ${result.course.beed}</div>
                                    <div class="fw-bold">Bped: ${result.course.bped}</div>
                                    <div class="fw-bold">Bsit: ${result.course.bsit}</div>
                                    <div class="fw-bold">Bshm: ${result.course.bshm}</div>

                                </div>
                                <div class="col-md-12 shadow p-2 my-3" style="border-left: 10px solid #4a4024; border-radius: 10px">
                                    <div class="fw-bold"><b>Votes by Year</b></div>
                                    <div class="fw-bold">1st Year: ${result.year_level['1st_year']}</div>
                                    <div class="fw-bold">2nd Year: ${result.year_level['2nd_year']}</div>
                                    <div class="fw-bold">3rd Year: ${result.year_level['3rd_year']}</div>
                                    <div class="fw-bold">4th Year: ${result.year_level['4th_year']}</div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button onClick="window.location.reload()" class="btn btn-secondary">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        `;

        // Append modal to the body
        document.body.insertAdjacentHTML('beforeend', modalHTML);

        // Initialize the modal with options to disable backdrop click and keyboard escape
        const exampleModal = new bootstrap.Modal(document.getElementById('exampleModal'), {
            backdrop: 'static', // Prevent closing when clicking outside the modal
            keyboard: false     // Prevent closing with the ESC key
        });

        // Show the modal
        exampleModal.show();

        // Reload page when modal is hidden
        document.getElementById('exampleModal').addEventListener('hidden.bs.modal', () => {
            document.getElementById('exampleModal').remove();
            window.location.reload();
        });
    };

    const handleModal = async (id) => {
        try {
            const response = await fetch(`${ip}/api/candidate_vote_info?id=${id}`);
            if (!response.ok) {
                throw new Error(`Network Error ${response.status}`);
            }
            const result = await response.json();
            modal(result);
            console.log(result);
        } catch (error) {
            console.error(`Error Message: ${error}`);
        }
    };
</script>

</body>

</html>
