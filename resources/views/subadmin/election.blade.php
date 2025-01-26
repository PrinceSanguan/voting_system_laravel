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
                                            Election Title
                                        </label>
                                        <input type="text" class="form-control" placeholder="Election Title" name="election_title">
                                    </div>
                                    <div class="my-2">
                                        <label class="font-weight-bold">
                                            Year
                                        </label>
                                        <input type="Number" class="form-control" placeholder="Year" name="tbl_year">
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
                                            Is this election required a Party-List?
                                        </label>
                                        <select class="form-control" name="required_partylist">
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
                                                    <a href="{{ route('subadmin.vote.action', [

                                                        'id' => $key->id,
                                                        'status' => $key->status

                                                    ]) }}" class="btn btn-success btn-sm">
                                                        <i class="fa fa-circle text-white"></i> Start
                                                    </a>
                                                @elseif($key->status == 'started')
                                                    <a href="#" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#myModal">
                                                        <i class="fa fa-circle text-white"></i> Finish
                                                    </a>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="myModalLabel">Finish the voting session?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('subadmin.vote.action') }}" method="get">
                <div class="modal-body">
                    <input type="hidden" name="id" value="{{ $key->id }}">
                    <input type="hidden" name="status" value="{{ $key->status }}">
                    <div style="text-align:left" class="mb-3">Message</div>
                    <textarea required class="form-control" name="message" placeholder="Enter Message"></textarea>
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

                                                    <a href="{{route('subadmin.to_result')}}" class="btn btn-success btn-sm">
                                                        View Result
                                                    </a>

                                                @endif

                                                <a class="btn btn-primary btn-sm" data-toggle="modal"  data-target="#items{{$key->id}}">
                                                    <i class="fa fa-eye text-light"></i>
                                                </a>
                                                <a href="#" class="btn btn-success btn-sm" data-toggle="modal" data-target="#update{{$key->id}}">
                                                <i class="fa fa-edit"></i>
                                                 </a>
                                                <a href="{{ route('subadmin.action.delete.candidates', [ 'id' => $key->id ]) }}" class="btn btn-danger btn-sm" title="delete">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>

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


</body>

</html>
