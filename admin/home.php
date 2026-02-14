<?php
session_start();
include('../db.php');

/* ===== ลบรายการ ===== */
if (isset($_GET['delete'], $_GET['H_id'])) {
    $H_id = (int)$_GET['H_id'];
    $conn->query("DELETE FROM history WHERE H_id = $H_id");
    $res = "deleted";
}

/* ===== คืนหนังสือ ===== */
if (isset($_GET['return'], $_GET['H_id'])) {
    $H_id = (int)$_GET['H_id'];
    $conn->query("UPDATE history SET Status01 = 1 WHERE H_id = $H_id");
    $res = "returned";
}

/* ===== ค้นหา ===== */
$search = $_GET['search'] ?? '';
$where = '';
if ($search !== '') {
    $search_safe = $conn->real_escape_string($search);
    $where = " AND (S_Name LIKE '%$search_safe%' OR B_Name LIKE '%$search_safe%' OR B_Id LIKE '%$search_safe%') ";
}
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการยืม-คืนหนังสือ | PankQ Book</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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

        .main-content {
            padding-top: 100px;
            padding-bottom: 50px;
        }

        /* Card & Box Style */
        .content-card {
            background: #fff;
            border-radius: 20px;
            border: none;
            box-shadow: 0 10px 30px rgba(231, 84, 128, 0.1);
            padding: 30px;
        }

        /* Tab Style */
        .nav-tabs {
            border-bottom: 2px solid #f5c7cd;
            margin-bottom: 25px;
        }

        .nav-tabs .nav-link {
            border: none;
            color: #666;
            font-weight: 600;
            padding: 12px 25px;
            border-radius: 12px 12px 0 0;
            transition: 0.3s;
        }

        .nav-tabs .nav-link:hover {
            color: #e75480;
            background: rgba(231, 84, 128, 0.05);
        }

        .nav-tabs .nav-link.active {
            color: #e75480;
            background-color: #fff;
            border-bottom: 3px solid #e75480;
            margin-bottom: -2px;
        }

        /* Table Style */
        .table thead {
            background-color: #fce4ec;
            color: #880e4f;
        }

        .table th {
            border: none;
            padding: 15px;
            font-weight: 600;
        }

        .table td {
            vertical-align: middle;
            padding: 15px;
        }

        .img-preview {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 12px;
            border: 2px solid #f5c7cd;
            transition: 0.3s;
        }

        .img-preview:hover {
            transform: scale(1.1);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        /* Button Style */
        .btn-action {
            border-radius: 8px;
            font-weight: 600;
            padding: 6px 15px;
            transition: 0.3s;
        }

        .btn-confirm {
            background-color: #4caf50;
            color: white;
            border: none;
        }

        .btn-confirm:hover {
            background-color: #388e3c;
        }

        .btn-edit {
            background-color: #ffb74d;
            color: white;
            border: none;
        }

        .btn-delete {
            background-color: #ff5252;
            color: white;
            border: none;
        }

        .badge-borrow {
            background-color: #fff3e0;
            color: #e65100;
            border: 1px solid #ffe0b2;
        }

        .badge-success {
            background-color: #e8f5e9;
            color: #2e7d32;
            border: 1px solid #c8e6c9;
        }

        /* ตกแต่ง Badge สถานะใหม่ให้ดูง่ายขึ้น */
        .status-pill {
            padding: 6px 12px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        /* สีส้มสำหรับกำลังยืม - เน้นให้ดูเด่นว่าต้องติดตาม */
        .status-borrowing {
            background-color: #fff4e5;
            color: #ef6c00;
            border: 1px solid #ffe0b2;
        }

        /* สีเขียวสำหรับคืนแล้ว - ดูสะอาดตาว่าเรียบร้อยแล้ว */
        .status-returned {
            background-color: #e8f5e9;
            color: #2e7d32;
            border: 1px solid #c8e6c9;
        }

        /* เพิ่ม Effect ให้แถวที่ยังไม่คืนมีสีพื้นหลังอ่อนๆ เพื่อให้แยกง่ายขึ้น */
        .row-borrowing {
            background-color: rgba(231, 84, 128, 0.02);
        }
    </style>
</head>

<body>

    <?php include 'nav_admin.php'; ?>

    <div class="container main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold" style="color: #e75480;"><i class="fa-solid fa-clock-rotate-left me-2"></i> ประวัติการยืม-คืน</h2>
            <form class="d-flex" action="" method="get">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="ค้นหาชื่อหรือหนังสือ..." value="<?php echo htmlspecialchars($search); ?>">
                    <button class="btn btn-outline-danger" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                </div>
            </form>
        </div>

        <div class="content-card">
            <ul class="nav nav-tabs" id="borrowTab" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active" id="borrowing-tab" data-bs-toggle="tab" data-bs-target="#borrowing" type="button"><i class="fa-solid fa-hand-holding-heart me-2"></i>กำลังยืม</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" id="returned-tab" data-bs-toggle="tab" data-bs-target="#returned" type="button"><i class="fa-solid fa-circle-check me-2"></i>คืนแล้ว</button>
                </li>
            </ul>

            <div class="tab-content" id="borrowTabContent">
                <div class="tab-pane fade show active" id="borrowing">
                    <?php renderTable($conn, $where, 0); ?>
                </div>
                <div class="tab-pane fade" id="returned">
                    <?php renderTable($conn, $where, 1); ?>
                </div>
            </div>
        </div>
    </div>

    <?php
    function renderTable($conn, $where, $status)
    {
        $sql = "SELECT * FROM history WHERE Status01 = $status $where ORDER BY H_id DESC";
        $result = $conn->query($sql);
    ?>
        <div class="table-responsive mt-2">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th class="text-center">รูปถ่าย</th>
                        <th>ผู้ยืม</th>
                        <th>ข้อมูลหนังสือ</th>
                        <th>วันยืม</th>
                        <th class="text-center">สถานะ</th>
                        <th class="text-center">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0) {
                        while ($rs = $result->fetch_assoc()) { ?>
                            <tr>
                                <td class="text-center">
                                    <img src="../uploads/<?php echo $rs['S_photo']; ?>" class="img-preview" data-bs-toggle="modal" data-bs-target="#imgModal<?php echo $rs['H_id']; ?>" title="คลิกเพื่อดูรูปใหญ่">
                                </td>
                                <td>
                                    <div class="fw-bold text-dark"><?php echo $rs['S_Name']; ?></div>
                                    <small class="text-muted"><i class="fa-solid fa-phone fa-xs"></i> <?php echo $rs['S_Phone']; ?></small>
                                </td>
                                <td>
                                    <div class="text-primary fw-600"><?php echo $rs['B_Name']; ?></div>
                                    <small class="badge bg-light text-dark border">ID: <?php echo $rs['B_Id']; ?></small>
                                </td>
                                <td><small class="text-muted"><?php echo date('d/m/Y H:i', strtotime($rs['H_ts'])); ?></small></td>
                                <td class="text-center">
                                    <?php if ($rs['Status01'] == 0): ?>
                                        <div class="status-pill status-borrowing">
                                            <i class="fa-solid fa-hourglass-half fa-spin"></i> กำลังยืม
                                        </div>
                                    <?php else: ?>
                                        <div class="status-pill status-returned">
                                            <i class="fa-solid fa-circle-check"></i> คืนแล้ว
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <?php if ($rs['Status01'] == 0): ?>
                                            <a class="btn btn-success btn-sm px-3" href="?return=1&H_id=<?php echo $rs['H_id']; ?>"
                                                style="border-radius: 8px; font-weight: 600;">
                                                <i class="fa-solid fa-undo me-1"></i> คืนหนังสือ
                                            </a>
                                        <?php endif; ?>

                                        <a class="btn btn-outline-warning btn-sm" href="editH.php?H_id=<?php echo $rs['H_id']; ?>" style="border-radius: 8px;">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>

                                        <button class="btn btn-outline-danger btn-sm" onclick="confirmDelete(<?php echo $rs['H_id']; ?>)" style="border-radius: 8px;">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <div class="modal fade" id="imgModal<?php echo $rs['H_id']; ?>" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0" style="border-radius: 20px; overflow: hidden;">
                                        <div class="modal-header border-0 bg-white">
                                            <h5 class="modal-title fw-bold text-danger"><?php echo $rs['S_Name'] . " - " . $rs['B_Name']; ?></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body p-0">
                                            <img src="../uploads/<?php echo $rs['S_photo']; ?>" class="w-100">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php }
                    } else { ?>
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">ไม่พบประวัติการยืมในหมวดนี้</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    <?php } ?>

    <script>
        // แสดง SweetAlert ตามสถานะ
        <?php if (isset($res)): ?>
            Swal.fire({
                icon: 'success',
                title: 'สำเร็จ!',
                text: '<?php echo ($res == "returned" ? "คืนหนังสือเรียบร้อยแล้วค่ะ" : "ลบข้อมูลเรียบร้อยแล้ว"); ?>',
                confirmButtonColor: '#e75480',
                timer: 2000
            }).then(() => {
                window.location.href = 'home.php';
            });
        <?php endif; ?>

        function confirmDelete(id) {
            Swal.fire({
                title: 'ยืนยันการลบ?',
                text: "ข้อมูลนี้จะหายไปจากประวัติถาวรนะคะ!",
                icon: 'error',
                showCancelButton: true,
                confirmButtonColor: '#ff5252',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'ใช่, ลบเลย',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '?delete=1&H_id=' + id;
                }
            })
        }
    </script>
</body>

</html>