<?php
session_start(); // Bắt đầu phiên

// Kiểm tra xem người dùng đã đăng nhập hay chưa
$isLoggedIn = isset($_SESSION['user_id']);
$fullname = $isLoggedIn ? htmlspecialchars($_SESSION['fullname']) : null;

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Shop túi Sách</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@600;800&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>

    <!-- Spinner Start -->
    <div id="spinner" class="show w-100 vh-100 bg-white position-fixed translate-middle top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary" role="status"></div>
    </div>
    <!-- Spinner End -->

    <!-- Navbar start -->
    
    <!-- Navbar End -->

    <!-- Login Section Start -->
   


    <div class="container-fluid fixed-top">
       <?php
    include '../../share/header.php'
    ?>
    </div>

    <div class="container py-5" style="margin-top: 100px;">
        <h2 class="text-center">Đăng Ký</h2>
        <form action="register.php" method="post">
            <div class="form-group">
                <label for="fullname">Họ và tên</label>
                <input type="text" id="fullname" name="fullname" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="date_of_birth">Ngày sinh</label>
                <input type="date" id="date_of_birth" name="date_of_birth" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="phone_number">Số điện thoại</label>
                <input type="text" id="phone_number" name="phone_number" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="address">Địa chỉ</label>
                <input type="text" id="address" name="address" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Mật khẩu</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <div class="text-center mt-3">
                <button type="submit" class="btn btn-danger">Đăng Ký</button>
            </div>
        </form>
    </div>

    <?php
// Xử lý đăng ký
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include '../../database/config.php'; // Kết nối cơ sở dữ liệu
    $conn = getConnection();

    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $date_of_birth = $_POST['date_of_birth'];
    $phone_number = $_POST['phone_number'];
    $address = $_POST['address'];
    $password = $_POST['password'];

    // Mã hóa mật khẩu
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Thêm người dùng vào cơ sở dữ liệu
    $stmt = $conn->prepare("INSERT INTO user (fullname, email, date_of_birth, phone_number, address, password) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $fullname, $email, $date_of_birth, $phone_number, $address, $hashed_password);
    
    if ($stmt->execute()) {
        echo '<div class="alert alert-success text-center">Đăng ký thành công!</div>';
    } else {
        echo '<div class="alert alert-danger text-center">Có lỗi xảy ra! Vui lòng thử lại.</div>';
    }

    $stmt->close();
    $conn->close();
}
?>

   

   
    <!-- Login Section End -->

    <!-- Footer Start -->
    <?php
     include '../../share/footer.php'
    ?>
    <!-- Footer End -->

    <!-- JavaScript Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/lightbox/js/lightbox.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>