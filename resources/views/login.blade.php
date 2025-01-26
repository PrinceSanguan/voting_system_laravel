<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="{{ asset('Elevotelogo.png') }}" width ="100" height="100">
    <title>EleVote/ Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
      body, html {
        background: linear-gradient(to top left,rgb(122, 168, 199),rgb(202, 166, 98));
        height: 100%;
        margin: 0;
        font-family: 'Arial', sans-serif;
      }
      .bg-gradient {
        background: linear-gradient(to bottom right, #000000, #4f4f4f);
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
      }
      .login-card {
        background:rgb(187, 211, 245);
        border-radius: 12px;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
        padding: 2rem;
        width: 100%;
        max-width: 400px;
      }
      .login-card h3 {
        color: #333;
        font-weight: 600;
      }
      .form-control {
        border: 1px solid #ccc;
        border-radius: 8px;
        padding: 10px;
      }
      .btn-custom {
        background: linear-gradient(to right,rgb(37, 37, 37),rgb(78, 76, 76));
        border: none;
        color: white;
        padding: 10px 20px;
        font-size: 16px;
        font-weight: 600;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
      }
      .btn-custom:hover {
        background: linear-gradient(to right, #555555, #333333);
      }
      .alert-custom {
        font-size: 14px;
        font-weight: 500;
        color: white;
        background:rgb(253, 4, 4);
        border: none;
        border-radius: 8px;
        padding: 10px;
      }
      .login-logo {
        width: 100px;
        height: auto;
        margin-bottom: 1rem;
      }
    </style>
  </head>
  <body>
    <div class="bg-gradient">
      <div class="login-card">
        @if(session()->has('response'))
          <div class="alert-custom mb-3 text-center">
            {{ session()->get('message') }}
          </div>
        @endif
        <div class="text-center">
        <img src="{{ asset('Elevotelogotrans.png') }}" width="100" height="100" class="rounded-circle" alt="">
        
            <h3 class="text-center mb-4">Admin Login</h3>
        </div>
        <form method="post" action="{{ route('LoginVerification') }}">
          @csrf
          <div class="mb-3">
            <label for="email" class="form-label">Username</label>
            <input type="email" class="form-control" name="email" placeholder="Enter your email" required>
          </div>
          <div class="mb-3">
            <label for="pin" class="form-label">Pin</label>
            <input type="password" class="form-control" name="pin" placeholder="Enter your pin" required>
          </div>
          <button type="submit" class="btn btn-custom w-100">Login</button>
        </form>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>
