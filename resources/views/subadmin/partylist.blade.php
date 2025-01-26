<!DOCTYPE html>

<html lang="en" class="material-style layout-fixed">

@include('subadmin.files.head')
@include('subadmin.files.datatablecss')

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
                        <div>
                        <div>
                            <!-- HOW TO ADD POSITION Button -->
                            <button type="button" class="btn btn-info my-3" id="howToAddPositionBtn">
    HOW TO ADD PARTYLIST
</button>

<div id="instructionsCard" class="card mt-3"  style="display: none;">
    <div class="card-header bg-primary text-white style" >
        <strong>How to Add, Update, & Delete Partylist</strong>
    </div>
    <div class="card-body">
        <p>
            <span style="color: blue;"><strong>ADD:</strong></span> Click the "+ADD PARTYLIST" button.
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
                                {{ session('message') }}
                            </div>
                        @endif




                        <button type="button" class="btn btn-primary my-3" data-toggle="modal" data-target="#exampleModal">
                          <i class="fa fa-plus"></i> Add {{ $label }}
                        </button>
                        

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
                              <form method="post" action="{{route('add.partylist')}}">
                                @csrf
                                  <div class="modal-body">
                                        <label class="font-weight-bold">
                                            Party List<span style="color: red;">*</span>
                                        </label>
                                        <input type="text" class="form-control" placeholder="Position for Candidates" name="partylist">
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
                                        <th class="text-center">#</th>
                                        <th class="text-center">Position</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $count = 1;
                                    @endphp

                                    @foreach($data as $key)
                                    <tr>
                                        <td  class="text-center">{{ $count }}</td>
                                        <td  class="text-center">{{ $key->partylist }}</td>
                                        <td  class="text-center">
                                        <a href="#" class="btn btn-success btn-sm" data-toggle="modal" data-target="#update{{$key->id}}">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <a href="{{ route('action.delete.partylist', [ 'id' => $key->id ]) }}" class="btn btn-danger btn-sm">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                            
                                            <!-- Modal -->
                                            <div class="modal fade" id="update{{$key->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Update Partylist</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                        <form method="post" action="{{route('update.partylist')}}">
                                                            @csrf
                                                            <input type="hidden" value="{{ $key->id }}" name="id">
                                                            <input type="hidden" value="votingcomponents" name="table">
                                                            <div class="modal-body">
                                                                    <div class="text-left font-weight-bold">
                                                                        Party List<span style="color: red;">*</span>
                                                                    </div>
                                                                    <input value="{{ $key->partylist }}" type="text" class="form-control" placeholder="Position for Candidates" name="partylist">
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
                                            
                                        </td>
                                    </tr>

                                    @php
                                        $count++;
                                    @endphp

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
@include('subadmin.files.datatablejs')
<script>
        document.getElementById('howToAddPositionBtn').addEventListener('click', function () {
            const instructionsCard = document.getElementById('instructionsCard');
            instructionsCard.style.display = instructionsCard.style.display === 'none' ? 'block' : 'none';
        });
    </script>
</body>

</html>
