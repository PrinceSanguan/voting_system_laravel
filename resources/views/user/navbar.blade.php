
<nav class="w-100 py-3 bg-grey">
  <div class="text-center fs-2 text-light fw-bold">
   {{ session()->get('organization') }} {{ session()->get('election_year') }} 
   
    Election
  </div>
</nav>
<nav class="navbar bg-body-tertiary">
  <div class="container-fluid d-flex justify-content-lg-between justify-content-md-evenly">
    <button class="btn btn-dark" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
      <i class="fa fa-bars"></i>
    </button>
    @if(session()->get('logout') == 1)
      <a href="{{ route('user.logout') }}" class="btn btn-sm btn-danger">
        <i class="fa-solid fa-right-from-bracket"></i>
      </a>
    @endif
</nav>