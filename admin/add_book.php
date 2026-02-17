<?php
session_start();
include('../db.php');

$res = "";

if (isset($_POST['add_book'])) {
    $B_Name      = $_POST['B_Name'];
    $category_id = $_POST['category_id'];
    $author      = $_POST['author'];
    $publisher   = $_POST['publisher'];
    $year        = $_POST['year'];

    $stmt_check = $conn->prepare("SELECT B_Name FROM all_book WHERE B_Name = ?");
    $stmt_check->bind_param("s", $B_Name);
    $stmt_check->execute();
    $check = $stmt_check->get_result();

    if ($check->num_rows > 0) {
        $res = "duplicate";
    } else {
        $sql = "INSERT INTO all_book (B_Name, category_id, author, publisher, year) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sissi", $B_Name, $category_id, $author, $publisher, $year);

        if ($stmt->execute()) {
            $res = "success";
        } else {
            $res = "error";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เพิ่มหนังสือใหม่ - Library</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" type="image/png" href="../logo/logopank.png">
    <style>
        body {
            background-color: #fdfdfd;
            font-family: 'Segoe UI', Tahoma, sans-serif;
            background-image: url('../img/bg.png');
            background-size: cover;
            background-position: center;
        }

        .wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 90vh;
            padding: 40px 20px;
        }

        .add-box {
            background: #ffffff;
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 500px;
            box-shadow: 0 15px 35px rgba(231, 84, 128, 0.1);
            border: 1px solid #f5c7cd;
        }

        .add-box h2 {
            text-align: center;
            color: #e75480;
            font-weight: bold;
            margin-bottom: 30px;
        }

        label {
            font-weight: 600;
            color: #555;
            margin-bottom: 5px;
            margin-top: 15px;
            display: block;
        }

        .form-control {
            border-radius: 10px;
            padding: 12px;
            border: 1px solid #ced4da;
            transition: 0.3s;
        }

        .form-control:focus {
            border-color: #e75480;
            box-shadow: 0 0 0 0.25rem rgba(231, 84, 128, 0.15);
        }

        .btn-save {
            background-color: #e75480;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 10px;
            font-weight: bold;
            width: 100%;
            transition: 0.3s;
            margin-top: 25px;
        }

        .btn-save:hover {
            background-color: #d64370;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(214, 67, 112, 0.3);
        }

        .btn-back {
            color: #666;
            text-decoration: none;
            display: block;
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            transition: 0.3s;
        }

        .btn-back:hover {
            color: #e75480;
        }

        /* Custom Select2 Style */
        .select2-container--default .select2-selection--single {
            height: 48px;
            border-radius: 10px;
            border: 1px solid #ced4da;
            padding-top: 10px;
        }
    </style>
</head>

<body>

    <?php include 'nav_admin.php'; ?>

    <div class="wrapper">
        <div class="add-box">
            <h2><i class="fa-solid fa-plus-circle me-2"></i>เพิ่มหนังสือ</h2>

            <form action="" method="post">
                <label><i class="fa-solid fa-book me-1"></i> ชื่อหนังสือ</label>
                <input type="text" name="B_Name" class="form-control" required placeholder="ระบุชื่อหนังสือ">

                <label><i class="fa-solid fa-tags me-1"></i> หมวดหมู่</label>
                <select name="category_id" class="select2" required>
                    <option value=""></option>
                    <?php
                    $cat = $conn->query("SELECT * FROM category ORDER BY category_name ASC");
                    while ($row = $cat->fetch_assoc()) {
                        echo "<option value='{$row['category_id']}'>{$row['category_name']}</option>";
                    }
                    ?>
                </select><br>

                <label><i class="fa-solid fa-circle-plus me-1"></i> ผู้แต่ง</label>
                <input type="text" name="author" class="form-control" required placeholder="ชื่อผู้แต่ง">

                <label><i class="fa-solid fa-building me-1"></i> สำนักพิมพ์</label>
                <input type="text" name="publisher" class="form-control" required placeholder="ชื่อสำนักพิมพ์">

                <label><i class="fa-regular fa-calendar-days me-1"></i> ปีที่พิมพ์</label>
                <input type="number" name="year" class="form-control" min="1900" max="2100" required placeholder="เช่น 2567">

                <button type="submit" name="add_book" class="btn-save">
                    <i class="fa-solid fa-check-circle me-1"></i> ยืนยันการเพิ่มหนังสือ
                </button>
                <a href="home.php" class="btn-back"><i class="fa-solid fa-arrow-left me-1"></i> กลับหน้าหน้าหลัก</a>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "คลิกเพื่อเลือกหมวดหมู่",
                allowClear: true
            });

            <?php if ($res == "success"): ?>
                Swal.fire({
                    icon: 'success',
                    title: 'สำเร็จ!',
                    text: 'เพิ่มหนังสือเข้าห้องสมุดเรียบร้อยแล้ว',
                    confirmButtonColor: '#e75480'
                }).then(() => {
                    window.location.href = 'list_book.php';
                });
            <?php elseif ($res == "duplicate"): ?>
                Swal.fire({
                    icon: 'warning',
                    title: 'ชื่อหนังสือซ้ำ',
                    text: 'หนังสือเล่มนี้มีอยู่ในระบบแล้วค่ะ',
                    confirmButtonColor: '#e75480'
                });
            <?php elseif ($res == "error"): ?>
                Swal.fire({
                    icon: 'error',
                    title: 'เกิดข้อผิดพลาด',
                    text: 'ไม่สามารถเพิ่มข้อมูลได้ โปรดลองอีกครั้ง',
                    confirmButtonColor: '#e75480'
                });
            <?php endif; ?>
        });
    </script>
</body>

</html>