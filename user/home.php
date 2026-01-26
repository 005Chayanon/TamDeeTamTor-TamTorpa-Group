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
    <?php
    session_start();
    include('../db.php');

    include '../nav_user.php';

    ?>
    <br>
    <br>
    <div class="box">
        <table>
            <tr>
                <th>รูปนักเรียนพร้อมหนังสือ</th>
                <th>ชื่อนักเรียน</th>
                <th>รหัสนักเรียน</th>
                <th>ชื่อหนังสือ</th>
                <th>วันยืม</th>
                <th>วันคืน</th>
                <th>แก้ไข</th>
            </tr>
            <tr>
                <?php
                $sql = "select * from history";
                $result = $conn->query($sql);
                while ($rs = $result->fetch_assoc()) {
                ?>
            <tr>
                <td><?php echo $rs['S_photo']; ?></td>
                <td><?php echo $rs['S_Name']; ?></td>
                <td><?php echo $rs['borrow_date']; ?></td>
                <td><?php echo $rs['due_date']; ?></td>
                <td><?php echo $rs['userPassword']; ?></td>
                <td><a href="?delete&userId=<?php echo $rs['userId']; ?>"
                        onclick="return confirm('ลบใช่หรือไม่');">ลบ</a></td>
                <td><a href="edit.php?userId=<?php echo $rs['userId']; ?>">แก้ไข</a></td>
            </tr>
        <?php } ?>
        </tr>
        </table>
</body>

</html>