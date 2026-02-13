<?php
session_start();
include('../db.php');

$res = "";

// 1. ตรวจสอบว่ามีการส่ง ID หนังสือมาหรือไม่
if (!isset($_GET['id'])) {
    header("Location: list_book.php");
    exit;
}

$B_Id = $_GET['id'];

// 2. ดึงข้อมูลหนังสือเดิม
$stmt_get = $conn->prepare("SELECT * FROM all_book WHERE B_Id = ?");
$stmt_get->bind_param("i", $B_Id);
$stmt_get->execute();
$result = $stmt_get->get_result();
$book = $result->fetch_assoc();

if (!$book) {
    echo "ไม่พบข้อมูลหนังสือ";
    exit;
}

// 3. จัดการการอัปเดตข้อมูล
if (isset($_POST['update_book'])) {
    $B_Name      = $_POST['B_Name'];
    $category_id = $_POST['category_id'];
    $author      = $_POST['author'];
    $publisher   = $_POST['publisher'];
    $year        = $_POST['year'];

    $sql_update = "UPDATE all_book SET B_Name=?, category_id=?, author=?, publisher=?, year=? WHERE B_Id=?";
    $stmt_upd = $conn->prepare($sql_update);
    $stmt_upd->bind_param("sissii", $B_Name, $category_id, $author, $publisher, $year, $B_Id);

    if ($stmt_upd->execute()) {
        $res = "success";
    } else {
        $res = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขข้อมูลหนังสือ | Library</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            background-color: #fdfdfd;
            font-family: 'Segoe UI', Tahoma, sans-serif;
        }

        .wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 90vh;
            padding: 40px 20px;
        }

        .edit-card {
            background: #ffffff;
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 500px;
            box-shadow: 0 15px 35px rgba(231, 84, 128, 0.1);
            border: 1px solid #f5c7cd;
        }

        .edit-card h2 {
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
            border-radius: 12px;
            padding: 12px;
            border: 1px solid #ced4da;
            transition: 0.3s;
        }

        .form-control:focus {
            border-color: #e75480;
            box-shadow: 0 0 0 0.25rem rgba(231, 84, 128, 0.1);
        }

        .btn-update {
            background-color: #e75480;
            color: white;
            border: none;
            padding: 14px;
            border-radius: 12px;
            font-weight: bold;
            width: 100%;
            transition: 0.3s;
            margin-top: 30px;
            font-size: 1.1rem;
        }

        .btn-update:hover {
            background-color: #d64370;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(214, 67, 112, 0.3);
        }

        .btn-back {
            color: #888;
            text-decoration: none;
            display: block;
            text-align: center;
            margin-top: 20px;
            transition: 0.3s;
        }

        .btn-back:hover {
            color: #e75480;
        }

        /* ปรับแต่ง Select2 ให้เข้ากับดีไซน์ */
        .select2-container--default .select2-selection--single {
            height: 50px;
            border-radius: 12px;
            border: 1px solid #ced4da;
            padding-top: 10px;
        }
    </style>
</head>

<body>
    <br><br>

    <?php include 'nav_admin.php'; ?>

    <div class="wrapper">
        <div class="edit-card">
            <h2><i class="fa-solid fa-pen-to-square me-2"></i>แก้ไขข้อมูลหนังสือ</h2>

            <form action="" method="post">
                <label><i class="fa-solid fa-book me-1"></i> ชื่อหนังสือ</label>
                <input type="text" name="B_Name" class="form-control" value="<?php echo htmlspecialchars($book['B_Name']); ?>" required>

                <label><i class="fa-solid fa-tags me-1"></i> หมวดหมู่</label>
                <select name="category_id" id="category_select" class="form-control" required>
                    <?php
                    $cat_query = $conn->query("SELECT * FROM category ORDER BY category_name ASC");
                    while ($row = $cat_query->fetch_assoc()) {
                        $selected = ($row['category_id'] == $book['category_id']) ? "selected" : "";
                        echo "<option value='{$row['category_id']}' $selected>{$row['category_name']}</option>";
                    }
                    ?>
                </select>

                <label><i class="fa-solid fa-user-feather me-1"></i> ผู้แต่ง</label>
                <input type="text" name="author" class="form-control" value="<?php echo htmlspecialchars($book['author']); ?>" required>

                <label><i class="fa-solid fa-building me-1"></i> สำนักพิมพ์</label>
                <input type="text" name="publisher" class="form-control" value="<?php echo htmlspecialchars($book['publisher']); ?>" required>

                <label><i class="fa-regular fa-calendar-days me-1"></i> ปีที่พิมพ์</label>
                <input type="number" name="year" class="form-control" min="1900" max="2100" value="<?php echo $book['year']; ?>" required>

                <button type="submit" name="update_book" class="btn btn-update">
                    <i class="fa-solid fa-floppy-disk me-1"></i> บันทึกการเปลี่ยนแปลง
                </button>

                <a href="list_book.php" class="btn-back"><i class="fa-solid fa-chevron-left me-1"></i> ยกเลิกและกลับหน้าหลัก</a>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#category_select').select2({
                width: '100%'
            });

            <?php if ($res == "success"): ?>
                Swal.fire({
                    icon: 'success',
                    title: 'อัปเดตเรียบร้อย!',
                    text: 'ข้อมูลหนังสือถูกแก้ไขเรียบร้อยแล้วค่ะ',
                    confirmButtonColor: '#e75480'
                }).then(() => {
                    window.location.href = 'list_book.php';
                });
            <?php elseif ($res == "error"): ?>
                Swal.fire({
                    icon: 'error',
                    title: 'เกิดข้อผิดพลาด',
                    text: 'ไม่สามารถบันทึกข้อมูลได้ โปรดลองอีกครั้ง',
                    confirmButtonColor: '#e75480'
                });
            <?php endif; ?>
        });
    </script>

</body>

</html>