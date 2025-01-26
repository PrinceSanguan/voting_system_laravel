<!DOCTYPE html>

<html lang="en" class="material-style layout-fixed">

@include('admin.files.head')
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
                        @if(session()->has('response'))
                            <div class="alert mt-3 {{ session()->get('response') == 1 ? 'alert-primary' : 'alert-danger' }} alert-dismissible fade show">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                {{ session()->get('message') }}
                            </div>
                        @endif
                        <button type="button" class="btn btn-primary my-3" data-toggle="modal" data-target="#exampleModal">
                          <i class="fa fa-plus"></i> Add {{ $label }}
                        </button>
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
                              <form method="post" action="{{ route('add.organization.account') }}">
                                @csrf
                                  <div class="modal-body">

                                    <div class="my-2">
                                        <label class="font-weight-bold">
                                            Organization
                                        </label>
                                        <select class="form-control" name="organization" required>
                                            <option value="">Select Organization here..</option>
                                            @forelse($organization as $organizations)

                                                <option value="{{ $organizations->organization }}">
                                                    {{ $organizations->organization }}
                                                </option>

                                            @empty

                                                <option value="">
                                                    No data Found
                                                </option>

                                            @endforelse
                                        </select>
                                        <!-- <input type="text" class="form-control" placeholder="" name="organization"> -->
                                    </div>

                                    <div class="my-2">
                                        <label class="font-weight-bold">
                                            Name
                                        </label>
                                        
                                        <input required type="text" class="form-control" placeholder="" name="name">
                                    </div>


                                    <div class="my-2">
                                        <label class="font-weight-bold">
                                            Role/Position
                                        </label>
                                        
                                        <input required type="text" class="form-control" placeholder="" name="role">
                                    </div>
                                    <div class="my-2">
                                        <label class="font-weight-bold">
                                            Age
                                        </label>
                                        
                                        <input required type="text" class="form-control" placeholder="" name="age">
                                    </div>
                                    <div class="my-2">
                                        <label class="font-weight-bold">
                                            Gender
                                        </label>
                                        
                                        <input required type="text" class="form-control" placeholder="" name="gender">
                                    </div>
                                    <div class="my-2">
                                        <label class="font-weight-bold">
                                            Username
                                        </label>
                                        <input required type="email" class="form-control" placeholder="" name="email">
                                    </div>
                                    <div class="my-2">
                                        <label class="font-weight-bold">
                                            Pin
                                        </label>
                                        <input required type="password" class="form-control" placeholder="" name="pin">
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
                                        <th class="text-center">#</th>
                                        <th class="text-center">Person In-charge</th>
                                        <th class="text-center">Organization Name</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $count = 1;
                                    @endphp
                                    @foreach($data as $key)
                                    <tr>
                                        <td class="text-center">{{ $count }}</td>
                                        <td class="text-center">{{ $key->name }}</td>
                                        <td class="text-center">{{$key->Organization}}</td>
                                        <td class="text-center">
                                            <a href="#" class="btn btn-success btn-sm" data-toggle="modal" data-target="#update{{$key->id}}">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <a href="{{ route('admin.action.delete', [ 'table' => 'users', 'id' => $key->id ])}}" class="btn btn-sm btn-danger">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @php
                                        $count++
                                    @endphp
                                    @endforeach
                                </tbody>
                            
                            </table>
                            
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
@include('subadmin.files.datatablejs')
</body>

</html>
