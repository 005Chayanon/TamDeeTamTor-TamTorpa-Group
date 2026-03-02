<?php
session_start();
include('../db.php');

/* ===== ลบรายการ ===== */
if (isset($_GET['delete'], $_GET['H_id'])) {
    $H_id = (int)$_GET['H_id'];
    $conn->query("DELETE FROM history WHERE H_id = $H_id");
    // รีเฟรชหน้าเพื่อเคลียร์ค่า GET
    header("Location: home.php?status=deleted");
    exit();
}

/* ===== คืนหนังสือ ===== */
if (isset($_GET['return'], $_GET['H_id'])) {
    $H_id = (int)$_GET['H_id'];
    $conn->query("UPDATE history SET Status01 = 1 WHERE H_id = $H_id");
    header("Location: home.php?status=returned");
    exit();
}

?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการยืม-คืนหนังสือ | PankQ Book</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" type="image/png" href="../logo/logopank.png">

    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, sans-serif;
            background-image: url('../img/bg.png');
            background-size: cover;
            background-position: center;
        }

        .main-container {
            padding-top: 100px;
            padding-bottom: 50px;
        }

        .card {
            border-radius: 15px;
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            background: #fff;
        }

        /* แต่งหัวตารางให้เป็นสีชมพูเหมือน list_book */
        .table-thead {
            background-color: #e75480;
            color: white;
        }

        /* ปรับแท็บให้น่ารักเข้ากับธีม */
        .nav-tabs {
            border-bottom: 2px solid #f5c7cd;
            margin-bottom: 20px;
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
        }

        .img-preview {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #ddd;
            cursor: pointer;
            transition: 0.2s;
        }
        
        .img-preview:hover {
            transform: scale(1.1);
        }

        .status-pill {
            padding: 5px 10px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .status-borrowing {
            background-color: #fff4e5;
            color: #ef6c00;
            border: 1px solid #ffe0b2;
        }

        .status-returned {
            background-color: #e8f5e9;
            color: #2e7d32;
            border: 1px solid #c8e6c9;
        }
    </style>
</head>

<body>

    <?php include 'nav_admin.php'; ?>

    <div class="container main-container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold" style="color: #e75480;"><i class="fa-solid fa-clock-rotate-left me-2"></i> ประวัติการยืม-คืน</h2>
            <a href="b_r.php" class="btn btn-primary" style="background-color: #e75480; border: none; border-radius: 10px; padding: 10px 20px;">
                <i class="fa-solid fa-plus me-1"></i> เพิ่มรายการยืม-คืน
            </a>
        </div>

        <div class="card p-4">
            <ul class="nav nav-tabs" id="borrowTab" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active" id="borrowing-tab" data-bs-toggle="tab" data-bs-target="#borrowing" type="button">
                        <i class="fa-solid fa-hourglass-half me-2"></i> กำลังยืม
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" id="returned-tab" data-bs-toggle="tab" data-bs-target="#returned" type="button">
                        <i class="fa-solid fa-circle-check me-2"></i> คืนแล้ว
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="borrowTabContent">
                
                <div class="tab-pane fade show active" id="borrowing" role="tabpanel">
                    <div class="table-responsive">
                        <table id="tableBorrowing" class="table table-hover w-100">
                            <thead class="table-thead">
                                <tr>
                                    <th class="text-center">รูปถ่าย</th>
                                    <th>ผู้ยืม</th>
                                    <th>หนังสือ</th>
                                    <th>วันที่ยืม</th>
                                    <th class="text-center">สถานะ</th>
                                    <th class="text-center">จัดการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql0 = "SELECT * FROM history WHERE Status01 = 0 ORDER BY H_id DESC";
                                $query0 = $conn->query($sql0);
                                while ($rs = $query0->fetch_assoc()) {
                                ?>
                                    <tr>
                                        <td class="text-center">
                                            <img src="../uploads/<?php echo $rs['S_photo']; ?>" class="img-preview" onclick="showImage('../uploads/<?php echo $rs['S_photo']; ?>', '<?php echo addslashes($rs['S_Name']); ?>')">
                                        </td>
                                        <td>
                                            <div class="fw-bold"><?php echo $rs['S_Name']; ?></div>
                                            <small class="text-muted"><i class="fa-solid fa-phone"></i> <?php echo $rs['S_Phone']; ?></small>
                                        </td>
                                        <td>
                                            <div class="text-primary fw-600"><?php echo $rs['B_Name']; ?></div>
                                            <small class="badge bg-light text-dark border">ID: <?php echo $rs['B_Id']; ?></small>
                                        </td>
                                        <td><?php echo date('d/m/Y H:i', strtotime($rs['H_ts'])); ?></td>
                                        <td class="text-center">
                                            <span class="status-pill status-borrowing"><i class="fa-solid fa-clock"></i> กำลังยืม</span>
                                        </td>
                                        <td class="text-center">
                                            <button onclick="confirmReturn(<?php echo $rs['H_id']; ?>)" class="btn btn-sm btn-success text-white mb-1" title="คืนหนังสือ">
                                                <i class="fa-solid fa-undo"></i> คืน
                                            </button>
                                            <a href="editH.php?H_id=<?php echo $rs['H_id']; ?>" class="btn btn-sm btn-outline-warning mb-1" title="แก้ไข">
                                                <i class="fa-solid fa-pen"></i>
                                            </a>
                                            <button onclick="confirmDelete(<?php echo $rs['H_id']; ?>)" class="btn btn-sm btn-outline-danger mb-1" title="ลบ">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="tab-pane fade" id="returned" role="tabpanel">
                    <div class="table-responsive">
                        <table id="tableReturned" class="table table-hover w-100">
                            <thead class="table-thead">
                                <tr>
                                    <th class="text-center">รูปถ่าย</th>
                                    <th>ผู้ยืม</th>
                                    <th>หนังสือ</th>
                                    <th>วันที่ยืม</th>
                                    <th class="text-center">สถานะ</th>
                                    <th class="text-center">จัดการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql1 = "SELECT * FROM history WHERE Status01 = 1 ORDER BY H_id DESC";
                                $query1 = $conn->query($sql1);
                                while ($rs = $query1->fetch_assoc()) {
                                ?>
                                    <tr>
                                        <td class="text-center">
                                            <img src="../uploads/<?php echo $rs['S_photo']; ?>" class="img-preview" onclick="showImage('../uploads/<?php echo $rs['S_photo']; ?>', '<?php echo addslashes($rs['S_Name']); ?>')">
                                        </td>
                                        <td>
                                            <div class="fw-bold"><?php echo $rs['S_Name']; ?></div>
                                            <small class="text-muted"><i class="fa-solid fa-phone"></i> <?php echo $rs['S_Phone']; ?></small>
                                        </td>
                                        <td>
                                            <div class="text-secondary fw-600"><?php echo $rs['B_Name']; ?></div>
                                            <small class="badge bg-light text-dark border">ID: <?php echo $rs['B_Id']; ?></small>
                                        </td>
                                        <td><?php echo date('d/m/Y H:i', strtotime($rs['H_ts'])); ?></td>
                                        <td class="text-center">
                                            <span class="status-pill status-returned"><i class="fa-solid fa-check"></i> คืนแล้ว</span>
                                        </td>
                                        <td class="text-center">
                                            <a href="editH.php?H_id=<?php echo $rs['H_id']; ?>" class="btn btn-sm btn-outline-warning" title="แก้ไข">
                                                <i class="fa-solid fa-pen"></i>
                                            </a>
                                            <button onclick="confirmDelete(<?php echo $rs['H_id']; ?>)" class="btn btn-sm btn-outline-danger" title="ลบ">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            // ตั้งค่า DataTables ทั่วไป (ภาษาไทย, จำนวนแถว)
            var tableOptions = {
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/th.json"
                },
                "pageLength": 10,
                "order": [[ 3, "desc" ]] // เรียงตามวันที่ยืม (col index 3) ล่าสุดก่อน
            };

            // เรียกใช้ DataTable ทั้งสองตาราง
            var tableBorrow = $('#tableBorrowing').DataTable(tableOptions);
            var tableReturn = $('#tableReturned').DataTable(tableOptions);

            // *** แก้ปัญหา DataTable เพี้ยนเมื่ออยู่ใน Tab ที่ซ่อนอยู่ ***
            $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
                $.fn.dataTable.tables({ visible: true, api: true }).columns.adjust();
            });

            // ตรวจสอบสถานะจาก URL เพื่อแสดง Alert
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('status') === 'returned') {
                Swal.fire({
                    icon: 'success',
                    title: 'คืนหนังสือเรียบร้อย',
                    text: 'สถานะถูกปรับปรุงแล้ว',
                    confirmButtonColor: '#e75480',
                    timer: 2000
                });
            } else if (urlParams.get('status') === 'deleted') {
                Swal.fire({
                    icon: 'success',
                    title: 'ลบข้อมูลสำเร็จ',
                    confirmButtonColor: '#e75480',
                    timer: 2000
                });
            }
        });

        // ฟังก์ชันยืนยันการคืน
        function confirmReturn(id) {
            Swal.fire({
                title: 'ยืนยันการคืนหนังสือ?',
                text: "ต้องการเปลี่ยนสถานะเป็น 'คืนแล้ว' ใช่หรือไม่?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ใช่, คืนหนังสือ',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '?return=1&H_id=' + id;
                }
            })
        }

        // ฟังก์ชันยืนยันการลบ
        function confirmDelete(id) {
            Swal.fire({
                title: 'ยืนยันการลบ?',
                text: "ข้อมูลนี้จะหายไปถาวร!",
                icon: 'warning',
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

        // ฟังก์ชันแสดงรูปภาพขนาดใหญ่
        function showImage(src, title) {
            Swal.fire({
                title: title,
                imageUrl: src,
                imageWidth: 400,
                imageAlt: 'Image',
                confirmButtonColor: '#e75480',
                showCloseButton: true,
            });
        }
    </script>

</body>
</html>