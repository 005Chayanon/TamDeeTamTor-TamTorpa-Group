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
        <?php include 'nav_admin.php'; ?>

        <?php
        session_start();
        include('../db.php');

        if (isset($_GET['delete'])) {
            $H_id = $_GET['H_id'];
            $sql = "delete from history where H_id ='$H_id' ";
            $conn->query($sql);
        }


        if (isset($_GET['return'])) {

            $H_id = $_GET['H_id'];

            $sql = "UPDATE history
                SET Status01 = 1
                WHERE H_id = '$H_id'";

            if ($conn->query($sql) === TRUE) {
                header("Location: home.php");
                exit();
            } else {
                echo "เกิดข้อผิดพลาด: " . $conn->error;
            }
        }
        ?>
        <br><br><br><br>
        
        <div class="box">
            <table class="table">
                <tr>
                    <th>รูปนักเรียนพร้อมหนังสือ</th>
                    <th>ชื่อนักเรียน</th>
                    <th>รหัสหนังสือ</th>
                    <th>วันยืม</th>
                    <th>สถานะ</th>
                    <th>การจัดการ</th>
                    <th>ลบรายการ</th>
                </tr>
                <tr>
                    <?php
                    $sql = "select * from history";

                    $result = $conn->query($sql);
                    while ($rs = $result->fetch_assoc()) {
                    ?>
                <tr>
                    <td><img src="../uploads/<?php echo $rs['S_photo']; ?>" width="120"></td>
                    <td><?php echo $rs['S_Name']; ?></td>
                    <td><?php echo $rs['B_Id']; ?></td>
                    <td><?php echo $rs['H_ts']; ?></td>
                    <td>
                        <?php
                        if ($rs['Status01'] == 0) {
                            echo "กำลังยืม";
                        } else {
                            echo "คืนแล้ว";
                        }
                        ?>
                    <td>
                        <?php if ($rs['Status01'] == 0) { ?>
                            <a class="btn btn-success"
                                href="?return=1&H_id=<?php echo $rs['H_id']; ?>">
                                ยืนยันการคืน
                            </a>
                        <?php } else { ?>
                            <span class="text-success">✔ คืนแล้ว</span>
                        <?php } ?>
                        <p></p>
                        <a class="btn btn-warning" href="editH.php?H_id=<?php echo $rs['H_id']; ?>">แก้ไข</a>
                    </td>
                    <td>
                        <!-- Button trigger modal -->
                        <button type="button"
                            class="btn btn-danger"
                            data-bs-toggle="modal"
                            data-bs-target="#deleteModal<?php echo $rs['H_id']; ?>">
                            ลบรายการ
                        </button>
                        <!-- Modal -->
                        <div class="modal fade"
                            id="deleteModal<?php echo $rs['H_id']; ?>"
                            tabindex="-1"
                            aria-hidden="true">

                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">จะลบรายการใช่หรือไม่</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        ⚠️ เมื่อลบแล้วจะไม่สามารถกู้คืนข้อมูลได้
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                                        <a href="?delete=1&H_id=<?php echo $rs['H_id']; ?>"
                                            class="btn btn-danger">
                                            ลบรายการ
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>

                </tr>
            <?php } ?>
            </tr>
            </table>
        </div>
    </body>

    </html>