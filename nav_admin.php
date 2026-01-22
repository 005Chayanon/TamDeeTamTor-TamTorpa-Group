<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pink Gradient Navbar</title>
  <link href="../bt/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="../bt/dist/js/bootstrap.bundle.min.js"></script>
  <link href="../icon/css/fontawesome.css" rel="stylesheet" />
  <link href="../icon/css/brands.css" rel="stylesheet" />
  <link href="../icon/css/solid.css" rel="stylesheet" />
  <link href="../icon/css/sharp-thin.css" rel="stylesheet" />
  <link href="../icon/css/sharp-duotone-thin.css" rel="stylesheet" />
  <link rel="../icon" type="image/x-icon" href="../Ficon/favicon.ico">
  
<style>
  @font-face {
        font-family: myFirstFont;
        src: url(../font/Mitr-Regular.ttf);
    }
    body{
        font-family: myFirstFont;
    }
    .dropdown {
      position: relative;
      display: inline-block;
    }
    .nav-item{
      color: #fae6e6;
    }
    .dropdown:hover .dropdown-menu {display: block;}
    .dropdown:hover .nav-item {color: #5d2028;}
    .btn-outline{
      color: #fff;
      border-color: #fff;
      background: #8C3843;
    }
    .bu-search:hover .btn-outline {background-color: #edbbbb ; color: #8C3843 ; border-color: #ffffff;}
    .btn-sm{
      color: #fae6e6;
      border-color: #e8c6c6;
      background: #8C3843;
    }
    .bu-add:hover .btn-sm {background-color: #edbbbb ; color: #8C3843 ; border-color: #ffffff;}
    .bu-edit:hover .btn-sm {background-color: #edbbbb ; color: #8C3843 ; border-color: #ffffff;}

    .navbar-toggler{
      height: 45px;
      color: #fff;
      border-color: #ffffff;
      background-color: #8C3843; 
    }
    .toggle:hover .navbar-toggler{background-color: #edbbbb ; color: #8C3843 ; border-color: #ffffff;}

</style>

<body>

  <?php
  
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

  if(isset($_GET['Logout'])){
        session_destroy();
        header('location: ../login.php'); 
  }

  ?>

  
<!-- Navbar Start -->

  <nav class="navbar  fixed-top "  style="background-color: #B1505A;">
    <div class="container-fluid"  style="background-color: #B1505A;">
      <a class="navbar-brand" href="#"  style="color: #ffffff;" > <img src="../logo/logopank.png" style="width: 50px;">  PankQ Book</a>

      <div class="dropdown">
      <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown"  >
            หลักสูตรวิชาการ
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">เทคโนโลยีสารสนเทศ</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">บริหารธุรกิจ</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">การบัญชี</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">การตลาด</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">โลจิสติกส์</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">การท่องเที่ยวและการบริการ</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">ภาษาอังกฤษ</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">ภาษาไทย</a></li>
          </ul>
        </li>
        </div>

        <div class="dropdown">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown"  >
            หมวดหนังสือทั่วไป
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">นวนิยาย</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">วรรณกรรม</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">วิทยาศาสตร์</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">คณิตศาสตร์</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">สังคมศึกษา</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">ประวัติศาสตร์</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">ศิลปะ</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">การออกแบบกราฟิก</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">มนุษยศาสตร์</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">จิตวิทยา</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">การศึกษา</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">สุขภาพ</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">กฎหมายเบื้องต้น</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">การเงินส่วนบุคคล</a></li>
          </ul>
        </li>
        </div>

        <div class="dropdown">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown"  >
            เอกสารของสถาบัน
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">คู่มือนักศึกษา</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">คู่มืออาจารย์</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">เอกสารหลักสูตร</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">เอกสารกิจกรรม</a></li>
          </ul>
        </li>
        </div>

        <div class="dropdown">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown"  >
            สื่อดิจิทัลและโสตทัศน์
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">หนังสืออิเล็กทรอนิกส์</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">วิดีโอการเรียนรู้</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">สื่อโสตทัศน์</a></li>
          </ul>
        </li>
        </div>
      &nbsp;
      <!-- s search bar -->
        <form class="d-flex" role="search">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search"/>
          <div class="bu-search">
            <button class="btn btn-outline" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
          </div>
        </form>
      <!-- End search bar -->

      <div class="d-grid gap-2 d-md-block bu-add">
        <button class="btn  btn-sm" type="button" href="#">เพิ่มรายการยืม-คืน</button>
      </div>
      <div class="d-grid gap-2 d-md-block bu-edit">
       <button class="btn  btn-sm" type="button"href="#">แก้ไขข้อมูล</button>
      </div>

      <!-- s toggle bar -->
      <div class="toggle">
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
          aria-controls="offcanvasNavbar" aria-label="Toggle navigation"  >
        <i class="fa-solid fa-bars"></i>
        </button> 
      </div>
      <!-- End toggle bar -->

      <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel" style="background-color: rgba(238, 208, 216, 0.8);  color: #851f29;" >
        <div class="offcanvas-header"> 
          <h5 class="offcanvas-title" id="offcanvasNavbarLabel"><h1>สวัสดี , <?php  echo htmlspecialchars($user['U_Fullname']); ?> <i class="fa-solid fa-user"></i></h1>
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>

        <div class="offcanvas-body">

          <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
            <li class="nav-item">
              <h5 ><a class="nav-link text-decoration-underline link-offset-2" href="?Logout" onclick = "return confirm('ออกจากระบบ ใช่ หรือ ไม่')" >ออกจากระบบ <i class="fa-solid fa-right-from-bracket"></i> </a></h5>
            </li>
          </ul>

        </div>
      </div>
    </div>
  </nav>
  <!-- Navbar End -->

</body>

</html>