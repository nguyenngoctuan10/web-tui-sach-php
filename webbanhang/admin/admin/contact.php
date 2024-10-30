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
    <title>Shop Túi Sách</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@600;800&display=swap" rel="stylesheet"> 

    <!-- Icon Font Stylesheet -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">


    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <!-- Spinner Start -->
    <div id="spinner" class="show w-100 vh-100 bg-white position-fixed translate-middle top-50 start-50  d-flex align-items-center justify-content-center">
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


    <!-- Modal Search Start -->
    <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content rounded-0">

                <div class="modal-body d-flex align-items-center">

                </div>
            </div>
        </div>
    </div>
    <!-- Modal Search End -->


    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">

    </div>
    <!-- Single Page Header End -->


    <!-- Contact Start -->
    <div class="container-fluid contact py-5">
    <div class="container py-5">
        <div class="p-5 bg-light rounded">
            <div class="row g-4">
                <div class="col-12">
                    <div class="text-center mx-auto" style="max-width: 1200px;">
                        <h1 class="text-primary">Nội Dung Phản Hồi</h1>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="h-100 rounded"></div>
                </div>

                <div class="col-lg-7">
                    <form action="" method="POST" class="">
                        <input type="text" name="firstname" class="form-control mb-4" placeholder="Nhập họ tên" required>
                        <input type="email" name="email" class="form-control mb-4" placeholder="Nhập email" required>
                        <input type="text" name="phone_number" class="form-control mb-4" placeholder="Số điện thoại" required>
                        <textarea name="notes" class="form-control mb-4" rows="5" placeholder="Nội dung phản hồi" required></textarea>
                        <button class="btn btn-primary w-100" type="submit">Gửi phản hồi</button>
                    </form>
                </div>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include '../../database/config.php'; // Kết nối cơ sở dữ liệu
    $conn = getConnection();

    $fullname = $_POST['firstname'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $notes = $_POST['notes'];
  
    // Thêm người dùng vào cơ sở dữ liệu
    $stmt = $conn->prepare("INSERT INTO feedback (firstname, email, phone_number, notes) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $fullname,$email,$phone_number,$notes);
    
    if ($stmt->execute()) {
        echo '<div class="alert alert-success text-primary">Phản hồi của bạn đã được tiếp nhận!</div>';
    } else {
        echo '<div class="alert alert-danger text-primary">Có lỗi xảy ra! Vui lòng thử lại.</div>';
    }

    $stmt->close();
    $conn->close();
}
?>
                    <div class="col-lg-5">
                    <div class="d-flex p-4 rounded mb-4 bg-white">
                        <i class="fas fa-map-marker-alt fa-2x text-primary me-4"></i>
                        <div>
                            <h4>Địa Chỉ</h4>
                            <p class="mb-2">218 Lĩnh Nam</p>
                        </div>
                    </div>
                    <div class="d-flex p-4 rounded mb-4 bg-white">
                        <i class="fas fa-envelope fa-2x text-primary me-4"></i>
                        <div>
                            <h4>Mail</h4>
                            <p class="mb-2">nguyenngoctuan@gmail.com</p>
                        </div>
                    </div>
                    <div class="d-flex p-4 rounded bg-white">
                        <i class="fa fa-phone-alt fa-2x text-primary me-4"></i>
                        <div>
                            <h4>Telephone</h4>
                            <p class="mb-2">(+012) 3456 7890</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <!-- Contact End -->
    <!-- Footer Start -->
    <?php
    include '../../share/footer.php'
    ?>
    <!-- Footer End -->

    <!-- Copyright Start -->
    <div class="container-fluid copyright bg-dark py-4">
        <div class="container">

        </div>
    </div>
    <!-- Copyright End -->
    <!-- Back to Top -->
    <a href="#" class="btn btn-primary border-3 border-primary rounded-circle back-to-top"><i class="fa fa-arrow-up"></i></a>   

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