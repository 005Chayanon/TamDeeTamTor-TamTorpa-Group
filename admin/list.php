<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายชื่อผู้ใช้</title>
    <link rel="stylesheet" href="list.css">
</head>

<body>
    <?php include '../nav_admin.php'; ?>

    <?php
    session_start();
    include('../db.php');

    if (isset($_GET['delete_Id'])) {
    $U_Id = $_GET['U_Id'];
    $sql = "delete from user where U_Id ='$U_Id' ";
    $conn->query($sql);
    }
    ?>
    <br><br><br><br>
    <h1>รายชื่อผู้ใช้</h1>
    <div class="box">
        <table class="table">
            <tr>
                <th>รหัสประจำตัว</th>
                <th>ชื่อ-นามสกุล</th>
                <th>อีเมล</th>
                <th>เบอร์โทร</th>
                <th>สถานะ</th>
                <th>การจัดการ</th>
            </tr>
            <tr>
                <?php
                $sql = "select * from user";

                $result = $conn->query($sql);
                while ($rs = $result->fetch_assoc()) {
                ?>
            <tr>
                <td><?php echo $rs['U_Id']; ?></td>
                <td><?php echo $rs['U_Fullname']; ?></td>
                <td><?php echo $rs['U_Email']; ?></td>
                <td><?php echo $rs['U_Phone']; ?></td>
                <td><?php
                    if ($rs['U_Status'] == 0) {
                        echo "แอดมิน";
                    } else {
                        echo "ครู";
                    }
                    ?>
                </td>
                <td><a href="edit_info.php?U_Id=<?php echo $rs['U_Id']; ?>">แก้ไข</a>
                    <a href="?delete_Id&U_Id=<?php echo $rs['U_Id']; ?>" onclick="return confirm('ลบใช่หรือไม่');">ลบ</a>
                </td>
            </tr>
        <?php } ?>
        </tr>
        </table>
    </div>
</body>

</html>