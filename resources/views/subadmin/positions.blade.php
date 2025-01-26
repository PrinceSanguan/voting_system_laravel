<!DOCTYPE html>
<html lang="en" class="material-style layout-fixed">

@include('subadmin.files.head')

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap4.min.css">

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
                    <div class="container-fluid flex-grow-1 container-p-y">
                        <h4 class="font-weight-bold py-3 mb-0">{{ $label }}</h4>
                        <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="#"><i class="feather icon-home"></i></a>
                                </li>
                                <li class="breadcrumb-item active">{{ $label }}</li>
                            </ol>
                        </div>
                        <div>
                        <div class="card-header bg-white text-black">
        <strong>Please make sure that when adding the position it should be in order and in correct sequence.</strong>
    </div>
                            <!-- HOW TO ADD POSITION Button -->
                            <button type="button" class="btn btn-info my-3" id="howToAddPositionBtn">
    HOW TO ADD POSITION
</button>

<!-- Instructions Card (Initially Hidden) -->
<div id="instructionsCard" class="card mt-3" style="display: none;">
    <div class="card-header bg-primary text-white">
        <strong>How to Add, Update, & Delete Position</strong>
    </div>
    <div class="card-body">

        <p>
            <span style="color: blue;"><strong>ADD:</strong></span> Click the "+ADD POSITION" button.
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
                        

                        

                        <!-- Session Response -->
                        @if(session()->has('response'))
                            <div class="alert {{ session()->get('response') == 1 ? 'alert-primary' : 'alert-danger' }} alert-dismissible fade show">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                {{ session('message') }}
                            </div>
                        @endif

                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary my-3" data-toggle="modal" data-target="#exampleModal">
                            <i class="fa fa-plus"></i> Add {{ $label }}
                        </button>

                        <!-- Add Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Add {{ $label }}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form method="post" action="{{ route('add.position') }}">
                                        @csrf
                                        <div class="modal-body">
                                            <label class="font-weight-bold">Position<span style="color: red;">*</span></label>
                                            <input type="text" class="form-control" placeholder="Position for Candidates" name="position" required>
                                        </div>
                                        <div class="modal-body">
                                            <label class="font-weight-bold">Maximum number of votes<span style="color: red;">*</span></label>
                                            <input type="number" class="form-control" placeholder="Number of how many candidates can be voted" name="maxvote" required min="1">
                                        </div>
                                        <small class="form-text text-black">
                                                                    Specify the maximum number of candidates a voter can select for this position.
                                                                </small>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Data Table -->
                        <div class="card p-3">
                            <table id="example" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">Position</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $count = 1; @endphp
                                    @foreach($data as $key)
                                        <tr>
                                            <td class="text-center">{{ $count }}</td>
                                            <td class="text-center">{{ $key->position }}</td>
                                            <td class="text-center">
                                                <!-- Edit Button -->
                                                <a href="#" class="btn btn-success btn-sm" data-toggle="modal" data-target="#update{{$key->id}}">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <a href="{{ route('action.delete.position', ['id' => $key->id]) }}" class="btn btn-sm btn-danger">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                                

                                                <!-- Update Modal -->
                                                <div class="modal fade" id="update{{$key->id}}" tabindex="-1" role="dialog">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Update Position</h5>
                                                                <button type="button" class="close" data-dismiss="modal">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <form method="post" action="{{ route('action.update.position') }}">
                                                                @csrf
                                                                <input type="hidden" name="id" value="{{ $key->id }}">
                                                                <div class="modal-body ">
                                                                    <label class="font-weight-bold">Position<span style="color: red;">*</span></label>
                                                                    <input type="text" class="form-control" name="position" value="{{ $key->position }}" placeholder="Position for Candidates" required>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <label class="font-weight-bold ">Maximum number of votes<span style="color: red;">*</span></label>
                                                                    <input type="number" class="form-control" name="maxvote" value="{{ $key->maxvote }}" placeholder="Number of how many candidates can be voted" required min="1">
                                                                </div>
                                                                <small class="form-text text-black">
                                                                    Specify the maximum number of candidates a voter can select for this position.
                                                                </small>

                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                                                </div>
                                                            </form>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                            </td>
                                            
                                        </tr>
                                        
                                        @php $count++; @endphp
                                    @endforeach
                                </tbody>
                            </table>
                            
                        </div>
                    </div>
                </div>
                

                <!-- [ Layout footer ] Start -->
                @include('subadmin.files.footer')
                <!-- [ Layout footer ] End -->
            </div>
            <!-- [ Layout container ] End -->
        </div>
        <div class="layout-overlay layout-sidenav-toggle"></div>
    </div>
    <!-- [ Layout wrapper ] End -->

    <!-- Core scripts -->
    @include('subadmin.files.scripts')

    <!-- Required JS -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap4.min.js"></script>
    <script>
        document.getElementById('howToAddPositionBtn').addEventListener('click', function () {
            const instructionsCard = document.getElementById('instructionsCard');
            instructionsCard.style.display = instructionsCard.style.display === 'none' ? 'block' : 'none';
        });
    </script>
    <script>
        $(document).ready(function () {
            $('#example').DataTable();
        });
    </script>
</body>
</html>
