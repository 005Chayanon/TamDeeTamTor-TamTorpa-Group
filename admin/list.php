<?php
session_start();
include('../db.php');

// ตรวจสอบการลบข้อมูล
if (isset($_GET['delete_confirm'])) {
    $U_Id = $_GET['U_Id'];
    $sql = "DELETE FROM user WHERE U_Id ='$U_Id'";
    if ($conn->query($sql)) {
        $delete_success = true;
    }
}
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการรายชื่อผู้ใช้ | Library Admin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

        .container-custom {
            padding: 40px 20px;
            max-width: 1100px;
            margin: auto;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .page-header h2 {
            color: #e75480;
            font-weight: bold;
            margin: 0;
        }

        .table-card {
            background: #fff;
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 10px 30px rgba(231, 84, 128, 0.08);
            border: 1px solid #f5c7cd;
        }

        .table {
            vertical-align: middle;
        }

        .table thead th {
            background-color: #fff;
            color: #888;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            border-bottom: 2px solid #f8f9fa;
            padding: 15px;
        }

        .table tbody td {
            padding: 15px;
            border-bottom: 1px solid #f8f9fa;
            color: #444;
        }

        /* การตกแต่งสถานะ */
        .badge-status {
            padding: 6px 12px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.8rem;
        }

        .bg-admin {
            background-color: #fff0f3;
            color: #e75480;
            border: 1px solid #f5c7cd;
        }

        .bg-teacher {
            background-color: #eef2ff;
            color: #4f46e5;
            border: 1px solid #e0e7ff;
        }

        /* ปุ่มจัดการ */
        .btn-action {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: 0.3s;
            margin: 0 2px;
        }

        .btn-edit-ui {
            background-color: #fff4e5;
            color: #ef6c00;
            border: 1px solid #ffe0b2;
        }

        .btn-edit-ui:hover {
            background-color: #ef6c00;
            color: #fff;
        }

        .btn-delete-ui {
            background-color: #fff0f0;
            color: #d32f2f;
            border: 1px solid #ffcdd2;
        }

        .btn-delete-ui:hover {
            background-color: #d32f2f;
            color: #fff;
        }
    </style>
</head>

<body>
    <?php include 'nav_admin.php'; ?>

    <div class="container-custom mt-5">
        <div class="page-header">
            <h2><i class="fa-solid fa-users-gear me-2"></i>รายชื่อผู้ใช้งานระบบ</h2>
            <a href="add_user.php" class="btn btn-primary" style="background-color: #e75480; border: none; border-radius: 10px; padding: 10px 20px;">
                <i class="fa-solid fa-user-plus me-1"></i> เพิ่มผู้ใช้ใหม่
            </a>
        </div>

        <div class="table-card">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>ชื่อ-นามสกุล</th>
                            <th>ติดต่อ</th>
                            <th>ระดับสิทธิ์</th>
                            <th class="text-center">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM user ORDER BY U_Id DESC";
                        $result = $conn->query($sql);
                        while ($rs = $result->fetch_assoc()) {
                            // กำหนดคลาสและป้ายกำกับตามสถานะผู้ใช้
                            if ($rs['U_Status'] == 0) {
                                $status_class = 'bg-admin';
                                $status_label = 'ผู้ดูแลระบบ';
                            } else {
                                $status_class = 'bg-teacher';
                                $status_label = 'ครูผู้สอน';
                            }
                        ?>
                            <tr>
                                <td class="fw-bold text-secondary">#<?php echo $rs['U_Id']; ?></td>
                                <td>
                                    <div class="fw-bold"><?php echo htmlspecialchars($rs['U_Fullname']); ?></div>
                                    <small class="text-muted"><?php echo htmlspecialchars($rs['U_Email']); ?></small>
                                </td>
                                <td><i class="fa-solid fa-phone-flip text-muted me-1" style="font-size: 0.8rem;"></i> <?php echo $rs['U_Phone']; ?></td>
                                <td>
                                    <span class="badge-status <?php echo $status_class; ?>">
                                        <i class="fa-solid <?php echo ($rs['U_Status'] == 0) ? 'fa-user-shield' : 'fa-user-graduate'; ?> me-1"></i>
                                        <?php echo $status_label; ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="edit_info.php?U_Id=<?php echo $rs['U_Id']; ?>" class="btn-action btn-edit-ui" title="แก้ไข">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <a href="?delete_confirm&U_Id=<?php echo $rs['U_Id']; ?>" class="btn-action btn-delete-ui btn-delete" title="ลบ">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // ยืนยันการลบด้วย SweetAlert2
        $('.btn-delete').on('click', function(e) {
            e.preventDefault();
            const href = $(this).attr('href');

            Swal.fire({
                title: 'ยืนยันการลบ?',
                text: "ข้อมูลผู้ใช้นี้จะถูกลบออกจากระบบอย่างถาวร",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d32f2f',
                cancelButtonColor: '#888',
                confirmButtonText: 'ใช่, ลบเลย',
                cancelButtonText: 'ยกเลิก',
                borderRadius: '15px'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = href;
                }
            })
        });

        // แสดงแจ้งเตือนเมื่อลบสำเร็จ
        <?php if (isset($delete_success)): ?>
            Swal.fire({
                title: 'ลบสำเร็จ!',
                text: 'ลบรายชื่อผู้ใช้เรียบร้อยแล้วค่ะ',
                icon: 'success',
                confirmButtonColor: '#e75480',
                timer: 2000
            }).then(() => {
                window.location.href = 'list.php';
            });
        <?php endif; ?>
    </script>
</body>

</html>