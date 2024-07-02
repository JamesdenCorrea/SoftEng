<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CCS EVENT SCHEDULER</title>
  <link href="css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
  <style>
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      user-select: none;
    }
    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }
    .b-example-divider {
      width: 100%;
      height: 3rem;
      background-color: rgba(0, 0, 0, .1);
      border: solid rgba(0, 0, 0, .15);
      border-width: 1px 0;
      box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
    }
    .b-example-vr {
      flex-shrink: 0;
      width: 1.5rem;
      height: 100vh;
    }
    .bi {
      vertical-align: -.125em;
      fill: currentColor;
    }
    .nav-scroller {
      position: relative;
      z-index: 2;
      height: 2.75rem;
      overflow-y: hidden;
    }
    .nav-scroller .nav {
      display: flex;
      flex-wrap: nowrap;
      padding-bottom: 1rem;
      margin-top: -1px;
      overflow-x: auto;
      text-align: center;
      white-space: nowrap;
      -webkit-overflow-scrolling: touch;
    }
    .btn-bd-primary {
      --bd-violet-bg: #712cf9;
      --bd-violet-rgb: 112.520718, 44.062154, 249.437846;

      --bs-btn-font-weight: 600;
      --bs-btn-color: var(--bs-white);
      --bs-btn-bg: var(--bd-violet-bg);
      --bs-btn-border-color: var(--bd-violet-bg);
      --bs-btn-hover-color: var(--bs-white);
      --bs-btn-hover-bg: #6528e0;
      --bs-btn-hover-border-color: #6528e0;
      --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
      --bs-btn-active-color: var(--bs-btn-hover-color);
      --bs-btn-active-bg: #5a23c8;
      --bs-btn-active-border-color: #5a23c8;
    }
    .btn-primary, .btn-secondary {
  background-color: orange !important; /* Maroon color */
  border-color: orange !important; /* Maroon color */
}

.btn-primary:hover, .btn-secondary:hover {
  background-color: #650000 !important; /* Darker maroon for hover effect */
  border-color: #650000 !important; /* Darker maroon for hover effect */
}
    .bd-mode-toggle {
      z-index: 1500;
    }
    .bd-mode-toggle .dropdown-menu .active .bi {
      display: block !important;
    }
    .logo {
      max-width: 100%;
      height: auto;
      width: 300px;
      margin: auto;
    }

    .container {
      max-width: 400px;
      margin: auto;
      padding: 40px 20px;
      background-color: #800000;
      border-radius: 8px;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
      text-align: center;
    }
    body {
      background: url('images/background.jpg') no-repeat center center fixed;
      background-size: 100% 100%;
    }

    .form-signin {
      background-color: rgba(255, 255, 255, 0.9);
      padding: 40px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
  </style>
  <link href="css/sign-in.css" rel="stylesheet">
</head>
<body class="d-flex align-items-center py-4">
  <main class="form-signin w-100 m-auto">
    <form method="POST" action="login.php">
      <div class="text-center mb-4">
        <img src="images/UPHSDALTA.png" alt="CCS logo" class="logo">
      </div>
      <h1 class="h3 mb-3 fw-normal text-center">CCS Admin Login</h1>
      <div class="form-floating">
        <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" name="email" required>
        <label for="floatingInput">Email</label>
      </div>
      <div class="form-floating">
        <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password" required>
        <label for="floatingPassword">Password</label>
      </div>
      <button class="btn btn-primary w-100 py-2" type="submit" name="btnSubmit">Sign in</button>
      <a href="studentloginform.php" class="btn btn-secondary w-100 mt-2" role="button">Student Login</a>
    </form>
  </main>
</body>
</html>