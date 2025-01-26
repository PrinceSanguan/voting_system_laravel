<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>OTP Verification</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
      body, html {
        height: 100%;
        margin: 0;
        font-family: 'Arial', sans-serif;
      }
      .bg-gradient {
        background: linear-gradient(to bottom right, #0062E6, #33AEFF);
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
      }
      .otp-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        padding: 2rem;
        width: 100%;
        max-width: 400px;
      }
      .otp-card h3 {
        color: #333;
        font-weight: 600;
        margin-bottom: 1.5rem;
      }
      .otp-input {
        width: 50px;
        height: 50px;
        font-size: 24px;
        text-align: center;
        border-radius: 8px;
        margin: 5px;
        border: 1px solid #ccc;
        transition: all 0.3s ease;
      }
      .otp-input:focus {
        border-color: #0062E6;
        outline: none;
      }
      .btn-custom {
        background: #0062E6;
        color: white;
        padding: 12px;
        font-size: 16px;
        font-weight: 600;
        border-radius: 8px;
        width: 100%;
        margin-top: 1rem;
        transition: all 0.3s ease;
      }
      .btn-custom:hover {
        background: #33AEFF;
      }
      .text-center a {
        color: #0062E6;
        font-weight: 600;
      }
      .text-center a:hover {
        text-decoration: none;
      }
    </style>
  </head>
  <body>
    <div class="bg-gradient">
      <div class="otp-card card shadow border-0">
        @if(session()->get('response') == '2')
            <div class="alert alert-danger col-12 text-center border-0" style="font-size: 13px">
                {{ session()->get('message') }}
            </div>
        @endif
        <h3 class="text-center">OTP Verification</h3>
        <p class="text-center mb-4">Please enter the 4-digit code sent to your registered phone number.</p>
        <form method="post" action="{{route('verify.otp')}}">
          @csrf
          <input type="hidden" name="id" value="{{ session()->get('id')}}">
          <div class="d-flex justify-content-between">
            <input type="text" class="otp-input" name="otp1" maxlength="1" required>
            <input type="text" class="otp-input" name="otp2" maxlength="1" required>
            <input type="text" class="otp-input" name="otp3" maxlength="1" required>
            <input type="text" class="otp-input" name="otp4" maxlength="1" required>
          </div>
          <button type="submit" class="btn btn-custom">Verify</button>
        </form>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>
