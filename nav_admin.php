<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pink Gradient Navbar</title>
  <link href="icon/css/fontawesome.css" rel="stylesheet" />
  <link href="icon/css/brands.css" rel="stylesheet" />
  <link href="icon/css/solid.css" rel="stylesheet" />
  <link href="icon/css/sharp-thin.css" rel="stylesheet" />
  <link href="icon/css/sharp-duotone-thin.css" rel="stylesheet" />
  <link rel="icon" type="image/x-icon" href="Ficon/favicon.ico">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</head>
<style>
  @font-face {
        font-family: myFirstFont;
        src: url(font/Mitr-Regular.ttf);
    }
    body{
        font-family: myFirstFont;
    }
</style>

<body>

  <?php
  /*
  session_start();
  include('../db.php');

  if (!isset($_SESSION['U_Email'])) {
    header("location: ../login.php");
    exit;
  }

  $email = $_SESSION['U_Email'];
  $sql = "SELECT U_Fullname FROM user WHERE U_Email = '$email'";
  $result = $conn->query($sql);
  $user = $result->fetch_assoc();
*/
  ?>

  
<!-- Navbar Start -->

  <nav class="navbar  fixed-top"  style="background-color: #B1505A;">
    <div class="container-fluid"  style="background-color: #B1505A;">
      <a class="navbar-brand" href="#"  style="color: #ffffff;" > <img src="logo/logopank.png" style="width: 50px;">  PankQ Book</a>

      <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
        aria-controls="offcanvasNavbar" aria-label="Toggle navigation"  style="border-color: #ffffff; color: #ffffff; background-color: #EFD8DE ; ">
        <span class="navbar-toggler-icon" style="color: #ffffff;" > </span>
      </button> 

      <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel" style="background-color: rgba(239, 216, 222 ,0.8);  color: #851f29;" >
        <div class="offcanvas-header">
          <h5 class="offcanvas-title" id="offcanvasNavbarLabel"><h1>สวัสดี, <?php /* echo htmlspecialchars($user['U_Fullname']); */?></h1>
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>

        <div class="offcanvas-body">

          <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
            <li class="nav-item">
              <a class="nav-link" href="#">ออกจากระบบ</a>
            </li>
          </ul>

        </div>
      </div>
    </div>
  </nav>
  <!-- Navbar End -->

</body>

</html>