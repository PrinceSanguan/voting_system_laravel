<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EleVote</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
      body, html {
        height: auto;
      }
      .bg-custom {
        background: #e8edea;
        height: 100%;
      }
      .login-card {
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      }
      .btn-custom:hover {
        background-color: #2575fc;
      }
    </style>
  </head>
  <body>
    
    <div class="container-fluid bg-custom d-flex justify-content-center align-items-center py-5 flex-column">
      @if(session()->has('response'))
          <div class="py-3 text-center alert {{ session()->get('response') == 1 ? 'alert-primary' : 'alert-danger' }}">
              {{ session()->get('message') }}
          </div>
      @endif

      <div class="card login-card p-5 col-md-5 col-sm-8 col-10 rounded-0">
        <h3 class="text-center mb-4">Register</h3>
        <form method="post" action="{{ route('register.voter') }}">
          @csrf
          <div class="mb-3">
            <label for="email" class="form-label">Token</label>
            <input type="text" class="form-control rounded-0" name="fingerprint" placeholder="Enter your unique token" required>
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">First Name</label>
            <input type="text" class="form-control rounded-0" name="first_name" placeholder="Enter your first name" required>
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Middle Name</label>
            <input type="text" class="form-control rounded-0" name="middle_name" placeholder="Enter your middle name" required>
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Last Name</label>
            <input type="text" class="form-control rounded-0" name="last_name" placeholder="Enter your last name" required>
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Age</label>
            <input type="text" class="form-control rounded-0" name="age" placeholder="Enter your Age" required>
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Gender</label>
            <select class="form-control rounded-0" name="gender" required>
              <option value="male">Male</option>
              <option value="female">Female</option>
            </select>
          </div>
          <button type="submit" class="btn btn-primary w-100 text-white my-3 rounded-0">Register</button>
          <div class="text-end ">
                <span class=" fw-semibold"> Already Have An Account?
                  <a href="{{ url('/') }}" class="w-50 text-dark">Login</a>
                </span>
              
          </div>
        </form>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>
