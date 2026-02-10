<?php
session_start();
include('../db.php');

$H_id = $_GET['H_id'];

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

    $sql = "UPDATE history SET S_Name = ?, B_Id = ? WHERE H_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sii", $S_Name, $B_Id, $H_id);

    if ($stmt->execute()) {
        echo "<script>alert('แก้ไขข้อมูลสำเร็จ');location='home.php';</script>";
    } else {
        echo "<script>alert('แก้ไขข้อมูลไม่สำเร็จ');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขข้อมูลการยืมหนังสือ</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <style>
        body {
            background-color: #ffffff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .login-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 80vh;
        }

        .login-box {
            background: linear-gradient(135deg, #ffacb3, #f5c7cd);
            border-radius: 15px;
            padding: 30px 40px;
            width: 420px;
            box-shadow: 0 10px 25px rgba(255, 105, 180, 0.25);
            border: 2px solid #e97f7f;
        }

        .login-box h2 {
            text-align: center;
            color: #e75480;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .login-box input,
        .login-box select {
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #666063;
        }

        .login-box button {
            background-color: #e75480;
            color: #fff;
            border: none;
            padding: 10px 18px;
            border-radius: 8px;
            cursor: pointer;
        }
    </style>

    <script>
        $(document).ready(function() {
            $('.select-book').select2({
                placeholder: "เลือกรหัสหรือชื่อหนังสือ",
                width: '100%'
            });
        });
    </script>
</head>

<body>

<?php include 'nav_admin.php'; ?>

<br><br><br>

<div class="login-wrapper">
    <div class="login-box">
        <h2>แก้ไขข้อมูลการยืม</h2>

        <form action="" method="post">

            <p>ชื่อนักเรียน</p>
            <input type="text" name="S_Name" value="<?php echo $rs['S_Name']; ?>" required>

            <p class="mt-3">รหัสหนังสือ</p>
            <select name="B_Id" class="select-book" required>
                <?php
                $book = $conn->query("SELECT B_Id, B_Name FROM all_book");
                while ($row = $book->fetch_assoc()) {
                    $selected = ($row['B_Id'] == $rs['B_Id']) ? 'selected' : '';
                    echo "<option value='{$row['B_Id']}' $selected>
                            {$row['B_Id']} - {$row['B_Name']}
                          </option>";
                }
                ?>
            </select>

            <div class="mt-4 text-center">
                <button type="submit" name="edit">บันทึกการแก้ไข</button>
                <a href="home.php" class="btn btn-light ms-2">ยกเลิก</a>
            </div>

        </form>
    </div>
</div>

</body>
</html>
