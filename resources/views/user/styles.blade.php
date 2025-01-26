<style type="text/css">
      body {
        background: linear-gradient(to right, #f7f7f7, #e2e2e2);
        font-family: 'Roboto', sans-serif;
      }
      nav {
        background-color: #343a40;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        position: sticky;
        top: 0;
        z-index: 10;
      }
      nav .navbar-brand {
        color: #ffffff;
        font-size: 1.5rem;
        font-weight: bold;
      }
      nav .nav-link {
        color: #ffffff;
        margin-right: 15px;
      }
      nav .nav-link:hover {
        color: #ffca2c;
        transition: color 0.3s ease-in-out;
      }
      .election-title {
        animation: fadeInUp 1.5s ease-in-out;
      }
      .card {
        border-radius: 15px;
        border-top: 5px solid #007bff;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
        transition: transform 0.3s ease-in-out;
      }
      .card:hover {
        transform: scale(1.05);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
      }
      .form-control:focus {
        border-color: #007bff;
        box-shadow: none;
      }
      .btn {
        border-radius: 30px;
        font-weight: bold;
        padding: 12px 24px;
      }
      .btn-primary {
        background: linear-gradient(to right, #007bff, #0056b3);
        border: none;
        box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
        transition: all 0.3s ease-in-out;
      }
      .btn-primary:hover {
        background: linear-gradient(to right, #0056b3, #003d82);
        box-shadow: 0 8px 20px rgba(0, 123, 255, 0.5);
      }
      li{
        list-style-type: none;
      }


       /* Sidebar styling */
      .offcanvas-body {
        background-color: #343a40;
        padding: 1.5rem;
        height: 100%;
      }
      .offcanvas-header {
        background-color: #212529;
        border-bottom: 1px solid #444;
      }
      .offcanvas-body ul {
        padding-left: 0;
      }
      .offcanvas-body li {
        margin-bottom: 1rem;
      }
      .offcanvas-body a {
        display: block;
        padding: 10px 15px;
        background-color: #212529;
        color: #f7f7f7;
        text-decoration: none;
        border-radius: 5px;
        transition: background-color 0.3s, transform 0.3s;
      }
      .offcanvas-body a:hover {
        background-color: #495057;
        color: #ffffff;
        transform: translateX(5px);
      }
      .offcanvas-body a i {
        margin-right: 10px;
      }
      .offcanvas-title {
        font-size: 1.5rem;
        font-weight: bold;
      }

      /* Animations */
      @keyframes fadeInUp {
        from {
          opacity: 0;
          transform: translateY(20px);
        }
        to {
          opacity: 1;
          transform: translateY(0);
        }
      }
    </style>