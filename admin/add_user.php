<?php
session_start();
include('../db.php');

$res = "";

if (isset($_POST['add_user'])) {
    $U_Email     = $_POST['U_Email'];
    $U_Fullname  = $_POST['U_Fullname'];
    $U_Phone     = $_POST['U_Phone'];
    $U_Password  = $_POST['U_Password'];
    $U_Password1 = $_POST['U_Password1'];
    $U_Status    = $_POST['U_Status'];

    if ($U_Password !== $U_Password1) {
        $res = "pass_mismatch";
    } else {
        $stmt_check = $conn->prepare("SELECT U_Email FROM user WHERE U_Email = ?");
        $stmt_check->bind_param("s", $U_Email);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();

        if ($result_check->num_rows > 0) {
            $res = "email_exists";
        } else {
            // แนะนำให้ใช้ password_hash ในอนาคตเพื่อความปลอดภัยที่สูงขึ้นครับ
            $sql = "INSERT INTO user (U_Email, U_Fullname, U_Phone, U_Password, U_Status) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssi", $U_Email, $U_Fullname, $U_Phone, $U_Password, $U_Status);

            if ($stmt->execute()) {
                $res = "success";
            } else {
                $res = "error";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เพิ่มผู้ใช้ใหม่ | Library System</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" type="image/png" href="../logo/logopank.png">
    <style>
        body {
            background-color: #fdfdfd;
            font-family: 'Segoe UI', Tahoma, sans-serif;
        }

        .wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 60px 20px;
        }

        .register-card {
            background: #ffffff;
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 500px;
            box-shadow: 0 15px 35px rgba(231, 84, 128, 0.1);
            border: 1px solid #f5c7cd;
        }

        .register-card h2 {
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

        .btn-save {
            background-color: #e75480;
            color: white;
            border: none;
            padding: 14px;
            border-radius: 12px;
            font-weight: bold;
            width: 100%;
            transition: 0.3s;
            margin-top: 25px;
            font-size: 1.1rem;
        }

        .btn-save:hover {
            background-color: #d64370;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(214, 67, 112, 0.3);
        }

        .btn-reset {
            background-color: #f8f9fa;
            color: #666;
            border: 1px solid #ddd;
            padding: 14px;
            border-radius: 12px;
            font-weight: bold;
            width: 100%;
            transition: 0.3s;
            margin-top: 10px;
        }

        .btn-reset:hover {
            background-color: #eee;
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
    </style>
</head>

<body>

    <?php include 'nav_admin.php'; ?>

    <div class="wrapper">
        <div class="register-card">
            <h2><i class="fa-solid fa-user-plus me-2"></i>เพิ่มผู้ใช้ใหม่</h2>

            <form action="" method="post">
                <label><i class="fa-solid fa-envelope me-1"></i> อีเมล (Email)</label>
                <input type="email" name="U_Email" class="form-control" placeholder="example@mail.com" required>

                <label><i class="fa-solid fa-id-card me-1"></i> ชื่อ-นามสกุล</label>
                <input type="text" name="U_Fullname" class="form-control" placeholder="ระบุชื่อจริง-นามสกุล" required>

                <label><i class="fa-solid fa-phone me-1"></i> เบอร์โทรศัพท์</label>
                <input type="text" name="U_Phone" class="form-control" placeholder="08x-xxx-xxxx" required>

                <div class="row">
                    <div class="col-md-6">
                        <label><i class="fa-solid fa-lock me-1"></i> รหัสผ่าน</label>
                        <input type="password" name="U_Password" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label><i class="fa-solid fa-shield-check me-1"></i> ยืนยันรหัส</label>
                        <input type="password" name="U_Password1" class="form-control" required>
                    </div>
                </div>

                <label><i class="fa-solid fa-user-tag me-1"></i> สถานะผู้ใช้</label>
                <select name="U_Status" class="form-select" required>
                    <option value="">-- เลือกสถานะ --</option>
                    <option value="0">แอดมิน (Admin)</option>
                    <option value="1">ครู (Teacher)</option>
                </select>

                <button type="submit" name="add_user" class="btn-save">
                    <i class="fa-solid fa-cloud-arrow-up me-1"></i> บันทึกข้อมูล
                </button>

                <button type="reset" class="btn-reset">
                    <i class="fa-solid fa-rotate-left me-1"></i> ล้างค่า
                </button>

                <a href="list.php" class="btn-back"><i class="fa-solid fa-chevron-left me-1"></i> กลับหน้าจัดการผู้ใช้</a>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var resStatus = "<?php echo $res; ?>";

            if (resStatus === "success") {
                Swal.fire({
                    icon: 'success',
                    title: 'สำเร็จ!',
                    text: 'เพิ่มผู้ใช้เข้าสู่ระบบเรียบร้อยแล้วค่ะ',
                    confirmButtonColor: '#e75480',
                }).then(() => {
                    window.location.href = 'list.php';
                });
            } else if (resStatus === "pass_mismatch") {
                Swal.fire({
                    icon: 'warning',
                    title: 'รหัสผ่านไม่ตรงกัน',
                    text: 'กรุณาตรวจสอบรหัสผ่านทั้งสองช่องอีกครั้ง',
                    confirmButtonColor: '#e75480',
                });
            } else if (resStatus === "email_exists") {
                Swal.fire({
                    icon: 'error',
                    title: 'อีเมลนี้ถูกใช้แล้ว',
                    text: 'มีผู้ใช้รายอื่นใช้อีเมลนี้แล้ว กรุณาเปลี่ยนใหม่นะคะ',
                    confirmButtonColor: '#e75480',
                });
            } else if (resStatus === "error") {
                Swal.fire({
                    icon: 'error',
                    title: 'เกิดข้อผิดพลาด',
                    text: 'ไม่สามารถเพิ่มข้อมูลได้ กรุณาติดต่อแอดมินระบบ',
                    confirmButtonColor: '#e75480',
                });
            }
        });
    </script>
</body>

</html>