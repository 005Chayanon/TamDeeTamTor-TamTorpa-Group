<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เข้าสู่ระบบ</title>
    <link href="bt/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="bt/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="csslogin.css">
</head>

<body>
    <h1>เข้าสู่ระบบ</h1>

    <div class="parent">
        <div class="div1">
            <form action="" method="post">
                <p>Email : <input type="email" name="U_Email" required></p>
                <p>รหัสผ่าน : <input type="password" name="U_Password" required></p>
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
            $_SESSION['U_Email'] = $U_Email;
            $_SESSION['userStatus'] = $rs['userStatus'];

            if ($rs['U_Status'] == '0') {
                header("location: admin/home.php");
            } else {
                header("location: user/home.php");
            }
        } else {
    ?> <script>
                alert('รหัสผ่านไม่ตรงกัน กรุณาลองใหม่');
                history.go(-1)
            </script> <?php
                    }
                }
                        ?>

</body>

</html>