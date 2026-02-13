<?php
session_start();
include('../db.php');

// ตรวจสอบความปลอดภัยเบื้องต้น
if (!isset($_GET['U_Id'])) {
    header("Location: list.php");
    exit;
}

$U_Id = $_GET['U_Id'];
$sql = "SELECT * FROM user WHERE U_Id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $U_Id);
$stmt->execute();
$result = $stmt->get_result();
$rs = $result->fetch_assoc();

if (isset($_POST['update'])) {
    $U_Id = $_POST['U_Id'];
    $U_Fullname = $_POST['U_Fullname'];
    $U_Email = $_POST['U_Email'];
    $U_Phone = $_POST['U_Phone'];
    $U_Password = $_POST['U_Password'];
    $U_Status = $_POST['U_Status'];

    $sql_update = "UPDATE user SET U_Fullname=?, U_Email=?, U_Phone=?, U_Password=?, U_Status=? WHERE U_Id=?";
    $stmt_upd = $conn->prepare($sql_update);
    $stmt_upd->bind_param("sssssi", $U_Fullname, $U_Email, $U_Phone, $U_Password, $U_Status, $U_Id);

    if ($stmt_upd->execute()) {
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
    <title>แก้ไขข้อมูลผู้ใช้ | Admin System</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
            max-width: 480px;
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

        .form-control,
        .form-select {
            border-radius: 12px;
            padding: 12px;
            border: 1px solid #ced4da;
            transition: 0.3s;
        }

        .form-control:focus,
        .form-select:focus {
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

        .input-group-text {
            background-color: #fff;
            border-radius: 12px 0 0 12px;
            border-right: none;
            color: #e75480;
        }

        .form-control-with-icon {
            border-radius: 0 12px 12px 0;
        }
    </style>
</head>

<body>
    <?php include 'nav_admin.php'; ?>

    <div class="wrapper">
        <div class="edit-card">
            <h2><i class="fa-solid fa-user-gear me-2"></i>แก้ไขข้อมูลผู้ใช้</h2>

            <form action="" method="post">
                <input type="hidden" name="U_Id" value="<?php echo $rs['U_Id']; ?>">

                <label><i class="fa-solid fa-id-card me-1"></i> ชื่อ-นามสกุล</label>
                <input type="text" name="U_Fullname" class="form-control" value="<?php echo htmlspecialchars($rs['U_Fullname']); ?>" required>

                <label><i class="fa-solid fa-envelope me-1"></i> อีเมล</label>
                <input type="email" name="U_Email" class="form-control" value="<?php echo htmlspecialchars($rs['U_Email']); ?>" required>

                <div class="row">
                    <div class="col-md-6">
                        <label><i class="fa-solid fa-phone me-1"></i> เบอร์โทร</label>
                        <input type="text" name="U_Phone" class="form-control" value="<?php echo htmlspecialchars($rs['U_Phone']); ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label><i class="fa-solid fa-shield-halved me-1"></i> สถานะ</label>
                        <select name="U_Status" class="form-select">
                            <option value="0" <?php if ($rs['U_Status'] == 0) echo 'selected'; ?>>Admin (ผู้ดูแลระบบ)</option>
                            <option value="1" <?php if ($rs['U_Status'] == 1) echo 'selected'; ?>>User (ครูผู้สอน)</option>
                        </select>
                    </div>
                </div>

                <label><i class="fa-solid fa-key me-1"></i> รหัสผ่าน</label>
                <input type="text" name="U_Password" class="form-control" value="<?php echo htmlspecialchars($rs['U_Password']); ?>" required>

                <button type="submit" name="update" class="btn btn-update">
                    <i class="fa-solid fa-floppy-disk me-1"></i> บันทึกการเปลี่ยนแปลง
                </button>

                <a href="list.php" class="btn-back"><i class="fa-solid fa-chevron-left me-1"></i> กลับหน้าจัดการผู้ใช้</a>
            </form>
        </div>
    </div>

    <script>
        <?php if (isset($status) && $status == "success"): ?>
            Swal.fire({
                title: 'อัปเดตสำเร็จ!',
                text: 'แก้ไขข้อมูลผู้ใช้เรียบร้อยแล้วค่ะ',
                icon: 'success',
                confirmButtonColor: '#e75480',
                confirmButtonText: 'กลับหน้าหลัก'
            }).then(() => {
                window.location.href = 'list.php';
            });
        <?php elseif (isset($status) && $status == "error"): ?>
            Swal.fire({
                title: 'เกิดข้อผิดพลาด',
                text: 'ไม่สามารถบันทึกข้อมูลได้ กรุณาลองใหม่อีกครั้ง',
                icon: 'error',
                confirmButtonColor: '#e75480'
            });
        <?php endif; ?>
    </script>
</body>

</html>