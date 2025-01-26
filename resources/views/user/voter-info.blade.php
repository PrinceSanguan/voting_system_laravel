<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EleVote</title>
    <link rel="icon" type="image/x-icon" href="{{asset('Elevotelogo.png')}}">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    @include('user.styles')
  </head>
  <body>
    @include('user.navbar')

    @include('user.sidebar')

    <section class="container my-5">
      <!-- {{ session()->get('user_fingerprint') }} {{ session()->get('organization') }} -->
      
      <form method="post" action="{{ route('update-voters-data',  ['voter_id' => $data->id]) }}" class="card shadow-lg p-5">
        @csrf
        <input type="hidden" name="voter_id" value="{{ $data->id }}">
        <div class="form-group position-relative">
  <input type="text" class="form-control" id="editableField" disabled style="padding-left: 10px;">
  <div class="position-absolute" style="top: 50%; left: 10px; transform: translateY(-50%); pointer-events: none; font-size: 0.9rem; color: #6c757d;">
    <strong><span style="color: red;">Note:</strong></span> <span style="color: black;">Only PIN, Address, Year Level, Age, and Phone number can be change/update.</span>
  </div>
</div>

          </div>
        <div class="my-5 text-center h1 fw-bold election-title">My Info</div>
        <div class="row my-3">
          <div class="col-lg-5 my-3">
            <label class="form-label">Last Name</label>
            <input type="text" class="form-control rounded-0 border-1 border-dark" placeholder="" value="{{ $data->last_name }}" name="last_name" readonly>
          </div>
          <div class="col-lg-5 my-3">
            <label class="form-label">First Name</label>
            <input type="text" class="form-control rounded-0 border-1 border-dark" placeholder="Enter your first name" value="{{ $data->first_name }}" name="first_name" readonly>
          </div>
          <div class="col-lg-2 my-3">
            <label class="form-label">Middle Initial</label>
            <input type="text" class="form-control rounded-0 border-1 border-dark" placeholder="" value="{{ $data->middle_name }}" name="middle_name" readonly>
          </div>
        </div>
        <div class="row my-3">
          <div class="col-lg-4 my-3">
            <label class="form-label">Age</label>
            <input type="text" class="form-control rounded-0 border-1 border-dark" placeholder="Enter your updated age" value="{{ $data->age }}" name="age" >
          </div>
          <div class="col-lg-4 my-3">
            <label class="form-label">Gender</label>
            <input type="text" class="form-control rounded-0 border-1 border-dark" placeholder="Enter your gender" value="{{ $data->gender }}" name="gender" Readonly>
          </div>
          <div class="col-lg-4 my-3">
            <label class="form-label">Phone Number</label>
            <input type="text" class="form-control rounded-0 border-1 border-dark" placeholder="Enter your new phone number" value="{{ $data->phone_number }}" name="phone_number">
          </div>
        </div>
        <div class="row my-3">
          
          <div class="col-lg-5 my-3">
            <label class="form-label">Signed Organization</label>
            <input type="text" class="form-control rounded-0 border-1 border-dark" placeholder="Enter organization" value="{{ $data->organization }}" name="organization" readonly>
          </div>
          <div class="col-lg-5 my-3">
            <label class="form-label">Course</label>
            <input type="text" class="form-control rounded-0 border-1 border-dark" placeholder="Enter new Course" value="{{ $data->course}}" name="course" readonly>
          </div>
          <div class="col-lg-5 my-3">
            <label class="form-label">Year Level</label>
            <input type="text" class="form-control rounded-0 border-1 border-dark" placeholder="Enter new Year Level" value="{{ $data->year_lvl }}" name="year_lvl" >
          </div>
          <div class="col-lg-5 my-3">
            <label class="form-label">PIN</label>
            <input type="text" class="form-control rounded-0 border-1 border-dark" placeholder="Enter new PIN" value="{{ $data->pin }}" name="pin" >
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

    @if(session()->has('response'))
    <script type="text/javascript">
        // Show SweetAlert based on the response type
        let response = "{{ session('response') }}";
        let message = "{{ session('message') }}";

        if (response === 'success') {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: message,
            });
        } else if (response === 'failure') {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: message,
            });
        } else if (response === 'voter_not_found') {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: message,
            });
        } else if (response === 'pin_error') {
            Swal.fire({
                icon: 'error',
                title: 'PIN Error',
                text: message,
            });
        }
    </script>
@endif

  </body>
</html>
