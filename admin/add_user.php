<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php include '../nav_admin.php'; ?>

    <?php
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
            VALUES ('$U_Email', '$U_Fullname', '$U_Phone', '$U_Password', '$U_Status')";

        if ($conn->query($sql)) {
            echo "<script>alert('เพิ่มผู้ใช้สำเร็จ');window.location='list.php';</script>";
        }
    }
    ?>
    <br>
    <br>
    <br>
    <h1>เพิ่มผู้ใช้</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <p>Email : <input type="email" name="U_Email" required></p>
        <p>ชื่อ-สกุล : <input type="text" name="U_Fullname" required></p>
        <p>เบอร์โทรศัพท์ : <input type="text" name="U_Phone" required></p>
        <p>รหัสผ่าน : <input type="text" name="U_Password" required></p>
        <p>รหัสผ่าน : <input type="text" name="U_Password1" required></p>
        สถานะ:
        <select name="U_Status">
            <option value="admin" <?php if (['U_Status'] == 'admin') echo 'selected'; ?>>admin</option>
            <option value="user" <?php if (['U_Status'] == 'user') echo 'selected'; ?>>user</option>
        </select><br><br>
        <p><button type="submit" name="add_user">ยืนยัน</button> <button type="reset">ล้าง</button></p>
    </form>

    
</body>

</html>