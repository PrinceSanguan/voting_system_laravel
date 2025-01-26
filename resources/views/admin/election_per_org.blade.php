<!DOCTYPE html>

<html lang="en" class="material-style layout-fixed">

@include('admin.files.head')

<body>
    <!-- [ Preloader ] Start -->
    <div class="page-loader">
        <div class="bg-primary"></div>
    </div>
    <!-- [ Preloader ] End -->

    <!-- [ Layout wrapper ] Start -->
    <div class="layout-wrapper layout-2">
        <div class="layout-inner">
            <!-- [ Layout sidenav ] Start -->
            @include('admin.files.sidebar')
            <!-- [ Layout sidenav ] End -->
            <!-- [ Layout container ] Start -->
            <div class="layout-container">
                <!-- [ Layout navbar ( Header ) ] Start -->
                @include('admin.files.navbar')
                <!-- [ Layout navbar ( Header ) ] End -->

                <!-- [ Layout content ] Start -->
                <div class="layout-content">
                    <div class="container-fluid flex-grow-1 container-p-y">
                        <h4 class="font-weight-bold py-3 mb-0">{{ $label }}</h4>
                        <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#"><i class="feather icon-home"></i></a></li>
                                <li class="breadcrumb-item active">{{ $label }}</li>
                            </ol>
                        </div>
                        <hr class="border-light container-m--x my-0">
                        <div id="message"></div>
                        <div class="card p-3 table-responsive d-none" id="table">
                            <table id="example" class="table" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th class="text-center">Organization Name</th>
                                        <th class="text-center">Description</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody">
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- [ Layout footer ] Start -->
                    @include('admin.files.footer')
                    <!-- [ Layout footer ] End -->
                </div>
                <!-- [ Layout content ] End -->

            </div>
            <!-- [ Layout container ] End -->
        </div>
        <!-- Overlay -->
        <div class="layout-overlay layout-sidenav-toggle"></div>
    </div>
    <!-- [ Layout wrapper ] end -->

    <!-- Core scripts -->
    @include('admin.files.scripts')

    <script type="text/javascript">
        $(document).ready(function() {

            const storeData = (data, tbody) => {
                let content = '';
                let count = 1;

                data.forEach(item => {
                    content += `<tr class="text-center">
                        <td>${count}</td>
                        <td>${item.election_title}</td>
                        <td>${item.tbl_year}</td>
                        <td class="font-weight-bold ${ item.status == 'pending' || item.status == 'started' ? 'text-primary' : 'text-danger' }">${item.status}</td>
                        <td>
                ${item.status == 'started' || item.status == 'done' ||item.status == 'stopped'
                ? `<a href="{{ url('administrator/view-result?election_title=') }}${item.election_title}&election_year=${item.tbl_year}&status=${item.status}&organization=${item.department}" target="_blank" class="btn btn-primary">View Result</a>` 
                : '<p class="text-primary">Waiting to start...</p>'}
            </td>

                    </tr>`;
                    count++;
                });

                tbody.html(content);
            };

            const realtime_table = async () => {
                try {
                    const url = `${ip}/api/realtime_org_election?organization={{ request()->query('organization') }}`;
                    console.log(url);

                    const response = await fetch(url);
                    if (!response.ok) {
                        throw new Error(`Network Error: ${response.status}`);
                    }

                    const result = await response.json();
                    const tbody = $('#tbody');

                    if (result.response == 1) {
                        $("#message").html(''); // Clear any previous messages
                        $("#table").removeClass('d-none'); // Show the table
                        storeData(result.data, tbody);
                    } else if (result.response == 2) {
                        $("#table").addClass('d-none'); // Hide the table if no data
                        $("#message").html(`<div class="alert alert-danger text-center py-3 mt-3">No Data Found</div>`);
                    }

                    console.log(result);

                } catch (e) {
                    console.error(`Error Message: ${e}`);
                }
            };

            // Realtime table data fetching every second
            setInterval(() => {
                realtime_table();
            }, 1000);
        });
    </script>
</body>

</html>
