<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nexus' E-Voting</title>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    @include('user.styles')
  </head>
  <body>
    @include('user.navbar')

    @include('user.sidebar')

    <section class="container my-5">
      <!-- {{ session()->get('user_fingerprint') }} {{ session()->get('organization') }} -->

      <form method="post" action="{{ route('update-voters-data')}}" class="card shadow-lg p-5">
        @csrf
        <div class="my-5 text-center h1 fw-bold election-title">My Info</div>
        <div class="row my-3">
          <div class="col-lg-5 my-3">
            <label class="form-label">Last Name</label>
            <input type="text" class="form-control rounded-0 border-1 border-dark" placeholder="Enter your last name" value="{{ $data->last_name }}" name="last_name">
          </div>
          <div class="col-lg-5 my-3">
            <label class="form-label">First Name</label>
            <input type="text" class="form-control rounded-0 border-1 border-dark" placeholder="Enter your first name" value="{{ $data->first_name }}" name="first_name">
          </div>
          <div class="col-lg-2 my-3">
            <label class="form-label">Middle Initial</label>
            <input type="text" class="form-control rounded-0 border-1 border-dark" placeholder="Enter middle initial" value="{{ $data->middle_name }}" name="middle_name">
          </div>
        </div>
        <div class="row my-3">
          <div class="col-lg-4 my-3">
            <label class="form-label">Age</label>
            <input type="text" class="form-control rounded-0 border-1 border-dark" placeholder="Enter your age" value="{{ $data->age }}" name="age">
          </div>
          <div class="col-lg-4 my-3">
            <label class="form-label">Gender</label>
            <input type="text" class="form-control rounded-0 border-1 border-dark" placeholder="Enter your gender" value="{{ $data->gender }}" name="gender">
          </div>
          <div class="col-lg-4 my-3">
            <label class="form-label">Phone Number</label>
            <input type="text" class="form-control rounded-0 border-1 border-dark" placeholder="Enter your phone number" value="{{ $data->phone_number }}" name="phone_number">
          </div>
        </div>
        <div class="row my-3">
          <div class="col-lg-7 my-3">
            <label class="form-label">Address</label>
            <input type="text" class="form-control rounded-0 border-1 border-dark" placeholder="Enter your address" value="{{ $data->address }}" name="address">
          </div>
          <div class="col-lg-5 my-3">
            <label class="form-label">Signed Organization</label>
            <input type="text" class="form-control rounded-0 border-1 border-dark" placeholder="Enter organization" value="{{ $data->organization }}" name="organization" readonly>
          </div>
        </div>
        <div class="text-end mt-3">
          <button class="btn btn-primary col-lg-4" type="submit">Save Changes</button>
        </div>
      </form>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if(session()->get('response') == 1)
    <script type="text/javascript">
      Swal.fire({
            icon: "success",
            title: "Success",
            text: "Account Updated. Thank you!"
          });
    </script>
    @elseif(session()->get('response') == 2)
    <script type="text/javascript">
      Swal.fire({
          icon: "error",
          title: "Oops...",
          text: "Something went wrong!",
          confirmButtonText: "Ok",
        });
    </script>
    @endif
  </body>
</html>
