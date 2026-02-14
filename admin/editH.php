<?php
session_start();
include('../db.php');

$H_id = isset($_GET['H_id']) ? $_GET['H_id'] : null;

if (!$H_id) {
    die("ไม่พบรหัสข้อมูลที่ต้องการแก้ไข");
}

// ดึงข้อมูลเดิม
$sql = "SELECT * FROM history WHERE H_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $H_id);
$stmt->execute();
$result = $stmt->get_result();
$rs = $result->fetch_assoc();

if (isset($_POST['edit'])) {
    $S_Name = $_POST['S_Name'];
    $B_Id   = $_POST['B_Id'];
    $S_Phone = $_POST['S_Phone'];

    // ดึงชื่อหนังสือใหม่ตาม B_Id ที่เลือก
    $sqlBook = "SELECT B_Name FROM all_book WHERE B_Id = ?";
    $stmtB = $conn->prepare($sqlBook);
    $stmtB->bind_param("s", $B_Id);
    $stmtB->execute();
    $resB = $stmtB->get_result();
    $bookData = $resB->fetch_assoc();
    $B_Name = $bookData['B_Name'];

    $sql = "UPDATE history SET S_Name = ?, B_Id = ?, B_Name = ?, S_Phone = ? WHERE H_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $S_Name, $B_Id, $B_Name, $S_Phone, $H_id);

    if ($stmt->execute()) {
        $status = "success";
    } else {
        $status = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขข้อมูลการยืม | Library System</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" type="image/png" href="../logo/logopank.png">
    <style>
        body {
            background-color: #fdfdfd;
            font-family: 'Segoe UI', sans-serif;
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
            margin-bottom: 8px;
            margin-top: 15px;
            display: block;
        }

        .form-control {
            border-radius: 12px;
            padding: 12px;
            border: 1px solid #ced4da;
        }

        .form-control:focus {
            border-color: #e75480;
            box-shadow: 0 0 0 0.25rem rgba(231, 84, 128, 0.1);
        }

        /* ปรับแต่ง Select2 */
        .select2-container--default .select2-selection--single {
            height: 50px;
            border-radius: 12px;
            border: 1px solid #ced4da;
            padding-top: 10px;
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
        }

        .btn-update:hover {
            background-color: #d64370;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(214, 67, 112, 0.3);
        }

        .btn-cancel {
            color: #888;
            text-decoration: none;
            display: block;
            text-align: center;
            margin-top: 20px;
        }

        .btn-cancel:hover {
            color: #e75480;
        }
    </style>
</head>

<body>

    <?php include 'nav_admin.php'; ?>

    <div class="wrapper">
        <div class="edit-card">
            <h2><i class="fa-solid fa-file-pen me-2"></i>แก้ไขการยืม</h2>

            <form action="" method="post">
                <label><i class="fa-solid fa-user me-1"></i> ชื่อผู้ยืม (นักเรียน)</label>
                <input type="text" name="S_Name" class="form-control" value="<?php echo htmlspecialchars($rs['S_Name']); ?>" required>

                <label><i class="fa-solid fa-phone me-1"></i> เบอร์โทรศัพท์</label>
                <input type="text" name="S_Phone" class="form-control" value="<?php echo htmlspecialchars($rs['S_Phone']); ?>" required>

                <label><i class="fa-solid fa-book me-1"></i> หนังสือที่ยืม</label>
                <select name="B_Id" class="select-book" required>
                    <?php
                    $books = $conn->query("SELECT B_Id, B_Name FROM all_book");
                    while ($row = $books->fetch_assoc()) {
                        $selected = ($row['B_Id'] == $rs['B_Id']) ? 'selected' : '';
                        echo "<option value='{$row['B_Id']}' $selected>[{$row['B_Id']}] {$row['B_Name']}</option>";
                    }
                    ?>
                </select>

                <button type="submit" name="edit" class="btn-update w-100">
                    <i class="fa-solid fa-check-double me-1"></i> บันทึกการแก้ไข
                </button>

                <a href="home.php" class="btn-cancel"><i class="fa-solid fa-xmark me-1"></i> ยกเลิก</a>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.select-book').select2({
                width: '100%'
            });

            <?php if (isset($status) && $status == "success"): ?>
                Swal.fire({
                    icon: 'success',
                    title: 'แก้ไขสำเร็จ!',
                    text: 'ข้อมูลการยืมถูกอัปเดตแล้วค่ะ',
                    confirmButtonColor: '#e75480'
                }).then(() => {
                    window.location.href = 'home.php';
                });
            <?php elseif (isset($status) && $status == "error"): ?>
                Swal.fire({
                    icon: 'error',
                    title: 'ผิดพลาด!',
                    text: 'ไม่สามารถบันทึกข้อมูลได้',
                    confirmButtonColor: '#e75480'
                });
            <?php endif; ?>
        });
    </script>

</body>

</html>