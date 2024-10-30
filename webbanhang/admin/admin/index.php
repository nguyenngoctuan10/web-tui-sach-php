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


<!-- Hero Start -->
<div class="container-fluid py-5 mb-5 hero-header">
    <div class="container py-5">
        <div class="row g-5 align-items-center">
            <div class="col-md-12 col-lg-7">
    <h1 class="mb-5 display-3 text-primary">Cửa Hàng Túi Sách</h1>

    <div class="position-relative mx-auto">
        <form action="index.php" method="GET">
            <input class="form-control border-2 border-secondary w-75 py-3 px-4 rounded-pill" 
                   type="text" name="query" placeholder="Search" required>
            <button type="submit" class="btn btn-primary border-2 border-secondary py-3 px-4 position-absolute rounded-pill text-white h-100" 
                    style="top: 0; right: 25%;">Tìm Kiếm</button>
        </form>
    </div>

    <div class="row mt-4"> <!-- Thêm lớp row ở đây -->
        <?php
        include '../../database/config.php';
        $conn = getConnection();

        // Lấy từ khóa tìm kiếm
        $query = isset($_GET['query']) ? trim($_GET['query']) : '';                        

        if (!empty($query)) {
            // Sử dụng prepared statement để tránh SQL injection
            $stmt = $conn->prepare("SELECT * FROM product WHERE title LIKE ?");
            $likeQuery = "%" . $conn->real_escape_string($query) . "%";
            $stmt->bind_param("s", $likeQuery);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // Xuất dữ liệu cho từng hàng
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="col-md-6 col-lg-4 col-xl-3 mb-4">'; // Thêm mb-4 để tạo khoảng cách giữa các sản phẩm
                    echo '    <div class="rounded position-relative fruite-item">';
                    echo '        <div class="fruite-img">';
                    echo '            <img src="' . htmlspecialchars($row["thumbnail"]) . '" class="img-fluid w-100 rounded-top" alt="">';
                    echo '        </div>';
                    echo '        <div class="p-4 border border-secondary border-top-0 rounded-bottom">';
                    echo '            <h4>' . htmlspecialchars($row["title"]) . '</h4>'; 
                    echo '            <p>' . htmlspecialchars($row["description"]) . '</p>'; 
                    echo '            <div class="d-flex justify-content-between align-items-center flex-lg-wrap">';
                    
                    // Định dạng số tiền
                    $formattedPrice = number_format($row["price"], 0, ',', '.') . 'đ';
                    echo '  <p class="text-dark fs-5 fw-bold mb-0">Giá bán: '. $formattedPrice . '</p>';
                    
                    echo '            </div>'; // Đóng d-flex
                    echo '            <div class="text-center mt-3">'; // Thêm div này để căn giữa
                    echo '                <a href="product-detail.php?id=' . $row["id"] . '" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Mua Hàng</a>';
                    echo '            </div>'; // Đóng div căn giữa
                    echo '        </div>';
                    echo '    </div>';
                    echo '</div>'; // Đóng cột
                }
            } else {
                echo "Không tìm thấy sản phẩm nào.";
            }

            $stmt->close();
        } else {
            echo "";
        }

        $conn->close();
        ?>
    </div> <!-- Đóng row -->
</div>

<div class="col-md-12 col-lg-5">
    <div id="carouselId" class="carousel slide position-relative" data-bs-ride="carousel">
        <div class="carousel-inner" role="listbox">
            <div class="carousel-item active rounded">
                <img src="img/img-1.png" class="img-fluid w-100 h-100 bg-secondary rounded" alt="First slide">
            </div>
            <div class="carousel-item rounded">
                <img src="img/img-2.jpg" class="img-fluid w-100 h-100 rounded" alt="Second slide">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselId" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselId" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>
    </div>
</div>
<!-- Hero End -->





