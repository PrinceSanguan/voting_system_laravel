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
                        <!-- {{ session()->get('organization') }} -->
                        <hr class="border-light container-m--x my-0">
                        <div class="row my-2">
                            <div class="col-lg-3">
                                <div class="card">
                                    <div class="card-header py-2 bg-dark text-white">
                                        No. of Position
                                    </div>
                                    <div class="card-body text-center">
                                    <h3 id="position" style="color: black;">{{ $data["position"] }}</h3>
                                    </div>
                                    <div class="card-footer py-1 px-0 text-center bg-success text-danger">
                                        <a href="{{ route('subadmin.position') }}">
                                        <span style="color: gray;">More Info ></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="card">
                                    <div class="card-header py-2 bg-dark text-white">
                                        No. of Candidate
                                    </div>
                                    <div class="card-body text-center">
                                    <h3 id="candidate" style="color: black;">{{ $data["candidate"] }}</h3>
                                    </div>
                                    <div class="card-footer py-1 px-0 text-center bg-success text-danger">
                                        <a href="{{route('subadmin.election_type')}}">
                                        <span style="color: gray;">More Info ></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="card">
                                    <div class="card-header py-2 bg-dark text-white">
                                        No. of Partylist
                                    </div>
                                    <div class="card-body text-center">
                                    <h3 id="partylist" style="color: black;">{{ $data["partylist"] }}</h3>
                                    </div>
                                    <div class="card-footer py-1 px-0 text-center bg-success text-danger">
                                        <a href="{{ route('subadmin.partylist') }}">
                                        <span style="color: gray;">More Info ></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="card">
                                    <div class="card-header py-2 bg-dark text-white d-flex align-items-center justify-content-between">
                                        <div>
                                          No. of Voter
                                    </div>
                                       
                                    </div>
                                    <div class="card-body text-center">
                                        <h3 id="voter" style="color: black;">{{ $data["voters"] }}</h3>
                                    </div>
                                    <div class="card-footer py-1 px-0 text-center bg-success text-danger">
                                        <a href="{{ route('subadmin.voter-list') }}">
                                        <span style="color: gray;">More Info ></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                           
                            </div>
                            <div class="col-lg-12 col-12 mt-5" id="realtime_votes">
                                <div class="card p-5 shadow-lg border-0 border-top border-5 border-dark mb-5">
                                    <div class="fw-bold mb-2 fs-5"><strong>Voting Results:</strong></div>
                                    <div id="realtime-result">
                                        <p class="text-danger">Loading Results Please Wait....</p>
                                    </div>
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
<script>
    const handleChange = async (value) => {
        const org = '{{ session()->get("organization") }}';
        const url = `${ip}/api/voters?value=${value}&organization=${org}`;

        try {
            const response = await fetch(url);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            const data = await response.json();

            const { value } = data.data;
            $("#voter").text(value);

        } catch (error) {
            console.error(`Error Message: ${error.message}`);
        }
    }
</script>

<script>
    let chart; // Store the chart instance for dynamic updates

    const gatherData = async () => {
        try {
            const url = `${ip}/api/dashboardChart?organization={{ session()->get('organization') }}`;
            console.log(url);
            const response = await fetch(url);
            if (!response.ok) {
                throw new Error(`Network Connection Error: ${response.status}`);
            }
            const result = await response.json();
            if (!result.response) {
                $("#no_election").removeClass('d-none');
                $("#no_election").text(result.message);
            }else{
                $("#no_election").addClass('d-none');
            }
            console.log(result);

            // Process data
            const { categories, votes } = processDataForHorizontalChart(result);

            // If chart exists, update it; otherwise, create a new one
            if (chart) {
                updateChart(categories, votes);
            } else {
                createHorizontalChart(categories, votes);
            }
        } catch (error) {
            console.error("Error fetching or processing data:", error);
        }
    };

    const processDataForHorizontalChart = (data) => {
        const positions = Object.keys(data.data);
        const categories = [];
        const votes = [];

        positions.forEach((position) => {
            data.data[position].forEach((candidate) => {
                categories.push(`${candidate.first_name} ${candidate.last_name} (${position})`);
                votes.push(parseInt(candidate.vote, 10) || 0);
            });
        });

        return { categories, votes };
    };

    const createHorizontalChart = (categories, votes) => {
        const options = {
            chart: {
                height: 450,
                type: "bar",
            },
            plotOptions: {
                bar: {
                    horizontal: true,
                    barHeight: "50%",
                },
            },
            dataLabels: {
                enabled: false,
            },
            xaxis: {
                categories: categories,
                title: {
                    text: "Votes",
                },
            },
            yaxis: {
                title: {
                    text: "Candidates",
                },
            },
            series: [
                {
                    name: "Votes",
                    data: votes,
                },
            ],
            title: {
                text: "Vote Results",
                align: "center",
            },
        };

        chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
    };

    const updateChart = (categories, votes) => {
        chart.updateOptions({
            xaxis: {
                categories: categories,
            },
            series: [
                {
                    name: "Votes",
                    data: votes,
                },
            ],
        });
    };

    // Fetch data and update chart every 10 seconds
    gatherData(); // Initial fetch
    setInterval(gatherData, 3000); // Update every 10 seconds
</script>

<script type="text/javascript">
    $(document).ready(function(){
    const realtime_result = async () => {
        try {
        const url = `${ip}/api/realtime_result?organization={{ session()->get('organization') }}&fingerprint={{ session()->get('id') }}`;
        const response = await fetch(url);
        console.log(url);
        if (!response.ok) {
            throw new Error(`Network Connection Error: ${response.status}`);
        }

        const result = await response.json();
        console.log(result);
        const resultsContainer = $('#realtime-result');
        resultsContainer.empty();

        // Render the real-time voting results
        for (const [position, candidates] of Object.entries(result.data)) {
            candidates.sort((a, b) => (b.vote || 0) - (a.vote || 0));
            let positionHtml = `<h4 class="fw-bold">${position}</h4>`;

            candidates.forEach(candidate => {

            let percent = (candidate.vote / result.voters) * 100;
                percent = percent.toFixed(2);


            let percentage = candidate.votes_percentage || 0; // Assume there's a percentage value in the API
            positionHtml += `
                <div class="my-3">
                <span class="text-secondary">
                <img width="40p" height="50" src="{{ asset('images/${candidate.candidate_image}') }}" />
                ${candidate.last_name},${candidate.first_name} (${candidate.vote == null ? 0 : percent}% vote )
                </span>
                <div class="progress mt-1" style="height: 30px;">
                    <div
                    class="progress-bar bg-success" role="progressbar"
                    style="width: ${percent == null ? 0 : percent}%"
                    aria-valuenow="${percent == null ? 0 : percent}"
                    aria-valuemin="0"
                    aria-valuemax="100"
                    >${candidate.vote == null ? 0 : percent}</div>
                </div>
                </div>`;
            });

            // Append the position results to the container
            resultsContainer.append(positionHtml);
        }
        } catch (e) {
        console.error(`Error Message: ${e}`);
        }
    }

    // Fetch the results every 5 seconds
    setInterval(realtime_result, 1000);
    });
</script>




</body>

</html>
