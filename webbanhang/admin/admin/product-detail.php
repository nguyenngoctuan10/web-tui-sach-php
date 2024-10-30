j <?php
session_start();
// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirect to login page
    exit();
}
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

        <div class="container px-0">
            <nav class="navbar navbar-light bg-white navbar-expand-xl">
                <a href="index.php" class="navbar-brand"><h1 class="text-primary display-6">HandBag</h1></a>
                <button class="navbar-toggler py-2 px-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars text-primary"></span>
                </button>
                <div class="collapse navbar-collapse bg-white" id="navbarCollapse">
                    <div class="navbar-nav mx-auto">
                        <a href="index.php" class="nav-item nav-link">Home</a>
                        <a href="shop.php" class="nav-item nav-link">Shop</a>
                        <a href="product-detail.php" class="nav-item nav-link active">Product Detail</a>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"></a>
                            <div class="dropdown-menu m-0 bg-secondary rounded-0">
                                <a href="logout.php" class="dropdown-item">Đăng Xuất</a>


                            </div>
                        </div>
                        <a href="contact.php" class="nav-item nav-link">Contact</a>
                    </div>
                    <div class="d-flex m-3 me-0">

                        <a href="cart.php" class="position-relative me-4 my-auto">
                            <i class="fa fa-shopping-bag fa-2x"></i>
                            <span class="position-absolute bg-secondary rounded-circle d-flex align-items-center justify-content-center text-dark px-1" style="top: -5px; left: 15px; height: 20px; min-width: 20px;">3</span>
                        </a>
                        <a href="DangNhap.php" class="my-auto">
                            <i class="fas fa-user fa-2x"></i>
                        </a>
                    </div>
                </div>
            </nav>
        </div>
    </div>
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
        <h1 class="text-center text-white display-6"></h1>

    </div>
    <!-- Single Page Header End -->


    <!-- Single Product Start -->
    <div class="container-fluid py-5 mt-5">
        <div class="container py-5">
            <div class="row g-4 mb-5">
                <div class="col-lg-8 col-xl-9">
                    <div class="row g-4">
                        <div class="col-lg-6">
                            <div class="border rounded">
                                <a href="#">
                                    <?php
                include '../../database/config.php'; // Kết nối cơ sở dữ liệu
                $conn = getConnection();
                $product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

                if ($product_id > 0) {
                    // Truy vấn thông tin sản phẩm
                    $stmt = $conn->prepare("SELECT * FROM product WHERE id = ?");
                    $stmt->bind_param("i", $product_id);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        $product = $result->fetch_assoc();

                        // Hiển thị hình ảnh sản phẩm
                        echo '<img src="' . htmlspecialchars($product["thumbnail"]) . '" class="img-fluid rounded" alt="' . htmlspecialchars($product["title"]) . '">';
                    } else {
                        echo "Sản phẩm không tồn tại.";
                        exit;
                    }
                } else {
                    echo "ID sản phẩm không hợp lệ.";
                    exit;
                }

                // Đóng kết nối
                $stmt->close();
                $conn->close();
                ?>
            </a>
        </div>
    </div>
    <?php
    $conn = getConnection();
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        
        $user_id = $_SESSION['user_id'];

        $stmt = $conn->prepare("SELECT * FROM product WHERE id = ?");
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $product = $result->fetch_assoc();
            print_r('tr');
        }



    // if ($product) {
    //     // Thêm sản phẩm vào giỏ hàng
    //     $stmt = $pdo->prepare("INSERT INTO cart (user_id, thumbnail, title, price, quantity) VALUES (?, ?, ?, ?, ?)");
    //     $stmt->execute([$user_id, $product['thumbnail'], $product['title'], $product['price'], $quantity]);

    //     header('Location: cart.php'); // Chuyển hướng đến trang giỏ hàng
    //     exit();
    // }
    }
    ?> 
    <div class="col-lg-6">
        <?php
        $quantity = 1;
        if ($product_id > 0 && $result->num_rows > 0) {
            // Hiển thị thông tin sản phẩm
            echo '<h4 class="fw-bold mb-3">' . htmlspecialchars($product["title"]) . '</h4>';
            echo '<p class="mb-3">Danh mục: ' . htmlspecialchars($product['category_id']) . '</p>';
            echo '<h5 class="fw-bold mb-3">' . number_format($product['price'], 0, ',', '.') . 'đ</h5>';
            echo '<div class="d-flex mb-4">';
            echo '<i class="fa fa-star text-secondary"></i>';
            echo '<i class="fa fa-star text-secondary"></i>';
            echo '<i class="fa fa-star text-secondary"></i>';
            echo '<i class="fa fa-star text-secondary"></i>';
            echo '<i class="fa fa-star"></i>';
            echo '</div>';
            echo '<p class="mb-4">' . htmlspecialchars($product['description']) . '</p>';
            echo '<form action="add-to-cart.php" method="POST" id="cart-form">';
echo '<form action="add-to-cart.php" method="POST" id="cart-form">';
echo '    <div class="input-group quantity mt-4" style="width: 100px;">';
echo '        <div class="input-group-btn">';
echo '            <button type="button" class="btn btn-sm btn-minus rounded-circle bg-light border" onclick="changeQuantity(0)">';
echo '                <i class="fa fa-minus"></i>';
echo '            </button>';
echo '        </div>';

//   id đặt tên  name là lấy dữ liệu từ data
echo '        <input type="text" name="quantity" id="quantity" class="form-control form-control-sm text-center" value="' . $quantity . '" readonly>';
echo '        <div class="input-group-btn">';
echo '            <button type="button" class="btn btn-sm btn-plus rounded-circle bg-light border" onclick="changeQuantity(0)">';
echo '                <i class="fa fa-plus"></i>';
echo '            </button>';
echo '        </div>';
echo '    </div>';
echo '    <button class="btn btn-primary w-100 mt-3" type="submit">Thêm vào giỏ hàng</button>';
echo '    <input type="hidden" name="id" value="' . $product['id'] . '">';
echo '</form>';
        }
        ?>