<!-- Fruits Shop Start-->
<div class="container-fluid fruite py-5">
    <div class="container py-5">
        <div class="tab-class text-center">
            <div class="row g-4">
                <div class="col-lg-4 text-start">
                    <h1>Hàng Mới Về</h1>
                </div>
            </div>
            
            <div class="tab-content">
                <div id="tab-1" class="tab-pane fade show p-0 active">
                    <div class="row g-4">
                        <?php 
                        
                        $conn = getConnection();
                        $sql = "SELECT * FROM product"; 
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            // Xuất dữ liệu cho từng hàng
                            while($row = $result->fetch_assoc()) {
                                echo '<div class="col-md-6 col-lg-4 col-xl-3">'; 
                                echo '    <div class="rounded position-relative fruite-item">';
                                echo '        <div class="fruite-img">';
                                echo '            <img src="' . $row["thumbnail"] . '" class="img-fluid w-100 rounded-top" alt="">';
                                echo '        </div>';
                                echo '        <div class="p-4 border border-secondary border-top-0 rounded-bottom">';
                                echo '            <h4>' . $row["title"] . '</h4>'; 
                                echo '            <p>' . $row["description"] . '</p>'; 
                                echo '            <div class="d-flex justify-content-between align-items-center flex-lg-wrap">';
                                
                                // Định dạng số tiền
                                $formattedPrice = number_format($row["price"], 0, ',', '.') . 'đ';
                                echo '  <p class="text-dark fs-5 fw-bold mb-0">Giá bán: '. $formattedPrice . '</p>';
                                
                                echo '            </div>'; // Đóng d-flex
                                echo '            <div class="text-center mt-3">'; // Thêm div này để căn giữa
                                echo '                <a href="product-detail.php?id=' . $row["id"] . '" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Mua Hàng</a>';
                                echo '            </div>'; // Đóng div căn giữa
                                echo '        </div>';
                                echo '    </div>';
                                echo '</div>'; // Đóng cột
                            }
                        } else {
                            echo "0 kết quả";
                        }

                        $conn->close();
                        ?>
                    </div>
                </div>
            </div>
        </div>      
    </div>
</div>
<!-- Fruits Shop End-->

<!-- Featurs Start -->
<div class="container-fluid service py-5">
    <div class="container py-5">
        <div class="row g-4 justify-content-center">
            <div><h2>Hàng Bán Chạy</h2></div>
            <?php 

            $conn = getConnection();
            $sql = "SELECT * FROM product WHERE best_sellers = 1"; 

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
    // Xuất dữ liệu cho từng hàng
                while($row = $result->fetch_assoc()) {

                 echo'     <div class="col-md-6 col-lg-4">';
                 echo'      <a href="product-detail.php?id='.$row["id"].'">';
                 echo'        <div class="service-item bg-secondary rounded border border-secondary">';

                 echo'      <img src="'.$row["thumbnail"].'" class="img-fluid rounded-top w-100" alt="">';
                 echo'    <div class="px-4 rounded-bottom">';

                 echo'   </div>';
                 echo'  </div>';
                 echo' </a>';
                 echo' </div>';
             }
         } else {
            echo "0 kết quả";
        }

        $conn->close();
        ?>

    </div>
</div>
</div>
<!-- Featurs End -->


