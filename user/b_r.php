<?php
session_start();
include('../db.php');

if (isset($_POST['submit'])) {
    $B_Id    = $_POST['B_Id'];
    $S_Name  = $_POST['S_Name'];
    $S_Phone = $_POST['S_Phone'];

    // 1. ดึงชื่อหนังสือจาก B_Id
    $sqlBook = "SELECT B_Name FROM all_book WHERE B_Id = ?";
    $stmtBook = $conn->prepare($sqlBook);
    $stmtBook->bind_param("s", $B_Id);
    $stmtBook->execute();
    $resultBook = $stmtBook->get_result();

    if ($resultBook->num_rows == 0) {
        $error_msg = "ไม่พบหนังสือที่ระบุในระบบ";
    } else {
        $rowBook = $resultBook->fetch_assoc();
        $B_Name = $rowBook['B_Name'];

        // 2. จัดการไฟล์รูป
        $file = $_FILES['S_photo'];
        $filename = $file['name'];
        $tmpname  = $file['tmp_name'];
        $filesize = $file['size'];
        $error    = $file['error'];

        $targetdir = "../uploads/";
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $allow = ['jpg', 'jpeg', 'png'];

        if ($error !== 0) {
            $error_msg = "เกิดข้อผิดพลาดในการอัปโหลดไฟล์";
        } elseif (!in_array($ext, $allow)) {
            $error_msg = "กรุณาใช้ไฟล์ภาพ JPG, JPEG หรือ PNG เท่านั้น";
        } elseif ($filesize > 2000000) {
            $error_msg = "ขนาดไฟล์ใหญ่เกินไป (จำกัดไม่เกิน 2MB)";
        } else {
            $newname = uniqid("img_") . "." . $ext;
            $targetfile = $targetdir . $newname;

            if (move_uploaded_file($tmpname, $targetfile)) {
                // 3. บันทึกข้อมูล
                $sql = "INSERT INTO history (B_Name, B_Id, S_Name, S_Phone, S_photo, Status01) VALUES (?, ?, ?, ?, ?, 0)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sssss", $B_Name, $B_Id, $S_Name, $S_Phone, $newname);

                if ($stmt->execute()) {
                    $success = true;
                } else {
                    $error_msg = "ล้มเหลว: " . $conn->error;
                }
            } else {
                $error_msg = "ไม่สามารถบันทึกไฟล์ลงเซิร์ฟเวอร์ได้";
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
    <title>บันทึกการยืมหนังสือ | Library</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

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

        .add-card {
            background: #fff;
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 550px;
            box-shadow: 0 15px 35px rgba(231, 84, 128, 0.1);
            border: 1px solid #f5c7cd;
        }

        .add-card h2 {
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
            transition: 0.3s;
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

        .btn-save {
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

        .btn-save:hover {
            background-color: #d64370;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(214, 67, 112, 0.3);
        }

        .preview-img {
            width: 100%;
            max-height: 200px;
            object-fit: contain;
            border-radius: 12px;
            display: none;
            margin-top: 10px;
            border: 2px dashed #f5c7cd;
            padding: 5px;
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

    <?php include 'nav_user.php'; ?>

    <div class="wrapper">
        <div class="add-card">
            <h2><i class="fa-solid fa-hand-holding-heart me-2"></i>บันทึกการยืม</h2>

            <form action="" method="post" enctype="multipart/form-data">
                <label><i class="fa-solid fa-magnifying-glass me-1"></i> ค้นหาหนังสือ</label>
                <select name="B_Id" class="search-book" required>
                    <option value="">ค้นหาด้วยรหัส หรือ ชื่อหนังสือ...</option>
                    <?php
                    $rsBook = $conn->query("SELECT B_Id, B_Name FROM all_book ORDER BY B_Id DESC");
                    while ($row = $rsBook->fetch_assoc()) {
                        echo "<option value='{$row['B_Id']}'>[{$row['B_Id']}] {$row['B_Name']}</option>";
                    }
                    ?>
                </select>

                <div class="row">
                    <div class="col-md-7">
                        <label><i class="fa-solid fa-user me-1"></i> ชื่อผู้ยืม (นักเรียน)</label>
                        <input type="text" name="S_Name" class="form-control" placeholder="ชื่อ-นามสกุล" required>
                    </div>
                    <div class="col-md-5">
                        <label><i class="fa-solid fa-phone me-1"></i> เบอร์โทรศัพท์</label>
                        <input type="text" name="S_Phone" class="form-control" placeholder="08XXXXXXXX" maxlength="10" required>
                    </div>
                </div>

                <label><i class="fa-solid fa-camera me-1"></i> รูปถ่ายหลักฐาน (พร้อมหนังสือ)</label>
                <input type="file" name="S_photo" id="imgInput" class="form-control" accept="image/*" required>
                <img id="preview" class="preview-img">

                <button type="submit" name="submit" class="btn-save">
                    <i class="fa-solid fa-check-circle me-1"></i> ยืนยันการยืม
                </button>

                <a href="home.php" class="btn-back"><i class="fa-solid fa-chevron-left me-1"></i> กลับไปหน้าประวัติ</a>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // เรียกใช้ Select2
            $('.search-book').select2({
                width: '100%'
            });

            // ระบบแสดงรูปตัวอย่างก่อนอัปโหลด
            $("#imgInput").change(function() {
                const file = this.files[0];
                if (file) {
                    let reader = new FileReader();
                    reader.onload = function(event) {
                        $("#preview").attr("src", event.target.result).fadeIn();
                    };
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>

    <?php
    if (isset($success)) {
        echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'บันทึกสำเร็จ!',
                text: 'ระบบจัดเก็บข้อมูลการยืมเรียบร้อยแล้วค่ะ',
                confirmButtonColor: '#e75480'
            }).then(() => { window.location.href = 'home.php'; });
        </script>";
    }

    if (isset($error_msg)) {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาด',
                text: '$error_msg',
                confirmButtonColor: '#e75480'
            });
        </script>";
    }
    ?>
</body>

</html>