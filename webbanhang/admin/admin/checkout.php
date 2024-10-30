
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
    <?php
    include '../../share/header.php'
    ?>
    <!-- Navbar End -->


    <!-- Modal Search Start -->
    <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Search by keyword</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex align-items-center">
                    <div class="input-group w-75 mx-auto d-flex">
                        <input type="search" class="form-control p-3" placeholder="keywords" aria-describedby="search-icon-1">
                        <span id="search-icon-1" class="input-group-text p-3"><i class="fa fa-search"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Search End -->


    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">
      
    </div>
    <!-- Single Page Header End -->


    <!-- Checkout Page Start -->
   <?php

include '../../database/config.php';
$conn = getConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $totalAmount = $_POST['total_amount'];
    $user_id = $_SESSION['user_id']; // Lấy ID người dùng từ session
 
    // Lấy thông tin giỏ hàng từ database
    $sql = "SELECT * FROM cart WHERE user_id = '$user_id'";
    $result = $conn->query($sql);
    
    // Lưu trữ giỏ hàng để hiển thị
    $cartItems = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $cartItems[] = $row;
        }
    }
} else {
    // Chuyển hướng về trang cart nếu không có dữ liệu
    header("Location: cart.php");
    exit();
}
?>

<div class="container-fluid py-5">
    <div class="container py-5">
        <h1 class="mb-4">Billing details</h1>
        <form action="process_payment.php" method="POST">
            <div class="row g-5">
                <div class="col-md-12 col-lg-6 col-xl-7">
                    <div class="row">
                        <div class="col-md-12 col-lg-6">
                            <div class="form-item w-100">
                                <label class="form-label my-3">Họ Và Tên<sup>*</sup></label>
                                <input type="text" class="form-control" name="fullname" value="<?php echo htmlspecialchars($_SESSION['fullname']); ?>" required>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-6">
                            <div class="form-item w-100">
                                <label class="form-label my-3">Địa Chỉ<sup>*</sup></label>
                                <input type="text" class="form-control" name="address" value="<?php echo htmlspecialchars($_SESSION['address']); ?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-item">
                        <label class="form-label my-3">Số Điện Thoại<sup>*</sup></label>
                        <input type="tel" class="form-control" name="phone_number" value="<?php echo htmlspecialchars($_SESSION['phone_number']); ?>" required>
                    </div>
                    <div class="form-item">
                        <label class="form-label my-3">Email Address<sup>*</sup></label>
                        <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($_SESSION['email']); ?>" required>
                    </div>
                    <hr>
                </div>
                <div class="col-md-12 col-lg-6 col-xl-5">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Hình ảnh</th>
                                    <th scope="col">Tên sản phẩm</th>
                                    <th scope="col">Giá</th>
                                    <th scope="col">Số lượng</th>
                                    <th scope="col">Tổng giá</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($cartItems as $item): 
                                    $totalPrice = $item['price'] * $item['quantity'];
                                ?>
                                <tr>
                                    <th scope="row">
                                        <div class="d-flex align-items-center mt-2">
                                            <img src="<?php echo htmlspecialchars($item['thumbnail']); ?>" class="img-fluid rounded-circle" style="width: 90px; height: 90px;" alt="">
                                        </div>
                                    </th>
                                    <td class="py-5"><?php echo htmlspecialchars($item['title']); ?></td>
                                    <td class="py-5"><?php echo number_format($item['price'], 0, ',', '.'); ?>đ</td>
                                    <td class="py-5"><?php echo htmlspecialchars($item['quantity']); ?></td>
                                    <td class="py-5"><?php echo number_format($totalPrice, 0, ',', '.'); ?>đ</td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="row g-4 text-center align-items-center justify-content-center pt-4">
                        <p class="mb-0 text-dark text-uppercase py-3">Tổng cộng: <?php echo number_format($totalAmount, 0, ',', '.'); ?>đ</p>
                        <button type="submit" class="btn border-secondary py-3 px-4 text-uppercase w-100 text-primary">Thanh Toán</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
    <!-- Checkout Page End -->


    <!-- Footer Start -->
    <?php
    include'../../share/footer.php'
    ?>
    <!-- Footer End -->

    <!-- Copyright Start -->
    <div class="container-fluid copyright bg-dark py-4">
        <div class="container">
            
        </div>
    </div>
    <!-- Copyright End -->



    <!-- Back to Top -->
    

    
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