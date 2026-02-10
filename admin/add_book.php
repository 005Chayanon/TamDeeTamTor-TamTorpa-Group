<?php
session_start();
include('../db.php');

if (isset($_POST['add_book'])) {

    $B_Name      = $_POST['B_Name'];
    $category_id = $_POST['category_id'];
    $author      = $_POST['author'];
    $publisher   = $_POST['publisher'];
    $year        = $_POST['year'];

    // เช็คชื่อหนังสือซ้ำ
    $check = $conn->query("SELECT * FROM all_book WHERE B_Name='$B_Name'");
    if ($check->num_rows > 0) {
        echo "<script>alert('ชื่อหนังสือซ้ำ');history.back();</script>";
        exit;
    }

    $sql = "INSERT INTO all_book (B_Name, category_id, author, publisher, year)
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sissi", $B_Name, $category_id, $author, $publisher, $year);

    if ($stmt->execute()) {
        echo "<script>alert('เพิ่มหนังสือเรียบร้อย');location='list_book.php';</script>";
    } else {
        echo "<script>alert('เพิ่มข้อมูลไม่สำเร็จ');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เพิ่มหนังสือ</title>

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
            width: 450px;
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
            $('.select2').select2({
                placeholder: "เลือกหมวดหมู่",
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
        <h2>เพิ่มหนังสือ</h2>

        <form action="" method="post">

            <p>ชื่อหนังสือ</p>
            <input type="text" name="B_Name" required>

            <p class="mt-3">หมวดหมู่</p>
            <select name="category_id" class="select2" required>
                <option value=""></option>
                <?php
                $cat = $conn->query("SELECT * FROM category ORDER BY category_name ASC");
                while ($row = $cat->fetch_assoc()) {
                    echo "<option value='{$row['category_id']}'>{$row['category_name']}</option>";
                }
                ?>
            </select>

            <p class="mt-3">ผู้แต่ง</p>
            <input type="text" name="author" required>

            <p class="mt-3">สำนักพิมพ์</p>
            <input type="text" name="publisher" required>

            <p class="mt-3">ปีที่พิมพ์</p>
            <input type="number" name="year" min="1900" max="2100" required>

            <div class="mt-4 text-center">
                <button type="submit" name="add_book">บันทึก</button>
                <button type="reset" class="btn btn-light ms-2">ล้าง</button>
            </div>

        </form>
    </div>
</div>

</body>
</html>
