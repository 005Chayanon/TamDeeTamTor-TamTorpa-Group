<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="b_r.css">
    
</head>

<body>
    <?php include '../nav_admin.php'; ?>

    <?php
    session_start();
    include('../db.php');

    if (isset($_POST['submit'])) {
        $B_Id = $_POST['B_Id'];
        $S_Name = $_POST['S_Name'];
        $S_Phone = $_POST['S_Phone'];

        $targetdir = "uploads/";
        chmod($targetdir, 0777);
        $filename = basename($_FILES["S_photo"]["name"]);
        $targetfile = $targetdir . $filename;
        move_uploaded_file($_FILES["S_photo"]["tmp_name"], $targetfile);


        $sql = "insert into history (B_Id,S_Name,S_Phone,S_photo)
                            values ('$B_Id','$S_Name','$S_Phone','$filename')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>
            alert('เพิ่มข้อมูลเรียบร้อย');
            window.location.href='../b_r_admin/b_r.php';
            </script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    ?>
    <br>
    <br>
    <div class="login-wrapper">
        <div class="login-box">
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