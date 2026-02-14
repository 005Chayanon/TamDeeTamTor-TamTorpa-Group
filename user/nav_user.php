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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" type="image/png" href="../logo/logopank.png">
    <style>
        @font-face {
            font-family: myFirstFont;
            src: url(../font/Mitr-Regular.ttf);
            background-image: url('../img/bg.png');
            background-size: cover;
            background-position: center;
        }

        body {
            font-family: myFirstFont;
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .nav-item {
            color: #fae6e6;
        }

        .dropdown:hover .dropdown-menu {
            display: block;
        }

        .dropdown:hover .nav-item {
            color: #5d2028;
        }

        .btn-outline {
            color: #fff;
            border-color: #fff;
            background: #8C3843;
        }

        .bu-search:hover .btn-outline {
            background-color: #edbbbb;
            color: #8C3843;
            border-color: #ffffff;
        }

        .btn-sm {
            color: #fae6e6;
            border-color: #e8c6c6;
            background: #8C3843;
        }

        .bu-edit:hover .btn-sm {
            background-color: #edbbbb;
            color: #8C3843;
            border-color: #ffffff;
        }

        .navbar-toggler {
            height: 45px;
            color: #fff;
            border-color: #ffffff;
            background-color: #8C3843;
        }

        .toggle:hover .navbar-toggler {
            background-color: #edbbbb;
            color: #8C3843;
            border-color: #ffffff;
        }
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

    if (isset($_GET['Logout'])) {
        // session_start(); <-- ลบบรรทัดนี้ออก เพราะมีข้างบนแล้ว
        session_destroy();
        header('location: ../login.php');
        exit();
    }
    ?>


    <!-- Navbar Start -->

    <nav class="navbar  fixed-top " style="background-color: #B1505A;">
        <div class="container-fluid" style="background-color: #B1505A;">
            <a class="navbar-brand" href="home.php" style="color: #ffffff;"> <img src="../logo/logopank.png" style="width: 50px;"> PankQ Book</a>

            &nbsp;
            &nbsp;
            <!-- s search bar -->
            <form class="d-flex" role="search" style="margin-left: 400px;">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" style="width: 500px;" />
                <div class="bu-search">
                    <button class="btn btn-outline" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                </div>
            </form>
            <!-- End search bar -->

            <div class="d-grid gap-2 d-md-block bu-edit" style="margin-left: 350px;">
                <a type="button" class="btn  btn-sm" type="button" href="b_r.php">เพิ่มรายการยืม-คืน</a>
            </div>

            <!-- s toggle bar -->
            <div class="toggle">
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
                    aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </div>
            <!-- End toggle bar -->

            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel" style="background-color: rgba(238, 208, 216, 0.8);  color: #851f29;">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel">
                        <h3>สวัสดี , <?php echo htmlspecialchars($user['U_Fullname']); ?> <i class="fa-solid fa-user"></i></h3>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>

                <div class="offcanvas-body">

                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                        <li class="nav-item">
                            <h5>
                                <a class="nav-link text-decoration-underline link-offset-2" href="#" id="logout-btn">
                                    ออกจากระบบ <i class="fa-solid fa-right-from-bracket"></i>
                                </a>
                            </h5>
                        </li>
                    </ul>

                </div>
            </div>
        </div>
    </nav>
    <!-- Navbar End -->

    <script>
        document.getElementById('logout-btn').addEventListener('click', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'ยืนยันการออกจากระบบ?',
                text: "คุณต้องการออกจากระบบใช่หรือไม่?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#8C3843', // สีแดงเข้มตามธีมคุณ
                cancelButtonColor: '#edbbbb', // สีชมพูอ่อนตามธีมคุณ
                confirmButtonText: 'ใช่, ออกเลย!',
                cancelButtonText: 'ยกเลิก',
                background: '#fae6e6', // พื้นหลัง Alert สีชมพูจางๆ
                color: '#5d2028', // สีตัวอักษรเข้ม
                customClass: {
                    popup: 'my-swal-font' // ถ้าต้องการเจาะจงฟอนต์
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "../login.php";
                }
            })
        });
    </script>

</body>

</html>