<?php
session_start();
include('../db.php');

if (isset($_POST['add_user'])) {

    $U_Email     = $_POST['U_Email'];
    $U_Fullname  = $_POST['U_Fullname'];
    $U_Phone     = $_POST['U_Phone'];
    $U_Password  = $_POST['U_Password'];
    $U_Password1 = $_POST['U_Password1'];
    $U_Status    = $_POST['U_Status'];

    if ($U_Password !== $U_Password1) {
        echo "<script>alert('รหัสผ่านไม่ตรงกัน');history.back();</script>";
        exit;
    }

    // เช็คอีเมลซ้ำ
    $check = $conn->query("SELECT * FROM user WHERE U_Email='$U_Email'");
    if ($check->num_rows > 0) {
        echo "<script>alert('อีเมลซ้ำ กรุณาใช้ใหม่');history.back();</script>";
        exit;
    }

    // เพิ่มผู้ใช้
    $sql = "INSERT INTO user (U_Email, U_Fullname, U_Phone, U_Password, U_Status)
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $U_Email, $U_Fullname, $U_Phone, $U_Password, $U_Status);

    if ($stmt->execute()) {
        echo "<script>alert('เพิ่มผู้ใช้สำเร็จ');location='list.php';</script>";
    } else {
        echo "<script>alert('เพิ่มผู้ใช้ไม่สำเร็จ');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เพิ่มผู้ใช้</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

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
            width: 430px;
            box-shadow: 0 10px 25px rgba(255, 105, 180, 0.25);
            border: 2px solid #e97f7f;
        }

        .login-box h2 {
            text-align: center;
            color: #e75480;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .login-box input,
        .login-box select {
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #666063;
        }

        .login-box button {
            background-color: #e75480;
            color: #fff;
            border: none;
            padding: 10px 18px;
            border-radius: 8px;
            cursor: pointer;
        }
    </style>
</head>

<body>

<?php include 'nav_admin.php'; ?>

<br><br><br><br>

<div class="login-wrapper">
    <div class="login-box">
        <h2>เพิ่มผู้ใช้</h2>

        <form action="" method="post">

            <p>Email</p>
            <input type="email" name="U_Email" required>

            <p class="mt-3">ชื่อ-สกุล</p>
            <input type="text" name="U_Fullname" required>

            <p class="mt-3">เบอร์โทรศัพท์</p>
            <input type="text" name="U_Phone" required>

            <p class="mt-3">รหัสผ่าน</p>
            <input type="password" name="U_Password" required>

            <p class="mt-3">ยืนยันรหัสผ่าน</p>
            <input type="password" name="U_Password1" required>

            <p class="mt-3">สถานะผู้ใช้</p>
            <select name="U_Status" required>
                <option value="">-- เลือกสถานะ --</option>
                <option value="0">แอดมิน</option>
                <option value="1">ครู</option>
            </select>

            <div class="mt-4 text-center">
                <button type="submit" name="add_user">บันทึก</button>
                <button type="reset" class="btn btn-light ms-2">ล้าง</button>
            </div>

        </form>
    </div>
</div>

</body>
</html>
