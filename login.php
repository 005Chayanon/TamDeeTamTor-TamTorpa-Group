<?php
session_start();
include('db.php');

$error = false;

if (isset($_POST['login'])) {
    $U_Email = $_POST['U_Email'];
    $U_Password = $_POST['U_Password'];

    // ใช้ Prepared Statement เพื่อความปลอดภัยจากการ SQL Injection
    $stmt = $conn->prepare("SELECT * FROM user WHERE U_Email = ? AND U_Password = ?");
    $stmt->bind_param("ss", $U_Email, $U_Password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $rs = $result->fetch_assoc();
        $_SESSION['U_Fullname'] = $rs['U_Fullname'];
        $_SESSION['U_Email'] = $rs['U_Email'];
        $_SESSION['U_Status'] = $rs['U_Status'];

        if ($rs['U_Status'] == '0') {
            header("location: admin/home.php");
        } else {
            header("location: user/home.php");
        }
        exit();
    } else {
        $error = true;
    }
}
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เข้าสู่ระบบ | Library System</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;600&display=swap" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --primary-pink: #e75480;
            --soft-pink: #f5c7cd;
        }

        body {
            background-image: url("img/kuy.png");
            background-size: 100% auto;
            background-repeat: no-repeat;
            background-position: center top;
            font-family: 'Sarabun', sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }

        .login-container {
            width: 100%;
            max-width: 400px;
            padding: 20px;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 25px;
            padding: 40px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.5);
            text-align: center;
        }

        .login-card h1 {
            color: var(--primary-pink);
            font-weight: 700;
            margin-bottom: 10px;
            font-size: 1.8rem;
        }

        .login-card p.subtitle {
            color: #888;
            font-size: 0.9rem;
            margin-bottom: 30px;
        }

        .form-floating>.form-control {
            border-radius: 12px;
            border: 1px solid #ddd;
        }

        .form-floating>.form-control:focus {
            border-color: var(--primary-pink);
            box-shadow: 0 0 0 0.25rem rgba(231, 84, 128, 0.1);
        }

        .btn-login {
            background-color: var(--primary-pink);
            color: white;
            border: none;
            width: 100%;
            padding: 12px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: 0.3s;
            margin-top: 20px;
        }

        .btn-login:hover {
            background-color: #d64370;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(214, 67, 112, 0.3);
        }

        .icon-box {
            width: 70px;
            height: 70px;
            background: var(--soft-pink);
            color: var(--primary-pink);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            margin: 0 auto 20px;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-card">
            <div class="icon-box">
                <i class="fa-solid fa-book-open-reader"></i>
            </div>
            <h1>เข้าสู่ระบบ</h1>
            <p class="subtitle">ยินดีต้อนรับสู่ PankQ Book System</p>

            <form action="" method="post">
                <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" name="U_Email" required>
                    <label for="floatingInput"><i class="fa-solid fa-envelope me-1"></i> อีเมล</label>
                </div>
                <div class="form-floating mb-4">
                    <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="U_Password" required>
                    <label for="floatingPassword"><i class="fa-solid fa-key me-1"></i> รหัสผ่าน</label>
                </div>

                <button type="submit" name="login" class="btn-login">
                    เข้าสู่ระบบ <i class="fa-solid fa-arrow-right-to-bracket ms-2"></i>
                </button>
            </form>
        </div>
    </div>

    <?php if ($error): ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'เข้าสู่ระบบไม่สำเร็จ',
                text: 'อีเมลหรือรหัสผ่านไม่ถูกต้อง กรุณาลองใหม่อีกครั้งค่ะ',
                confirmButtonColor: '#e75480',
            });
        </script>
    <?php endif; ?>

</body>

</html>