<script>
function changeQuantity(amount) {
    var quantityInput = document.getElementById("quantity");
    var currentQuantity = parseInt(quantityInput.value) || 0; // Get current quantity or default to 0
    var newQuantity = currentQuantity + amount;

    // Allow increasing quantity and prevent negative values
    if (newQuantity >= 0) {
        quantityInput.value = newQuantity;
    }
}
</script>
    </div>


    <form action="#">
        <h4 class="mb-5 fw-bold">Leave a Reply</h4>
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="border-bottom rounded">
                    <input type="text" class="form-control border-0 me-4" placeholder="Yur Name *">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="border-bottom rounded">
                    <input type="email" class="form-control border-0" placeholder="Your Email *">
                </div>
            </div>
            <div class="col-lg-12">
                <div class="border-bottom rounded my-4">
                    <textarea name="" id="" class="form-control border-0" cols="30" rows="8" placeholder="Your Review *" spellcheck="false"></textarea>
                </div>
            </div>
            <div class="col-lg-12">

            </div>
        </div>
    </form>
</div>
</div>
<div class="col-lg-4 col-xl-3">
    <div class="row g-4 fruite">
        <div class="col-lg-12">

            <div class="mb-4">
                <h4>Danh Mục</h4>
                <?php

                $conn= getConnection();
                $sql = "SELECT * FROM category"; 
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                       echo' <ul class="list-unstyled fruite-categorie">';
                       echo'   <li>';
                       echo'  <div class="d-flex justify-content-between fruite-name">';
                       echo'  <a href="#"><i class="fas fa-apple-alt me-2"></i>'. $row["name"] .'</a>';
                       echo'   <span>'.$row["id"].'</span>';
                       echo'    </div>';
                       echo' </li> ';    
                       echo'</ul>';
                   }
               } else {
                echo "0 kết quả";
            }

            $conn->close();
            ?>
        </div>
    </div>
    <div class="col-lg-12">
        <h4 class="mb-4">Sản Phẩm Nổi Bật</h4>
        <?php
        $conn=getConnection();
        $sql="SELECT * FROM product WHERE outstanding=1";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
    // Xuất dữ liệu cho từng hàng
            while($row = $result->fetch_assoc()) {

              echo'  <div class="d-flex align-items-center justify-content-start">';
              echo'      <a href="product-detail.php">';
              echo'      <div class="rounded me-4" style="width: 100px; height: 100px;">';
              echo'  <img src="'.$row["thumbnail"].'" class="img-fluid rounded" alt="">';
              echo' </div>';
              echo'  <div>';
              echo'    <h6 class="mb-2">'.$row["title"].'</h6>';
              echo' <div class="d-flex mb-2">';
              echo'    <i class="fa fa-star text-secondary"></i>';
              echo'   <i class="fa fa-star text-secondary"></i>';
              echo'   <i class="fa fa-star text-secondary"></i>';
              echo'  <i class="fa fa-star text-secondary"></i>';
              echo'  <i class="fa fa-star"></i>';
              echo' </div>';
              echo' <div class="d-flex mb-2">';
              $formattedPrice = number_format($row["price"], 0, ',', '.') . 'đ';
              echo'  <h5 class="fw-bold me-2">'.$formattedPrice.'</h5>';


              echo' </div>';
              echo'  </div>';
              echo' </div>';


              echo' <div class="d-flex justify-content-center my-4">';
              echo' <a href="product-detail.php?id=' . $row["id"] . '" class="btn border border-secondary px-4 py-3 rounded-pill text-primary w-100">Xem chi tiết</a>';
              echo'</div>';
          }
      } else {
        echo "0 kết quả";
    }

    $conn->close();
    ?>
    <div class="col-lg-12">
        <div class="position-relative">
            <img src="img/banner-bag.jpg" class="img-fluid w-100 rounded" alt="">
            <div class="position-absolute" style="top: 50%; right: 10px; transform: translateY(-50%);">

            </div>
        </div>
    </div>
</div>
</div>
</div>

</div>
</div>
<!-- Single Product End -->


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