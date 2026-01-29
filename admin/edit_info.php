<?php
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
</head>

<body>
    <?php include '../nav_admin.php'; ?>

    <?php
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

    <br>
    <br>
    <br>
    <div class="box">
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
            <input type="submit" name="update" value="บันทึกการเปลี่ยนแปลง">
        </form>
    </div>
</body>

</html>