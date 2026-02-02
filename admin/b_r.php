<?php
session_start();
include('../db.php');

if (isset($_POST['submit'])) {

    $B_Id = $_POST['B_Id'];
    $S_Name = $_POST['S_Name'];
    $S_Phone = $_POST['S_Phone'];

    $filename = $_FILES['S_photo']['name'];
    $tmpname  = $_FILES['S_photo']['tmp_name'];
    $error    = $_FILES['S_photo']['error'];

    $targetdir = "../uploads/";
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    $allow = ['jpg', 'jpeg', 'png'];

    if (!in_array(strtolower($ext), $allow)) {
        alert('ไฟล์ไม่ถูกต้อง');
        exit;
    }

    $newname = uniqid("img_") . "." . $ext;
    $targetfile = $targetdir . $newname;

    if ($error === 0) {
        move_uploaded_file($tmpname, $targetfile);
    }

    $sql = "INSERT INTO history (B_Id, S_Name, S_Phone, S_photo)
            VALUES ('$B_Id', '$S_Name', '$S_Phone', '$newname')";

    if ($conn->query($sql)) {
        echo "<script>alert('เพิ่มข้อมูลเรียบร้อย');location='home.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <style>
        body {
            background-color: #ffffff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .login-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 80vh;
        }

        .login-box {
            background: linear-gradient(135deg, #ffacb3, #f5c7cd);
            border-radius: 15px;
            padding: 30px 40px;
            width: 420px;
            box-shadow: 0 10px 25px rgba(255, 105, 180, 0.25);
            border: 2px solid #e97f7f;
        }

        .login-box h2 {
            text-align: center;
            color: #e75480;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .login-box p {
            margin-bottom: 15px;
            color: #555;
        }

        .login-box input[type="text"],
        .login-box input[type="number"],
        .login-box input[type="file"] {
            background-color: #ffffff;
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #666063;
            outline: none;
            transition: 0.3s;
        }

        .login-box input:focus {
            border-color: #e75480;
            box-shadow: 0 0 5px rgba(231, 84, 128, 0.4);
        }

        .login-box button {
            background-color: #e75480;
            color: #fff;
            border: none;
            padding: 10px 18px;
            border-radius: 8px;
            cursor: pointer;
            margin-right: 10px;
            transition: 0.3s;
        }

        .login-box button:hover {
            background-color: #d9436f;
        }

        .login-box button[type="reset"] {
            background-color: #f6a5c0;
        }

        .login-box button[type="reset"]:hover {
            background-color: #f28bb0;
        }
    </style>

</head>

<body>
    <?php include 'nav_admin.php'; ?>


    <br>
    <br>
    <div class="login-wrapper">
        <div class="login-box">
            <h2>เพิ่มข้อมูลการยืมหนังสือ</h2>
            <p></p>
            <form action="" method="post" enctype="multipart/form-data">
                <p>รหัสหนังสือ : <input type="number" name="B_Id" required></p>
                <p>ชื่อนักเรียน : <input type="text" name="S_Name" required></p>
                <p>เบอร์โทร : <input type="text" name="S_Phone" required></p>
                <p>รูปพร้อมหนังสือ : <input type="file" name="S_photo" required></p>
                <p><button type="submit" name="submit">เพิ่มข้อมูล</button> <button type="reset">ล้าง</button></p>

            </form>
        </div>
    </div>
</body>

</html>