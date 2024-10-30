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


<!-- Cart Page Start -->
<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="table-responsive">
            <?php
include '../../database/config.php';
$conn = getConnection();
$sql = "SELECT * FROM cart";
$result = $conn->query($sql);

$total = 0;
$tongTotal = 0;

if ($result->num_rows > 0) {
    // Bắt đầu bảng
    echo '<table class="table">';
    echo '<thead>';
    echo '<tr>';
    echo '<th scope="col">Hình ảnh</th>';
    echo '<th scope="col">Tên sản phẩm</th>';
    echo '<th scope="col">Giá</th>';
    echo '<th scope="col">Số lượng</th>';
    echo '<th scope="col">Tổng</th>';
    echo '<th scope="col">Xóa</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    // Xuất dữ liệu cho từng hàng
    while ($row = $result->fetch_assoc()) {
        $itemTotal = $row['price'] * $row['quantity'];
        $tongTotal += $itemTotal;

        $formattedPrice = number_format($row["price"], 0, ',', '.') . 'đ';
        $formattedTotal = number_format($itemTotal, 0, ',', '.') . 'đ';
        echo '<tr>';
        echo '    <th scope="row">';
        echo '        <div class="d-flex align-items-center">';
        echo '            <img src="' . $row["thumbnail"] . '" class="img-fluid me-5 rounded-circle" style="width: 80px; height: 80px;" alt="">';
        echo '        </div>';
        echo '    </th>';
        echo '    <td>';
        echo '        <p class="mb-0 mt-4">' . $row["title"] . '</p>';
        echo '    </td>';
        echo '    <td>';
        echo '        <p class="text-dark fs-5 fw-bold mb-0">Giá bán: ' . $formattedPrice . '</p>';
        echo '    </td>';
        echo '    <td>';
        echo '        <div class="input-group quantity mt-4" style="width: 100px;">';
        echo '            <input type="text" class="form-control form-control-sm text-center border-0" value="' . $row["quantity"] . '">';
        echo '        </div>';
        echo '    </td>';
        echo '    <td>';
        echo '        <p class="mb-0 mt-4">'.$formattedTotal.'</p>';
        echo '    </td>';
        echo '    <td>';
        echo '<form method="POST" action="delete_cart_item.php">';
        echo '<input type="hidden" name="cart_id" value="'.$row["cart_id"].'">';
        echo '<button class="btn btn-md rounded-circle bg-light border mt-4" type="submit">';
        echo '<i class="fa fa-times text-danger"></i>';
        echo '</button>';
        echo '</form>';
        echo '    </td>';
        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';
    
    

} else {
    echo '<div class="text-center">Không có sản phẩm nào</div>';
}
?>
<?php
echo '<div class="row g-4 justify-content-end">';
echo '    <div class="col-8"></div>';
echo '    <div class="col-sm-8 col-md-7 col-lg-6 col-xl-4">';
echo '        <div class="bg-light rounded">';
echo '            <div class="p-4">';
echo '                <h1 class="display-6 mb-4">Tổng giỏ hàng<span class="fw-normal"></span></h1>';
echo '                <div class="d-flex justify-content-between mb-4">';
echo '                    <h5 class="mb-0 me-4">Tiền Hàng:</h5>';
echo '                    <p class="mb-0">' . number_format($itemTotal) . '</p>';
echo '                </div>';
echo '                <div class="d-flex justify-content-between">';
echo '                    <h5 class="mb-0 me-4">Vận Chuyển</h5>';
echo '                    <div class="">';
echo '                        <p class="mb-0">' . '0' . 'đ</p>';
echo '                    </div>';
echo '                </div>';
echo '                <p class="mb-0 text-end"></p>';
echo '            </div>';
echo '            <div class="py-4 mb-4 border-top border-bottom d-flex justify-content-between">';
echo '                <h5 class="mb-0 ps-4 me-4">   Tổng   </h5>';
echo '                <p class="mb-0 pe-4">' . number_format($tongTotal) . 'đ</p>'; 
echo '            </div>';
echo '<form action="checkout.php" method="POST">';
    echo '<input type="hidden" name="total_amount" value="'.$tongTotal.'">';
    echo '<button type="submit" class="btn btn-primary">Tiến hành thanh toán</button>';
    echo '</form>';
echo '        </div>';
echo '    </div>';
echo '</div>';
$conn->close();
?>
</div>


</div>
</div>
<!-- Cart Page End -->


<!-- Footer Start -->
<?php
include '../../share/footer.php'
?>
<!-- Footer End -->

<!-- Copyright Start -->
<div class="container-fluid copyright bg-dark py-4">
    <div class="container">
        <div class="row">


        </div>
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