<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="home.css">
</head>

<body>
    <?php include '../nav_admin.php'; ?>

    <?php
    session_start();
    include('../db.php');

    if (isset($_GET['delete'])) {
    $H_id = $_GET['H_id'];
    $sql = "delete from history where H_id ='$H_id' ";
    $conn->query($sql);
}

    ?>
    <br>
    <br>
    <div class="box">
        <table class="table">
            <tr>
                <th>รูปนักเรียนพร้อมหนังสือ</th>
                <th>ชื่อนักเรียน</th>
                <th>รหัสหนังสือ</th>
                <th>วันยืม</th>
                <th>การจัดการ</th>
                <th>ลบรายการ</th>
            </tr>
            <tr>
                <?php
                $sql = "select * from history";

                $result = $conn->query($sql);
                while ($rs = $result->fetch_assoc()) {
                ?>
            <tr>
                <td><img src="../uploads/<?php echo $rs['S_photo']; ?>" width="100"></td>
                <td><?php echo $rs['S_Name']; ?></td>
                <td><?php echo $rs['B_Id']; ?></td>
                <td><?php echo $rs['H_ts']; ?></td>
                <td><a href="edit.php?H_id=<?php echo $rs['H_id']; ?>">แก้ไข</a></td>
                <td><a href="?delete&H_id=<?php echo $rs['H_id']; ?>" onclick="return confirm('ลบใช่หรือไม่');">ลบ</a></td>
            </tr>
        <?php } ?>
        </tr>
        </table>
    </div>

</body>

</html>