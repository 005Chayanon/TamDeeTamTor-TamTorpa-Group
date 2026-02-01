<?php
session_start();
include('../db.php');

$U_Id = $_GET['U_Id'];
$sql = "select * from user where U_Id ='$U_Id' ";
$result = $conn->query($sql);
$rs = $result->fetch_assoc();


if (isset($_POST['update'])) {

    $U_Id = $_POST['U_Id'];
    $U_Fullname = $_POST['U_Fullname'];
    $U_Email = $_POST['U_Email'];
    $U_Phone = $_POST['U_Phone'];
    $U_Password = $_POST['U_Password'];
    $U_Status = $_POST['U_Status'];

    $sql = "update user set U_Fullname='$U_Fullname',
                U_Email='$U_Email',
                U_Phone='$U_Phone',
                U_Password='$U_Password',
                U_Status='$U_Status' 
                where U_Id='$U_Id' ";

    if ($conn->query($sql)) {
        header('Location: list.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขข้อมูลผู้ใช้</title>
    <link rel="stylesheet" href="edit_info.css">
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
    <?php include '../nav_admin.php'; ?>
    <br>
    <br>
    <br>
    <div class="login-wrapper">
        <div class="login-box">
            <h2>แก้ไขข้อมูลผู้ใช้</h2>
            <form action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="U_Id" value="<?php echo $rs['U_Id']; ?>">
                ชื่อ-นามสกุล: <input type="text" name="U_Fullname" value="<?php echo $rs['U_Fullname']; ?>"><br><br>
                อีเมล: <input type="email" name="U_Email" value="<?php echo $rs['U_Email']; ?>"><br><br>
                เบอร์โทร: <input type="text" name="U_Phone" value="<?php echo $rs['U_Phone']; ?>"><br><br>
                รหัสผ่าน: <input type="text" name="U_Password" value="<?php echo $rs['U_Password']; ?>"><br><br>
                สถานะ:
                <select name="U_Status">
                    <option value="admin" <?php if ($rs['U_Status'] == 'admin') echo 'selected'; ?>>admin</option>
                    <option value="user" <?php if ($rs['U_Status'] == 'user') echo 'selected'; ?>>user</option>
                </select><br><br>
                <button type="submit" name="update" class="btn btn-success">บันทึกการเปลี่ยนแปลง</button>
            </form>
        </div>
</body>

</html>