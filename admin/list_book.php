<?php
session_start();
include('../db.php');

// คำสั่งลบข้อมูล (ถ้ามีการส่งค่า id มาลบ)
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $sql_del = "DELETE FROM all_book WHERE B_Id = ?";
    $stmt = $conn->prepare($sql_del);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        header("Location: list_book.php?status=deleted");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายการหนังสือทั้งหมด</title>

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
            padding: 40px 20px;
        }

        .card {
            border-radius: 15px;
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }

        .table-thead {
            background-color: #e75480;
            color: white;
        }

        .btn-add {
            background-color: #e75480;
            color: white;
            border-radius: 8px;
            transition: 0.3s;
        }

        .btn-add:hover {
            background-color: #d64370;
            color: white;
            transform: translateY(-2px);
        }

        .badge-cat {
            background-color: #ffacb3;
            color: #8c3843;
            font-weight: 500;
        }
    </style>
</head>

<body>
    <br><br><br><br>
    <?php include 'nav_admin.php'; ?>

    <div class="container main-container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold" style="color: #e75480;"><i class="fa-solid fa-book"></i> รายการหนังสือทั้งหมด</h2>
            <a href="add_book.php" class="btn btn-add">
                <i class="fa-solid fa-plus-circle"></i> เพิ่มหนังสือใหม่
            </a>
        </div>

        <div class="card p-4">
            <div class="table-responsive">
                <table id="bookTable" class="table table-hover w-100">
                    <thead class="table-thead">
                        <tr>
                            <th class="text-center">รหัส</th>
                            <th>ชื่อหนังสือ</th>
                            <th>หมวดหมู่</th>
                            <th>ผู้แต่ง</th>
                            <th>สำนักพิมพ์</th>
                            <th class="text-center">ปีที่พิมพ์</th>
                            <th class="text-center">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // JOIN ตาราง all_book กับ category
                        $sql = "SELECT all_book.*, category.category_name 
                            FROM all_book 
                            LEFT JOIN category ON all_book.category_id = category.category_id 
                            ORDER BY all_book.B_Id DESC";
                        $query = $conn->query($sql);

                        while ($row = $query->fetch_assoc()):
                        ?>
                            <tr>
                                <td class="text-center"><?php echo $row['B_Id']; ?></td>
                                <td class="fw-bold"><?php echo $row['B_Name']; ?></td>
                                <td><span class="badge badge-cat"><?php echo $row['category_name']; ?></span></td>
                                <td><?php echo $row['author']; ?></td>
                                <td><?php echo $row['publisher']; ?></td>
                                <td class="text-center"><?php echo $row['year']; ?></td>
                                <td class="text-center">
                                    <a href="edit_book.php?id=<?php echo $row['B_Id']; ?>" class="btn btn-sm btn-outline-warning" title="แก้ไข">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <button onclick="confirmDelete(<?php echo $row['B_Id']; ?>)" class="btn btn-sm btn-outline-danger" title="ลบ">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#bookTable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/th.json"
                },
                "pageLength": 10
            });

            // แจ้งเตือนเมื่อลบสำเร็จ
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('status') === 'deleted') {
                Swal.fire('ลบข้อมูลเรียบร้อย!', '', 'success');
            }
        });

        function confirmDelete(id) {
            Swal.fire({
                title: 'ยืนยันการลบหนังสือ?',
                text: "เมื่อลบแล้วจะไม่สามารถย้อนคืนข้อมูลได้!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e75480',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'ใช่, ลบเลย!',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'list_book.php?delete_id=' + id;
                }
            })
        }
    </script>

</body>

</html>