<!-- Vesitable Shop Start-->
<div class="container-fluid vesitable py-5">
    <div class="container py-5">
        <h1 class="mb-0">Hàng Giảm Giá 20%</h1>
        <div class="row">
            <?php 
            $conn = getConnection();


            if ($conn->connect_error) {
                die("Kết nối thất bại: " . $conn->connect_error);
            }


            $sql = "SELECT * FROM product WHERE discount / price = 0.2"; 
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {

                while ($row = $result->fetch_assoc()) {
                    echo '<div class="col-md-6 col-lg-4 col-xl-3 mb-4">'; 
                    echo '    <div class="rounded position-relative vesitable-item">';
                    echo'      <a href="product-detail.php">';
                    echo '        <div class="vesitable-img">';
                    echo '            <img src="' . $row["thumbnail"] . '" class="img-fluid w-100 rounded-top" alt="">';
                    echo '        </div>';
                    echo '        <div class="p-4 border border-secondary border-top-0 rounded-bottom">';
                    echo '            <h4>' . htmlspecialchars($row["title"]) . '</h4>'; 
                    echo '            <p>' . htmlspecialchars($row["description"]) . '</p>'; 
                    echo '            <div class="d-flex justify-content-between flex-lg-wrap">';

                        // Định dạng số tiền
                    $formattedPrice = number_format($row["price"], 0, ',', '.') . 'đ';
                    echo '  <p class="text-dark fs-5 fw-bold mb-0">Giá bán: ' . $formattedPrice . '</p>';

                    echo '                <a href="product-detail.php?id=' . $row["id"] . '" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Mua Hàng</a>';
                    echo '            </div>';
                    echo '        </div>';
                    echo '    </div>';
                    echo '</div>'; 
                }
            } else {
                echo '<div class="col-12 text-center">Không có sản phẩm nào giảm giá 20%</div>';
            }

            $conn->close();
            ?>
        </div>
    </div>
</div>
<!-- Vesitable Shop End -->


<!-- Banner Section Start-->

<!-- Banner Section End -->


<!-- Bestsaler Product Start -->
<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="text-center mx-auto mb-5" style="max-width: 1100px;">
            <h1 class="display-4">Sản Phẩm Được Yêu Thích Nhiều Nhất</h1>                
        </div>
        <div class="row g-4">
            <?php
            $conn = getConnection();

// Kiểm tra kết nối
            if ($conn->connect_error) {
                die("Kết nối thất bại: " . $conn->connect_error);
            }

// Truy vấn để lấy sản phẩm yêu thích
            $sql = "SELECT * FROM product WHERE favourite = 1"; 
            $result = $conn->query($sql);

// Kiểm tra và hiển thị dữ liệu
            if ($result->num_rows > 0) {
    echo '<div class="row">'; // Mở div row
    while ($row = $result->fetch_assoc()) {
        echo '<div class="col-lg-6 col-xl-4 mb-4">'; // Thêm khoảng cách giữa các sản phẩm
        echo '    <div class="p-4 rounded bg-light">';
        echo '        <div class="row align-items-center">';
        echo '            <div class="col-6">';
        echo '                <img src="' . htmlspecialchars($row["thumbnail"]) . '" class="img-fluid rounded-circle w-100" alt="">';
        echo '            </div>';
        echo '            <div class="col-6">';
        echo '                <a href="#" class="h5">' . htmlspecialchars($row["title"]) . '</a>';
        echo '                <div class="d-flex my-3">';
        echo '                    <i class="fas fa-star text-primary"></i>';
        echo '                    <i class="fas fa-star text-primary"></i>';
        echo '                    <i class="fas fa-star text-primary"></i>';
        echo '                    <i class="fas fa-star text-primary"></i>';
        echo '                    <i class="fas fa-star"></i>';
        echo '                </div>';
        
        // Định dạng giá
        $formattedPrice = number_format($row["price"], 0, ',', '.') . 'đ';
        echo '                <h4 class="mb-3">Giá Bán: ' . $formattedPrice . '</h4>';
        echo '                <a href="product-detail.php?id='.$row["id"].' " class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Mua Hàng</a>';
        echo '            </div>';
        echo '        </div>';
        echo '    </div>';
        echo '</div>'; // Đóng cột
    }
    echo '</div>'; // Đóng div row
} else {
    echo '<div class="col-12 text-center">Không có sản phẩm yêu thích nào</div>';
}

// Đóng kết nối
$conn->close();
?>
</div>
</div>
</div>
<!-- Bestsaler Product End -->
<!-- Footer Start -->
<?php
include '../../share/footer.php'
?>
<!-- Footer End -->

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