    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>PankQ Book</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="home.css">
    </head>

    <body>

        <?php
        session_start();
        include('../db.php');
        include 'nav_admin.php';

        /* ===== ลบรายการ ===== */
        if (isset($_GET['delete'], $_GET['H_id'])) {
            $H_id = (int)$_GET['H_id'];
            $conn->query("DELETE FROM history WHERE H_id = $H_id");
            echo "<script>alert('ลบรายการแล้ว');location='home.php';</script>";
            exit;
        }

        /* ===== คืนหนังสือ ===== */
        if (isset($_GET['return'], $_GET['H_id'])) {
            $H_id = (int)$_GET['H_id'];
            $conn->query("UPDATE history SET Status01 = 1 WHERE H_id = $H_id");
            echo "<script>alert('คืนหนังสือเรียบร้อย');location='home.php';</script>";
            exit;
        }

        /* ===== ค้นหา ===== */
        $search = $_GET['search'] ?? '';
        $where = '';

        if ($search !== '') {
            $search_safe = $conn->real_escape_string($search);
            $where = "
        WHERE S_Name LIKE '%$search_safe%'
        OR B_Name LIKE '%$search_safe%'
        OR B_Id   LIKE '%$search_safe%'
    ";
        }
        ?>

        <br><br><br><br>

        <div class="box">
            <table class="table table-hover">
                <tr>
                    <th>รูปนักเรียนพร้อมหนังสือ</th>
                    <th>ชื่อนักเรียน</th>
                    <th>ชื่อหนังสือ</th>
                    <th>รหัสหนังสือ</th>
                    <th>วันยืม</th>
                    <th>สถานะ</th>
                    <th>การจัดการ</th>
                    <th>ลบรายการ</th>
                </tr>

                <?php
                $sql = "SELECT * FROM history $where ORDER BY H_id DESC";
                $result = $conn->query($sql);
                while ($rs = $result->fetch_assoc()) {
                ?>
                    <tr>
                        <!-- รูป (กดดูได้) -->
                        <td>
                            <img src="../uploads/<?php echo $rs['S_photo']; ?>"
                                width="120"
                                class="img-thumbnail shadow"
                                style="cursor:pointer"
                                data-bs-toggle="modal"
                                data-bs-target="#photoModal<?php echo $rs['H_id']; ?>">
                        </td>

                        <td><?php echo $rs['S_Name']; ?></td>
                        <td><?php echo $rs['B_Name']; ?></td>
                        <td><?php echo $rs['B_Id']; ?></td>
                        <td><?php echo $rs['H_ts']; ?></td>

                        <!-- สถานะ -->
                        <td>
                            <?php
                            if ($rs['Status01'] == 0) {
                                echo '<span class="badge bg-warning text-dark">กำลังยืม</span>';
                            } else {
                                echo '<span class="badge bg-success">คืนแล้ว</span>';
                            }
                            ?>
                        </td>

                        <!-- จัดการ -->
                        <td>
                            <?php if ($rs['Status01'] == 0) { ?>
                                <a class="btn btn-admin btn-return"
                                    href="?return=1&H_id=<?php echo $rs['H_id']; ?>">
                                    ยืนยันการคืน
                                </a>
                            <?php } else { ?>
                                <div class="text-success mb-1">✔ คืนแล้ว</div>
                            <?php } ?>

                            <a class="btn btn-admin btn-edit"
                                href="editH.php?H_id=<?php echo $rs['H_id']; ?>">
                                แก้ไข
                            </a>
                        </td>

                        <!-- ลบ -->
                        <td>
                            <button type="button"
                                class="btn btn-admin btn-delete"
                                data-bs-toggle="modal"
                                data-bs-target="#deleteModal<?php echo $rs['H_id']; ?>">
                                ลบ
                            </button>
                        </td>
                    </tr>

                    <!-- Modal ดูรูปใหญ่ -->
                    <div class="modal fade"
                        id="photoModal<?php echo $rs['H_id']; ?>"
                        tabindex="-1"
                        aria-hidden="true">

                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content bg-dark text-light">
                                <div class="modal-header border-0">
                                    <h5 class="modal-title">
                                        <?php echo $rs['S_Name']; ?> – <?php echo $rs['B_Name']; ?>
                                    </h5>
                                    <button type="button"
                                        class="btn-close btn-close-white"
                                        data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body text-center">
                                    <img src="../uploads/<?php echo $rs['S_photo']; ?>"
                                        class="img-fluid rounded shadow">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal ลบ -->
                    <div class="modal fade"
                        id="deleteModal<?php echo $rs['H_id']; ?>"
                        tabindex="-1"
                        aria-hidden="true">

                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">ยืนยันการลบ</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">
                                    ⚠️ เมื่อลบแล้วจะไม่สามารถกู้คืนข้อมูลได้
                                </div>

                                <div class="modal-footer">
                                    <button type="button"
                                        class="btn btn-secondary"
                                        data-bs-dismiss="modal">
                                        ยกเลิก
                                    </button>
                                    <a href="?delete=1&H_id=<?php echo $rs['H_id']; ?>"
                                        class="btn btn-danger">
                                        ลบรายการ
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php } ?>
            </table>
        </div>

    </body>

    </html>