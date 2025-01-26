<!DOCTYPE html>

<html lang="en" class="material-style layout-fixed">

@include('subadmin.files.head')
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css"> -->
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
  <div class="form-group position-relative">

    <!-- Reminder Text -->
    
  
  <hr class="border-light container-m--x my-0">
                    <!-- [ content ] Start -->
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
    HOW TO ADD ELECTION
</button>

<div id="instructionsCard" class="card mt-3"  style="display: none;">
    <div class="card-header bg-primary text-white style" >
        <strong>How to Add, Update, Delete, See, Start, & Finish Election</strong>
    </div>
    <div class="card-body">
        <p>
            <span style="color: blue;"><strong>ADD:</strong></span> Click the "+ADD ELECTION" button.
        </p>
        <p>
            <span style="color: green;"><strong>UPDATE:</strong></span> Click the "green pen icon" in the Action Table.
        </p>
        <p>
            <span style="color: red;"><strong>DELETE:</strong></span> Click the "red trash icon" in the Action Table.
        </p>
        <p>
            <span style="color: purple;"><strong>SEE:</strong></span> Click the "purple eye icon" in the Action Table.
        </p>
        <p>
            <span style="color: green;"><strong>START:</strong></span> Click the "green START icon" in the Action Table.
        </p>
        <p>
            <span style="color: red;"><strong>FINISH:</strong></span> Click the "red FINISH icon" in the Action Table.
        </p>

                        </div>
                        </div>
</div>
                        
                        <hr class="border-light container-m--x my-0">

                        @if(session()->has('response'))
                            <div class="my-3 alert {{ session()->get('response') == 1 ? 'alert-primary' : 'alert-danger' }} alert-dismissible fade show">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                {{ session()->get('message') }}
                            </div>
                        @endif
                        <!-- Button trigger modal -->
                         <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-primary my-3" data-toggle="modal" data-target="#exampleModal">
                                <i class="fa fa-plus"></i> Add {{ $label }}
                            </button>
                            <button type="button" class="btn btn-success my-3" onclick="location.reload()" >
                                 Refresh
                            </button>
                         </div>
                        

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">
                                    Add {{ $label }}
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <form method="post" action="{{ route('add.election') }}">
                                @csrf
                                  <div class="modal-body">
                                    <div class="mb-4">
                                        <label class="font-weight-bold">
                                        Election Title<span style="color: red;">*</span>
                                        </label>
                                        <input type="text" class="form-control" placeholder="Election Title" name="election_title" required>
                                    </div>
                                    <div class="my-2">
                                        <label class="font-weight-bold">
                                        Year<span style="color: red;">*</span>
                                        </label>
                                        <input type="text" class="form-control" placeholder="Year" name="tbl_year" required>
                                    </div>
                                    <div class="mt-5">
                                        <label class="font-weight-bold">Election Period</label>
                                        <div class="my-2">
                                            <label class="font-weight-bold">Date: </label>
                                            <input type="date" class="form-control" name="tbl_date">
                                        </div>
                                        <div class="my-2">
                                            <label class="font-weight-bold">Starting Time: </label>
                                            <input type="time" class="form-control" name="start_time">
                                        </div>
                                        <div class="my-2">
                                            <label class="font-weight-bold">End Time: </label>
                                            <input type="time" class="form-control" name="end_time">
                                        </div>
                                    </div>
                                    <div class="my-3">
                                        <label class="font-weight-bold">
                                        Is this election required a Party-List?<span style="color: red;">*</span>
                                        </label>
                                        <select class="form-control" name="required_partylist" required>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
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
                            
                            <table id="example" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">Election Title</th>
                                        <th class="text-center">Year</th>
                                        <th class="text-center">Date</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $key)
                                    <tr class="text-center">
                                            <td>{{ $key->election_title }}</td>
                                            <td class="text-center">{{ $key->tbl_year}}</td>
                                            <td class="text-center">{{ $key->tbl_date }}</td>
                                            <td class="font-weight-bold {{ $key->status == 'pending' ? 'text-primary' : ($key->status == 'started' ? 'text-success' : 'text-danger') }}">{{ $key->status }}
                                            </td>

                                            <td>
                                            @if ($key->status == 'pending')
    <!-- Start Button -->
    <a href="#" class="btn btn-success btn-sm" data-toggle="modal" data-target="#startModal">
        <i class="fa fa-circle text-white"></i> Start
    </a>

    <!-- Start Modal -->
    <div class="modal fade" id="startModal" tabindex="-1" role="dialog" aria-labelledby="startModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="startModalLabel">Start the voting session?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('subadmin.vote.action') }}" method="get">
                    <div class="modal-body">
                        <input type="hidden" name="id" value="{{ $key->id }}">
                        <input type="hidden" name="status" value="started"> <!-- Updated status to "started" for the start action -->
                        <div style="text-align:left" class="mb-3">Message<span style="color: red;">*</span></div>
                        <textarea required class="form-control" name="message" placeholder="Enter Message" required></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Start</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@elseif($key->status == 'started')
    <!-- Finish Button -->
    <a href="#" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#finishModal">
        <i class="fa fa-circle text-white"></i> Finish
    </a>

    <!-- Finish Modal -->
    <div class="modal fade" id="finishModal" tabindex="-1" role="dialog" aria-labelledby="finishModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="finishModalLabel">Finish the voting session?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('subadmin.vote.action') }}" method="get">
                    <div class="modal-body">
                        <input type="hidden" name="id" value="{{ $key->id }}">
                        <input type="hidden" name="status" value="done"> <!-- Updated status to "finished" for the finish action -->
                        <div style="text-align:left" class="mb-3">Message<span style="color: red;">*</span></div>
                        <textarea required class="form-control" name="message" placeholder="Enter Message" required></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Finish</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@else
