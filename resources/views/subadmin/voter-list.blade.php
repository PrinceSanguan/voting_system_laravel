<!DOCTYPE html>
<html lang="en" class="material-style layout-fixed">

@include('subadmin.files.head')
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/2.1.4/css/dataTables.bootstrap4.css">

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
            @include('subadmin.files.sidebar')
            <!-- [ Layout sidenav ] End -->
            
            <!-- [ Layout container ] Start -->
            <div class="layout-container">
                <!-- [ Layout navbar ( Header ) ] Start -->
                @include('subadmin.files.navbar')
                <!-- [ Layout navbar ( Header ) ] End -->

                <!-- [ Layout content ] Start -->
                <div class="layout-content">

                    <!-- [ Content ] Start -->
                    <div class="container-fluid flex-grow-1 container-p-y">
                        <h4 class="font-weight-bold py-3 mb-0">{{ $label }}</h4>
                        <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#"><i class="feather icon-home"></i></a></li>
                                <li class="breadcrumb-item active">{{ $label }}</li>
                            </ol>
                        </div>
                        
                        <div>
                            <!-- HOW TO ADD POSITION Button -->
                            <button type="button" class="btn btn-info my-3" id="howToAddPositionBtn">
    HOW TO ADD VOTERS
</button>

<div id="instructionsCard" class="card mt-3"  style="display: none;">
    <div class="card-header bg-primary text-white style" >
        <strong>How to Add, Update, & Delete Voters</strong>
    </div>
    <div class="card-body">
        <p>
            <span style="color: blue;"><strong>ADD:</strong></span> Click the "+ADD VOTERS" button.
        </p>
        <p>
            <span style="color: green;"><strong>UPDATE:</strong></span> Click the "green pen icon" in the Action Table.
        </p>
        <p>
            <span style="color: red;"><strong>DELETE:</strong></span> Click the "red trash icon" in the Action Table.
        </p>

                        </div>
                        </div>
</div>
                        @if(session()->has('response'))
                            <div class="alert {{ session()->get('response') == 1 ? 'alert-primary' : 'alert-danger' }} alert-dismissible fade show">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                {{ session()->get('message') }}
                            </div>
                        @endif

                        <!-- Button trigger modal -->
                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-primary my-3" data-toggle="modal" data-target="#exampleModal">
                                <i class="fa fa-plus"></i> Add {{ $label }}
                            </button>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Add {{ $label }}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form method="post" action="{{ route('add.voter') }}">
                                    @csrf
    <div class="modal-body">
        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mb-4">
            <label class="font-weight-bold">
                Voter Email<span style="color: red;">*</span>
            </label>
            <input type="email" class="form-control" placeholder="Voter Email" name="email" value="{{ old('email') }}" required>
        </div>

        <div class="mb-4">
            <label class="font-weight-bold">
                Voter Pin<span style="color: red;">*</span>
            </label>
            <input 
                type="password" 
                class="form-control" 
                placeholder="Voter Pin" 
                name="pin" 
                value="{{ old('pin') }}" 
                pattern="\d{8}" 
                title="Voter Pin must be exactly 8 digits" 
                minlength="8" 
                maxlength="8" 
                required>
            
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save</button>
    </div>

                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Voters Table -->
                        <div class="card p-3">
    <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th class="text-center">#</th>
                <th class="text-center">Email</th>
                <th class="text-center">Voters Name</th>
                <th class="text-center">Organization</th>
                <th class="text-center">Status</th>
                
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @php $count = 1; @endphp
            @foreach($data as $key)
            <tr>
                <td class="text-center">{{ $count }}</td>
                <td class="text-center">{{ $key->email }}</td>
                <td class="text-center">{{ $key->first_name }} {{ $key->middle_name }} {{ $key->last_name }}</td>
                <td class="text-center">{{ $key->organization }}</td>
                <td class="text-center font-weight-bold {{ $key->status == 'pending' ? 'text-warning' : 'text-primary' }}">
                    {{ $key->status }}
                </td>
                
                <td class="text-center"> <!-- Action column content -->
                    <a href="#" class="btn btn-success btn-sm" data-toggle="modal" data-target="#update{{$key->id}}">
                        <i class="fa fa-edit"></i>
                    </a>
                    <!-- Modal -->
                    <div class="modal fade" id="update{{$key->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Update Voter</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form method="post" action="{{ route('update.voter') }}">
                                    @csrf
                                    <input type="hidden" value="{{ $key->id }}" name="id">
                                    <input type="hidden" value="votingcomponents" name="table">
                                    <div class="modal-body">
                                        <div class="font-weight-bold text-left">
                                            Voter Email<span style="color: red;">*</span>
                                        </div>
                                        <input type="text" value="{{ $key->email }}" class="form-control" placeholder="Enter Voter Email" name="email">

                                        <div class="font-weight-bold text-left mt-3">
                                            Voter PIN<span style="color: red;">*</span>
                                        </div>
                                        <input type="password" value="{{ $key->pin }}" class="form-control" placeholder="Enter Voter PIN" name="pin" pattern="\d{8}" title="PIN must be exactly 8 digits" required>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('action.delete.voters',[ 'id' => $key->id ] ) }}" class="btn btn-sm btn-danger">
                        <i class="fa fa-trash"></i>
                    </a>
                </td>
            </tr>
            @php $count++; @endphp
            @endforeach
        </tbody>
    </table>
</div>


                    </div>
                    <!-- [ Content ] End -->

                    <!-- [ Layout footer ] Start -->
                    @include('subadmin.files.footer')
                    <!-- [ Layout footer ] End -->
                </div>
                <!-- [ Layout content ] End -->
            </div>
            <!-- [ Layout container ] End -->
        </div>
        <!-- Overlay -->
        <div class="layout-overlay layout-sidenav-toggle"></div>
    </div>
    <!-- [ Layout wrapper ] End -->

    <!-- Core scripts -->
    @include('subadmin.files.scripts')
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/2.1.4/js/dataTables.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/2.1.4/js/dataTables.bootstrap4.js"></script>

    <script type="text/javascript">
        // Initialize DataTable
        new DataTable('#example');

        // Reopen Modal on Validation Error
        @if ($errors->any())
            $(document).ready(function () {
                $('#exampleModal').modal('show');
            });
        @endif

        // Frontend PIN Validation
        document.querySelector('form').addEventListener('submit', function(event) {
    var pin = document.querySelector('[name="pin"]').value;

    // Check if PIN is numeric and exactly 8 digits
    if (!/^\d{8}$/.test(pin)) {
        alert("Voter Pin must be exactly 8 numeric digits.");
        event.preventDefault(); // Prevent form submission
    }
});
    </script>
    <script>
        document.getElementById('howToAddPositionBtn').addEventListener('click', function () {
            const instructionsCard = document.getElementById('instructionsCard');
            instructionsCard.style.display = instructionsCard.style.display === 'none' ? 'block' : 'none';
        });
    </script>
</body>
</html>
