<?php
session_start();
include('../db.php');

if (isset($_POST['submit'])) {

    $B_Id    = $_POST['B_Id'];
    $S_Name  = $_POST['S_Name'];
    $S_Phone = $_POST['S_Phone'];

    // ===== ดึงชื่อหนังสือจาก B_Id =====
    $sqlBook = "SELECT B_Name FROM all_book WHERE B_Id = ?";
    $stmtBook = $conn->prepare($sqlBook);
    $stmtBook->bind_param("s", $B_Id);
    $stmtBook->execute();
    $resultBook = $stmtBook->get_result();

    if ($resultBook->num_rows == 0) {
        echo "<script>alert('ไม่พบข้อมูลหนังสือ');</script>";
        exit;
    }

    $rowBook = $resultBook->fetch_assoc();
    $B_Name = $rowBook['B_Name'];

    // ===== จัดการไฟล์รูป =====
    $filename = $_FILES['S_photo']['name'];
    $tmpname  = $_FILES['S_photo']['tmp_name'];
    $error    = $_FILES['S_photo']['error'];

    $targetdir = "../uploads/";
    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    $allow = ['jpg', 'jpeg', 'png'];

    if (!in_array($ext, $allow)) {
        echo "<script>alert('อนุญาตเฉพาะไฟล์ JPG, JPEG, PNG เท่านั้น');</script>";
        exit;
    }

    if ($error !== 0) {
        echo "<script>alert('เกิดข้อผิดพลาดในการอัปโหลดไฟล์');</script>";
        exit;
    }

    $newname = uniqid("img_") . "." . $ext;
    $targetfile = $targetdir . $newname;

    if (!move_uploaded_file($tmpname, $targetfile)) {
        echo "<script>alert('อัปโหลดรูปไม่สำเร็จ');</script>";
        exit;
    }

    // ===== บันทึกข้อมูลลงฐานข้อมูล =====
    $sql = "INSERT INTO history (B_Name, B_Id, S_Name, S_Phone, S_photo)
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $B_Name, $B_Id, $S_Name, $S_Phone, $newname);

    if ($stmt->execute()) {
        echo "<script>alert('เพิ่มข้อมูลเรียบร้อย');location='home.php';</script>";
    } else {
        echo "<script>alert('บันทึกข้อมูลไม่สำเร็จ');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เพิ่มข้อมูลการยืมหนังสือ</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

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

    <script>
        $(document).ready(function() {
            $('.search-book').select2({
                placeholder: "พิมพ์ค้นหารหัสหรือชื่อหนังสือ",
                allowClear: true,
                width: '100%'
            });
        });
    </script>
</head>

<body>
<?php include 'nav_admin.php'; ?>

<br><br><br>

<div class="login-wrapper">
    <div class="login-box">
        <h2>เพิ่มข้อมูลการยืมหนังสือ</h2>

        <form action="" method="post" enctype="multipart/form-data">

            <p>รหัสหนังสือ</p>
            <select name="B_Id" class="search-book" required>
                <option value="">-- เลือกรหัสหนังสือ --</option>
                <?php
                $sqlBook = "SELECT B_Id, B_Name FROM all_book";
                $rsBook = $conn->query($sqlBook);
                while ($row = $rsBook->fetch_assoc()) {
                    echo "<option value='{$row['B_Id']}'>
                        {$row['B_Id']} - {$row['B_Name']}
                    </option>";
                }
                ?>
            </select>

            <p class="mt-3">ชื่อนักเรียน</p>
            <input type="text" name="S_Name" required>

            <p class="mt-3">เบอร์โทร</p>
            <input type="text" name="S_Phone" required>

            <p class="mt-3">รูปพร้อมหนังสือ</p>
            <input type="file" name="S_photo" accept="image/*" required>

            <div class="mt-4 text-center">
                <button type="submit" name="submit">เพิ่มข้อมูล</button>
                <button type="reset" class="btn btn-light ms-2">ล้าง</button>
            </div>

        </form>
    </div>
</div>

</body>
</html>