<a target="_blank" href="{{ route('view_result', [
                                        'election_title' => $key->election_title,
                                        'election_year' => $key->tbl_year,
                                        'status' => $key->status
                                    ]) }}" class="btn btn-success btn-sm">View Result</a>
                                                    

                                                @endif

                                                <a class="btn btn-primary btn-sm" data-toggle="modal"  data-target="#items{{$key->id}}">
                                                    <i class="fa fa-eye text-light"></i>
                                                </a>
                                                <a href="#" class="btn btn-success btn-sm" data-toggle="modal" data-target="#update{{$key->id}}">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <a href="{{ route('subadmin.action.delete', [ 'id' => $key->id ]) }}" class="btn btn-danger btn-sm" >
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @if(session('success'))
                            <div class="my-3 alert {{ session()->get('response') == 1 ? 'alert-primary' : 'alert-danger' }} alert-dismissible fade show">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                {{ session('success') }}
                            </div>
                        @endif
                                        <div class="modal fade" id="update{{$key->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Update Election</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                    <form method="post" action="{{route('update.election')}}">
                                                        @csrf
                                                        <input type="hidden" value="{{ $key->id }}" name="id">
                                                        <input type="hidden" value="elections" name="table">
                                                        <div class="modal-body">
                                                            <div class="my-3">
                                                                <div class="text-left font-weight-bold">
                                                                Election Title<span style="color: red;">*</span>
                                                                </div>
                                                                <input value="{{ $key->election_title }}" type="text" class="form-control" name="election_title"required>
                                                            </div>
                                                            <div class="my-3">
                                                                <div class="text-left font-weight-bold">
                                                                Election Year<span style="color: red;">*</span>
                                                                </div>
                                                                <input value="{{ $key->tbl_year }}" type="text" class="form-control" name="tbl_year" required>
                                                            </div>
                                                            <div class="mt-5">
                                                                <label class="font-weight-bold">Election Period</label>
                                                            <div class="my-3">
                                                                <div class="text-left font-weight-bold">
                                                                    Election Date
                                                                </div>
                                                                <input value="{{ $key->tbl_date }}" type="date" class="form-control" name="tbl_date">
                                                            </div>
                                                            <div class="my-3">
                                                                <div class="text-left font-weight-bold">
                                                                    Starting Time
                                                                </div>
                                                                <input value="{{ $key->start_time }}" type="time" class="form-control" name="tbl_date">
                                                            </div>
                                                            <div class="my-3">
                                                                <div class="text-left font-weight-bold">
                                                                    End Time
                                                                </div>
                                                                <input value="{{ $key->end_time }}" type="time" class="form-control" name="tbl_date">
                                                            </div>
                                                            <div class="my-3">
                                                                <label class="font-weight-bold">
                                                                    Is this election required a Party-List?<span style="color: red;">*</span>
                                                                </label>
                                                                <select class="form-control" name="required_partylist">
                                                                    <option value="Yes" {{ $key->required_partylist == 'Yes' ? 'selected' : '' }}>Yes</option>
                                                                    <option value="No" {{ $key->required_partylist == 'No' ? 'selected' : '' }}>No</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            </div>
                                        </div>

                                        <div class="modal fade" id="items{{$key->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                          <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                              <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">
                                                    Election Data
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                  <span aria-hidden="true">&times;</span>
                                                </button>
                                              </div>
                                                  <div class="modal-body">
                                                    <div class="my-2">
                                                        <label class="font-weight-bold">
                                                            Election Title:
                                                        </label>
                                                        {{ $key->election_title }}
                                                    </div>
                                                    <div class="my-2">
                                                        <label class="font-weight-bold">
                                                            Election Year:
                                                        </label>
                                                        {{ $key->tbl_year }}
                                                    </div>
                                                    <div class="my-2">
                                                        <label class="font-weight-bold">
                                                            Election Date:
                                                        </label>
                                                        {{ $key->tbl_date }}
                                                    </div>
                                                    <div class="my-2">
                                                        <label class="font-weight-bold">
                                                            Election Starting Time:
                                                        </label>
                                                        {{ $key->start_time }}
                                                    </div>                                      
                                                    <div class="my-2">
                                                        <label class="font-weight-bold">
                                                            Election End Time:
                                                        </label>
                                                        {{ $key->end_time }}
                                                    </div>
                                                    <div class="my-2">
                                                        <label class="font-weight-bold">
                                                            Election Status:
                                                        </label>
                                                        {{ $key->status }}
                                                    </div>
                                                    <div class="my-2">
                                                        <label class="font-weight-bold">
                                                            This Election Required Party-list?
                                                        </label>
                                                        {{ $key->required_partylist }}
                                                    </div>
                                                  </div>
                                            </div>
                                          </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            
                            </table>
                            
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

    <script type="text/javascript">
    $(document).ready(function() {

        const updateData = async () => {
            try {
                const url = `${ip}/api/update_election`;
                console.log(url);
                const response = await fetch(url);

                if (!response.ok) {
                    throw new Error(`Network connection error ${response.status}`);
                }

                const result = await response.json();
                console.log(result);
            } catch (error) {
                console.error(`Error Message: ${error}`);
            }
        }

        // Set an interval to repeatedly call the updateData function every 2 seconds
        const interval = setInterval(() => {
            updateData();
        }, 2000);

        // Optional: To clear the interval after a certain condition
        // Example: clearInterval(interval); after certain time or condition

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
