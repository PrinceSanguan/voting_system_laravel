<!DOCTYPE html>

<html lang="en" class="material-style layout-fixed">

@include('subadmin.files.head')
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
                        <h4 class="font-weight-bold py-3 mb-0">{{ $label }} for {{ request()->query('tbl_year') }} {{ request()->query('election_title') }}</h4>
                        <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#"><i class="feather icon-home"></i></a></li>
                                <li class="breadcrumb-item active">{{ $label }} for {{ request()->query('election_year') }} {{ request()->query('election_title') }}</li>
                            </ol>
                        </div>
                        <div>
                            <!-- HOW TO ADD POSITION Button -->
                            <button type="button" class="btn btn-info my-3" id="howToAddPositionBtn">
    HOW TO ADD CANDIDATE
</button>

<div id="instructionsCard" class="card mt-3"  style="display: none;">
    <div class="card-header bg-primary text-white style" >
        <strong>How to Add, Update, & Delete Candidate</strong>
    </div>
    <div class="card-body">
        <p>
            <span style="color: blue;"><strong>ADD:</strong></span> Click the "+ADD name of (POSITION)" button.
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
                        <div class>
                        <div class="my-2 d-flex justify-content-between">
                            <button onclick="window.location.href='{{ url('subadmin/election_type/') }}'" type="button" class="btn btn-danger px-4 my-3">
                              <i class="fa fa-arrow-left"></i> Back
                            </button>


                            <button type="button" class="btn btn-primary my-3" data-toggle="modal" data-target="#exampleModal">
                              <i class="fa fa-plus"></i> Add {{ $data }}
                            </button>
                        </div>
                        
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Add {{ $data }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="{{ route('add.candidate') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" class="form-control" value="{{ $data }}" name="position">
                <input type="hidden" value="{{ $year }}" name="election_year">
                <input type="hidden" class="form-control" value="{{ request()->query('election_title') }}" name="election_title">
                <input type="hidden" value="{{ request()->query('id') }}" name="id">
                <div class="modal-body">
                    <div class="my-2">
                        <label class="font-weight-bold">First Name<span style="color: red;">*</span></label>
                        <input required type="text" class="form-control" placeholder="Candidate First Name" name="first_name">
                    </div>
                    <div class="my-2">
                        <label class="font-weight-bold">Middle Initial</label>
                        <input type="text" class="form-control" placeholder="Candidate Middle Name" name="middle_name">
                    </div>
                    <div class="my-2">
                        <label class="font-weight-bold">Last Name<span style="color: red;">*</span></label>
                        <input required type="text" class="form-control" placeholder="Candidate Last Name" name="last_name">
                    </div>
                    <div class="my-2">
                        <label class="font-weight-bold">Candidate Image<span style="color: red;">*</span></label>
                        <input required type="file" class="form-control" name="candidate_image">
                    </div>
                    <div class="my-2">
                        <label class="font-weight-bold">Certificate of Candidacy</label>
                        <input type="file" class="form-control" name="cert_of_candidacy">
                    </div>
                    <div class="my-2">
                        <label class="font-weight-bold">Candidate Party-list</label>
                        <select class="form-control" name="partylist">
                            <option value="no">No Party-list</option>
                            @foreach($partylist as $partylists)
                            <option value="{{ $partylists->partylist }}">{{ $partylists->partylist }}</option>
                            @endforeach
                        </select>
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

                        <div class="card p-3">
                            
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr class="text-center">
                                            <th>#</th>
                                            <th>Image</th>
                                            <th>Candidate Name</th>
                                            <th>Applied Position</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    @php

                                        $count = 1;

                                    @endphp

                                    @forelse($listcandidate as $key)

                                        <tr class="text-center">
                                            <td>{{ $count }}</td>
                                            <td>
                                                <a href="{{ asset('images/' . $key->candidate_image) }}">
                                                    <img height="50" width="50" src="{{ asset('images/' . $key->candidate_image) }}">
                                                </a>

                                            </td>
                                            <td>{{ $key->last_name}}, {{ $key->first_name}} {{ $key->middle_name}}</td>
                                            <td>{{ $key->position }}</td>

                                            <td>
                                            <a href="#" class="btn btn-success btn-sm" data-toggle="modal" data-target="#update{{$key->id}}">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <!-- Modal -->
                                            <div class="modal fade" id="update{{$key->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Update Candidate Information</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                        <form method="post" action="{{route('update.candidate')}}">
                                                            @csrf
                                                            <input type="hidden" value="{{ $key->id }}" name="id">
                                                            <input type="hidden" value="votingcandidates" name="table">
                                                            <div class="modal-body">
                                                                <div class="my-2">
                                                                    <div class="font-weight-bold text-left ">
                                                                    First Name<span style="color: red;">*</span>
                                                                    </div>
                                                                    <input required value="{{$key->first_name}}" type="text" class="form-control" placeholder="Candidate First Name" name="first_name" required>
                                                                </div>
                                                                <div class="my-2">
                                                                    <div class="font-weight-bold text-left">
                                                                    Middle Initial
                                                                    </div>
                                                                    <input value="{{$key->middle_name}}" type="text" class="form-control" placeholder="Candidate Middle Name" name="middle_name">
                                                                </div>
                                                                <div class="my-2">
                                                                    <div class="font-weight-bold text-left">
                                                                    Last Name<span style="color: red;">*</span>
                                                                    </div>
                                                                    <input required value="{{$key->last_name}}" type="text" class="form-control" placeholder="Candidate Last Name" name="last_name" required>
                                                                </div>

                                                                <div class="my-2">
                                                                    <div class="font-weight-bold text-left">
                                                                        Candidate Image<span style="color: red;">*</span>
                                                                    </div>
                                                                    <input required value="{{$key->candidate_image}}" type="file" class="form-control" name="candidate_image" required>
                                                                </div>
                                                                <div class="my-2">
                                                                    <div class="font-weight-bold text-left">
                                                                        Certificate of Candidacy
                                                                    </div>
                                                                    <input value="{{$key->cert_of_candidacy}}" type="file" class="form-control" name="cert_of_candidacy">
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                                
                                                </div>
                                                <a href="{{ route('subadmin.delete.candidate', [ 'id' => $key->id ]) }}" class="btn btn-danger btn-sm">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                    @php

                                        $count++

                                    @endphp

                                    @empty
                                        <tr>
                                            No Data Found
                                        </tr>
                                    @endforelse


                                </table>
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
<script type="text/javascript" src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/2.1.4/js/dataTables.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/2.1.4/js/dataTables.bootstrap4.js"></script>
<script type="text/javascript">     
    new DataTable('#example');
</script>
<script>
        document.getElementById('howToAddPositionBtn').addEventListener('click', function () {
            const instructionsCard = document.getElementById('instructionsCard');
            instructionsCard.style.display = instructionsCard.style.display === 'none' ? 'block' : 'none';
        });
    </script>

</body>

</html>
