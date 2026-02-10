<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เข้าสู่ระบบ</title>
    <link href="bt/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="bt/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;600&family=Merriweather:wght@300;400;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="font.css" />
    <link rel="stylesheet" href="login.css" />
    <!-- <link rel="stylesheet" href="font.css"/> -->
</head>

<body>
    <div class="login-wrapper">
        <div class="login-box">
            <h1>เข้าสู่ระบบ</h1>
            <p></p>
            <form action="" method="post">
                <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" name="U_Email">
                    <label for="floatingInput">Email</label>
                </div>
                <div class="form-floating">
                    <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="U_Password">
                    <label for="floatingPassword">Password</label>
                </div>
                <p><button type="submit" name="login">เข้าสู่ระบบ</button></p>
            </form>
        </div>
    </div>

    <?php
    session_start();
    include('db.php');
    #ตรวจสอบว่าพบข้อมูลหรือไม่
    if (isset($_POST['login'])) {
        $U_Email = $_POST['U_Email'];
        $U_Password = $_POST['U_Password'];

        $sql = "select * from user where U_Email ='$U_Email' and U_Password = '$U_Password' ";

        $result  = $conn->query($sql);

        if ($result->num_rows == 1) {
            $rs = $result->fetch_assoc();
            $_SESSION['U_Fullname'] = $rs['U_Fullname'];
            $_SESSION['U_Email'] = $rs['U_Email'];
            $_SESSION['userStatus'] = $rs['userStatus'];

            if ($rs['U_Status'] == '0') {
                header("location: admin/home.php");
            } else {
                header("location: user/home.php");
            }
        } else {
    ?> <script>
                alert('อีเมลหรือรหัสผ่านไม่ถูกต้อง');
                history.go(-1)
            </script> <?php
                    }
                }
                        ?>

</body>

</html>