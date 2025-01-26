<nav class="layout-navbar navbar navbar-expand-lg align-items-lg-center bg-white container-p-x" id="layout-navbar">

    <!-- Brand demo (see assets/css/demo/demo.css) -->
    <a href="index.html" class="navbar-brand app-brand demo d-lg-none py-0 mr-4">
        <span class="app-brand-logo demo">
            <img src="{{ asset('Elevotelogo.png') }}" width="50" height="50" class="rounded-circle" alt=""> EleVote
            
        </span>
        <span class="app-brand-text demo font-weight-normal ml-2">Bhumlu</span>
    </a>

    <!-- Sidenav toggle (see assets/css/demo/demo.css) -->
    <div class="layout-sidenav-toggle navbar-nav d-lg-none align-items-lg-center mr-auto">
        <a class="nav-item nav-link px-0 mr-lg-4" href="javascript:">
            <i class="ion ion-md-menu text-large align-middle"></i>
        </a>
    </div>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#layout-navbar-collapse">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="navbar-collapse collapse" id="layout-navbar-collapse">
        <!-- Divider -->
        <hr class="d-lg-none w-100 my-2">

        

        <div class="navbar-nav align-items-lg-center ml-auto">
            <!-- Divider -->
            <div class="nav-item d-none d-lg-block text-big font-weight-light line-height-1 opacity-25 mr-3 ml-1">|</div>
            <div class="demo-navbar-user nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                    <span class="d-inline-flex flex-lg-row-reverse align-items-center align-middle">
                    <img src="{{asset('assets/img/admin.png')}}" alt class="d-block ui-w-30 rounded-circle">
                        <span class="px-1 mr-lg-2 ml-2 ml-lg-0">{{session()->get('Name')}}</span>
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a href="#" data-toggle="modal" class="dropdown-item" data-target="#changepass">
                        Change PIN
                    </a>
                    <a href="{{route('logout')}}" class="dropdown-item">
                        <i class="feather icon-power text-danger"></i> &nbsp; Log Out
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>

<!-- Modal -->
<div class="modal fade" id="changepass" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Change PIN</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('change-pass') }}" method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{ session()->get('id') }}">
                    <div class="modal-body">
                        <div class="my-3">
                            Old PIN<span style="color: red;">*</span> 
                            <input type="password" name="password" placeholder="Enter your old PIN" id="" class="form-control" required>
                        </div>
                        <div class="my-3">
                            New PIN<span style="color: red;">*</span> 
                            <input type="password" name="newpassword" placeholder="Enter your new PIN" id="password" class="form-control" required>
                        </div>
                        <div class="my-3">
                            <span>Confirm PIN<span style="color: red;">*</span> 
                            <input id="confirmpass" onChange="handleConfirmation(this.value)" type="password" placeholder="Confirm PIN" id="" class="form-control" required>
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

<script>
    const handleConfirmation = (value) => {
        let password = document.querySelector("#password").value;
        let confirmpass = document.querySelector('#confirmpass').value;
        
        if (value != password) {
            alert(`Password not matched, please try again`);
            document.querySelector('#confirmpass').value = '';
        }
    }
</script>
@if(session()->has('changed'))
    <script>
        alert(`{{ session()->get('changed_message') }}`);
    </script>
@endif
