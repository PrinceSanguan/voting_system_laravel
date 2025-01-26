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
                        @if(session()->has('response'))
                            <div class="alert mt-3 {{ session()->get('response') == 1 ? 'alert-primary' : 'alert-danger' }} alert-dismissible fade show">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                {{ session()->get('message') }}
                            </div>
                        @endif
                        <form method="post" action="{{ route('admin-update-mydata') }}">
                            @csrf
                            <div id="data"></div>
                        </form>
                        

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

<script type="text/javascript">
    $(document).ready(function(){

        const storeData = (data, div) => {

            $('input').attr('required', 'required');

            let content = '';

            // Provide fallback/default values if the fields are null
            const name = data.name || '';
            const role = data.role || '';
            const age = data.age || '';
            const gender = data.gender || '';
            const fingerprint = data.fingerprint || '';

            // Handle gender selection options dynamically
            let genderOptions = `
                <option value="">Select Gender</option>
                <option value="male" ${gender === 'male' ? 'selected' : ''}>Male</option>
                <option value="female" ${gender === 'female' ? 'selected' : ''}>Female</option>
            `;

            content += `
                <div class="card p-5 mt-3 shadow-sm border-0" style="border-top: 10px solid black; border-radius: 10px;">
                    <div class="h3 font-weight-bold col-12 mb-4">My Data: </div>
                    <div class="row">
                        <div class="my-4 col-lg-6">
                            <label class="font-weight-bold">Name: </label>
                            <input required class="form-control rounded-pill shadow-sm" placeholder="Update Your Name" type="text" value="${name}" name="name">
                        </div>
                        <div class="my-4 col-lg-6">
                            <label class="font-weight-bold">Role: </label>
                            <input required class="form-control rounded-pill shadow-sm" placeholder="Update Your Role" type="text" value="${role}" name="role">
                        </div>

                        <div class="my-4 col-lg-6">
                            <label class="font-weight-bold">Age: </label>
                            <input required class="form-control rounded-pill shadow-sm" type="text" placeholder="Update Your Age" value="${age}" name="age">
                        </div>

                        <div class="my-4 col-lg-6">
                            <label class="font-weight-bold">Gender: </label>
                            <select class="form-control" name="gender" required>
                                ${genderOptions}
                            </select>
                        </div>

                        <div class="my-4 col-lg-12 text-right">
                            <button class="btn btn-primary col-3 py-2">Apply Changes</button>
                        </div>
                    </div>
                </div>
            `;

            div.html(content); // Insert the generated content into the div
        }

        const mydata = async () => {
            try {
                const url = `${ip}/api/myaccount?id={{session()->get('id')}}`;
                console.log(url);

                const response = await fetch(url);
                if (!response.ok) {
                    throw new Error(`Network connection error: ${response.status}`);
                }

                const result = await response.json();
                const div = $("#data");

                storeData(result.data, div);

                console.log(result.data);

            } catch (e) {
                console.error(`Error Message: ${e}`);
            }
        }       

        mydata();
    });
</script>


</body>

</html>
