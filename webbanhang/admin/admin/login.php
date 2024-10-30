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
    <div class="container-fluid fixed-top">
        <?php
    include '../../share/header.php'
    ?>
    </div>
    <!-- Navbar End -->

    <!-- Login Section Start -->
 <?php
// Xử lý đăng nhập
    if (isset($_POST['fullname']) && isset($_POST['password'])) {  
    session_start();
    include '../../database/config.php'; // Kết nối cơ sở dữ liệu
    $conn = getConnection();

    $fullname = $_POST['fullname'];
    $password = $_POST['password'];
    //Truy vấn để lấy thông tin người dùng
    $stmt = $conn->prepare("SELECT * FROM user WHERE fullname = ?");
    $stmt->bind_param("s", $fullname);
    $stmt->execute();
    $result = $stmt->get_result();
  
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Kiểm tra mật khẩu
        if (password_verify($password, $user['password'])) {
            // Đăng nhập thành công
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['fullname'] = $user['fullname'];
            header("Location: shop.php");
            exit();
        } else {
            echo '<div class="alert alert-danger text-center">Mật khẩu không đúng!</div>';
        }
    } else {
        echo '<div class="alert alert-danger text-center">Họ và tên không tồn tại!</div>';
    }
    $stmt->close();
    $conn->close();
}
?>

    <div class="container-fluid py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center">Đăng Nhập</h2>
                <form action="login.php" method="post">
                    <div class="form-group">
                        <label for="fullname" class="form-label">Tên đăng nhập</label>
                        <input type="text" id="fullname" name="fullname" class="form-control" required>
                        <span class="text-danger" id="fullnameError"></span>
                    </div>
                    <div class="form-group">
                        <label for="password" class="form-label">Mật khẩu</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                        <span class="text-danger" id="passwordError"></span>
                    </div>
                    <div class="text-center mt-3">
                        <button type="submit" class="btn btn-danger">Đăng Nhập</button>
                    </div>
                </form>
                <div class="text-center mt-3">
                    <a href="register.php">Đăng Ký</a>
                </div>
            </div>
        </div>
    </div>
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