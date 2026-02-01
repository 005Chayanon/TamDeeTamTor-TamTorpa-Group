<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php include '../nav_user.php'; ?>
    <?php
    include('../db.php');
    $H_id = $_GET['H_id'];
    $sql = "select * from history where H_id ='$H_id' ";

    $result = $conn->query($sql);
    $rs = $result->fetch_assoc();

    if (isset($_POST['edit'])) {
        $S_Name = $_POST['S_Name'];
        $B_Id = $_POST['B_Id'];

        $sql = "update history set S_Name='$S_Name', B_Id='$B_Id' where H_id='$H_id' ";
        if ($conn->query($sql)) {
            echo "<script>alert('แก้ไขข้อมูลสำเร็จ');window.location='home.php';</script>";
        }
    }
    ?>
    <br><br><br><br>
    <h1>แก้ไขข้อมูลการยืมหนังสือ</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <p>ชื่อนักเรียน : <input type="text" name="S_Name" value="<?php echo $rs['S_Name']; ?>" required></p>
        <p>รหัสหนังสือ : <input type="text" name="B_Id" value="<?php echo $rs['B_Id']; ?>" required></p>
        <button type="submit" name="edit" class="btn btn-primary">บันทึกการแก้ไข</button>
    </form>
</body>

</html>