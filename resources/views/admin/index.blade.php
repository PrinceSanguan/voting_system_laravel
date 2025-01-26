<!DOCTYPE html>

<html lang="en" class="material-style layout-fixed">

@include('admin.files.head')

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
            @include('admin.files.sidebar')
            <!-- [ Layout sidenav ] End -->
            <!-- [ Layout container ] Start -->
            <div class="layout-container">
                <!-- [ Layout navbar ( Header ) ] Start -->
                @include('admin.files.navbar')
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

                        <div id="data" class="row my-3">
                            
                        </div>
                        <div class="alert alert-danger d-none py-3 text-center" id="null">
                            No Organization Found
                        </div>

                    </div>
                    <!-- [ content ] End -->

                    <!-- [ Layout footer ] Start -->
                    @include('admin.files.footer')
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
@include('admin.files.scripts')

<script type="text/javascript">
    $(document).ready(function(){

        const realtime_admin = async() => {

            try{
                const url = `${ip}/api/realtime_card`;
                console.log(url);
                const response = await fetch(url);

                if (!response.ok) {
                    throw new Error(`Network connection error: ${response.status}`);
                }

                const result = await response.json();
                const div = $("#data");

                if(result.data.length < 1) {

                    $("#null").removeClass('d-none');

                }else{

                    $("#null").addClass('d-none');

                }

                // Loop through the result (if it's an array) and dynamically insert cards
                let content = '';
                result.data.forEach(item => {
                    
                    content += `
                         <div class="col-lg-4 col-md-6 mb-4">
                            <a href="{{ url('administrator/elections?organization=${item.organization}') }}" class="text-dark text-decoration-none">
                                <div class="card card-hover p-4 py-5 text-center shadow-lg" style="border-top: 5px solid #007bff; background: linear-gradient(135deg, #f9f9f9 0%, #e0e0e0 100%);">
                                    <div class="card-body">
                                        <h1 class="display-4 font-weight-bold text-primary">${item.organization}</h1>
                                    </div>
                                </div>
                            </a>
                        </div>
                    `;
                });

                div.html(content);
                // console.log(result);

            }catch(e){
                console.error(`error message: ${e}`);
            }
        }

        setInterval(()=>{

            realtime_admin();
        }, 2000);
    });
</script>

</body>

</html>
