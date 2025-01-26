<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EleVote</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
      body, html {
        height: 100%;
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
    
    <div class="container-fluid bg-custom d-flex justify-content-center align-items-center flex-column">
      @if(session()->has('response'))
          <div class="py-3 text-center alert alert-danger ">
              {{ session()->get('message') }}
          </div>
      @endif
      <div class="card login-card p-5 col-md-4 col-sm-8 col-10 border-0">
        <h3 class="text-center mb-4">Register</h3>
        <form method="post" action="{{ route('reg-admin') }}">
          @csrf
          <div class="mb-3">
            <label for="email" class="form-label">Token</label>
            <input type="text" class="form-control" name="fingerprint" placeholder="Enter your unique token" required>
          </div>
          <button type="submit" class="btn btn-primary w-100 text-white my-3">Register</button>
          <div class="text-end ">
                <span class=" fw-semibold"> Login administrator:
                  <a href="{{ url('admin') }}" class="w-50 text-dark">Login</a>
                </span>
          </div>
        </form>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

  </body>
</html>
