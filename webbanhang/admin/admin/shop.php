
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


    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">


    </div>
    <!-- Single Page Header End -->
    <!-- Fruits Shop Start-->
    <div class="container-fluid fruite py-5">
        <div class="container py-5">
            <h1 class="mb-4">Cửa Hàng Túi Sách</h1>
            <div class="row g-4">
                <div class="col-lg-12">
                    <div class="row g-4">
                        <div class="col-xl-3">
                            <form action="shop.php" method="GET" class="d-flex mb-4">
                                <input class="form-control border-2 border-secondary me-2" 
                                type="text" name="query" placeholder="Search" required>
                                <button type="submit" class="btn btn-primary border-2 border-secondary py-1 px-1 rounded-pill text-white">
                                    Tìm Kiếm
                                </button>
                            </form>
                        </div>

                        <div class="col-xl-9"> <!-- Chia cột cho khu vực hiển thị sản phẩm -->
                            <div class="row g-4"> <!-- Thêm hàng mới để bao bọc sản phẩm -->
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
                            echo '<div class="col-md-6 col-lg-4 col-xl-3 mb-4">'; // Mỗi sản phẩm chiếm 3 cột
                            echo '    <div class="rounded position-relative fruite-item">';
                            echo '        <div class="fruite-img">';
                            echo '            <img src="' . htmlspecialchars($row["thumbnail"]) . '" class="img-fluid w-100 rounded-top" alt="" style="height: 200px; object-fit: cover;">'; // Tăng chiều cao hình ảnh
                            echo '        </div>';
                            echo '        <div class="p-4 border border-secondary border-top-0 rounded-bottom">';
                            echo '            <h4 class="fs-5">' . htmlspecialchars($row["title"]) . '</h4>'; // Tăng kích thước tiêu đề
                            echo '            <p class="mb-3" style="font-size: 0.9rem;">' . htmlspecialchars($row["description"]) . '</p>'; // Tăng kích thước mô tả
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
                        echo "<div class='col-12'>Không tìm thấy sản phẩm nào.</div>";
                    }

                    $stmt->close();
                } else {
                    echo "<div class='col-12'></div>";
                }

                $conn->close();
                ?>
            </div> <!-- Đóng hàng -->
        </div>
    </div> <!-- Đóng hàng chính -->
</div>




<div class="row g-4">
    <div class="col-lg-3">
        <div class="row g-4">
            <div class="col-lg-12">
                <div class="mb-3">
                    <h4>Danh Mục</h4>
                    <?php
                    $conn = getConnection();

    // Truy vấn danh mục
                    $sql = "SELECT * FROM category";
                    $result = $conn->query($sql);

    // Lấy category_id từ URL
                    $category_id = isset($_GET['category_id']) ? intval($_GET['category_id']) : 0;

    // Hiển thị danh mục
                    if ($result->num_rows > 0) {
                        echo '<ul class="list-unstyled fruite-categorie">';
                        while ($row = $result->fetch_assoc()) {
                            echo '<li>';
                            echo '<div class="d-flex justify-content-between fruite-name">';
                            echo '<a href="?category_id=' . $row["id"] . '"><i class="fas fa-apple-alt me-2"></i>' . htmlspecialchars($row["name"]) . '</a>';
                            echo '<span></span>';
                            echo '</div>';
                            echo '</li>';
                        }
                        echo '</ul>';
                    } else {
                        echo "Không có danh mục nào.";
                    }

    // Truy vấn sản phẩm theo category_id


                    $conn->close();
                    ?>
                </div>
            </div>

            <div class="col-lg-12">
                <h4 class="mb-3">Sản Phẩm Nổi Bật</h4>
                <?php
                $conn = getConnection();
                $sql = "SELECT * FROM product WHERE outstanding=1";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="d-flex align-items-center justify-content-start">';
                        echo '<a href="product-detail.php">';
                        echo '<div class="rounded me-4" style="width: 100px; height: 100px;">';
                        echo '<img src="' . $row["thumbnail"] . '" class="img-fluid rounded" alt="">';
                        echo '</div>';
                        echo '<div>';
                        echo '<h6 class="mb-2">' . $row["title"] . '</h6>';
                        echo '<div class="d-flex mb-2">';
                        echo '<i class="fa fa-star text-secondary"></i>';
                        echo '<i class="fa fa-star text-secondary"></i>';
                        echo '<i class="fa fa-star text-secondary"></i>';
                        echo '<i class="fa fa-star text-secondary"></i>';
                        echo '<i class="fa fa-star"></i>';
                        echo '</div>';
                        echo '<div class="d-flex mb-2">';
                        $formattedPrice = number_format($row["price"], 0, ',', '.') . 'đ';
                        echo '<h5 class="fw-bold me-2">' . $formattedPrice . '</h5>';
                        echo '</div>';
                        echo '</div>';
                        echo '</a>';
                        echo '<div class="d-flex justify-content-center my-4">';
                        echo '<a href="product-detail.php?id=' . $row["id"] . '" class="btn border border-secondary px-4 py-3 rounded-pill text-primary w-100">Xem chi tiết</a>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo "0 kết quả";
                }
                $conn->close();
                ?>
            </div>

            <div class="col-lg-12">
                <div class="position-relative">
                    <img src="img/banner-bag.jpg" class="img-fluid w-100 rounded" alt="">
                    <div class="position-absolute" style="top: 50%; right: 10px; transform: translateY(-50%);"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-9">
    <div class="row g-4 justify-content-center">
        <div class="container">
            <div class="row">
                <?php 
                $conn = getConnection();

                // Lấy category_id từ URL
                $category_id = isset($_GET['category_id']) ? intval($_GET['category_id']) : 0;

                // Truy vấn tổng số sản phẩm
                if ($category_id > 0) {
                    // Truy vấn số lượng sản phẩm trong danh mục
                    $sql = "SELECT COUNT(*) AS total FROM product WHERE category_id = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $category_id);
                } else {
                    // Truy vấn số lượng tất cả sản phẩm
                    $sql = "SELECT COUNT(*) AS total FROM product";
                    $stmt = $conn->prepare($sql);
                }
                $stmt->execute();
                $totalResult = $stmt->get_result();
                $totalRow = $totalResult->fetch_assoc();
                $totalProducts = $totalRow['total'];

                $productsPerPage = 9;
                $totalPages = ceil($totalProducts / $productsPerPage);

                $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                $currentPage = max(1, min($currentPage, $totalPages)); // Đảm bảo trang hiện tại nằm trong giới hạn
                $offset = ($currentPage - 1) * $productsPerPage;

                // Truy vấn sản phẩm theo category_id hoặc tất cả nếu không có category_id
                if ($category_id > 0) {
                    $sql = "SELECT * FROM product WHERE category_id = ? LIMIT ?, ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("iii", $category_id, $offset, $productsPerPage);
                } else {
                    $sql = "SELECT * FROM product LIMIT ?, ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("ii", $offset, $productsPerPage);
                }
                $stmt->execute();
                $result = $stmt->get_result();

                if ($category_id > 0) {
                    // Truy vấn và hiển thị tên danh mục
                    $sql_category = "SELECT name FROM category WHERE id = ?";
                    $stmt_category = $conn->prepare($sql_category);
                    $stmt_category->bind_param("i", $category_id);
                    $stmt_category->execute();
                    $result_category = $stmt_category->get_result();
                    if ($result_category->num_rows > 0) {
                        $category_row = $result_category->fetch_assoc();
                        $category_name = htmlspecialchars($category_row['name']);
                        echo '<h4 class="mt-4">' . $category_name . '</h4>';
                    }
                    $stmt_category->close();
                }

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="col-md-4 col-lg-4 col-xl-4">'; // Mỗi sản phẩm chiếm 4 cột
                        echo '    <div class="rounded position-relative fruite-item">';
                        echo '        <div class="fruite-img">';
                        echo '            <img src="' . htmlspecialchars($row["thumbnail"]) . '" class="img-fluid w-100 rounded-top" alt="">';
                        echo '        </div>';
                        echo '        <div class="p-4 border border-secondary border-top-0 rounded-bottom">';
                        echo '            <h4>' . htmlspecialchars($row["title"]) . '</h4>';
                        echo '            <p>' . htmlspecialchars($row["description"]) . '</p>';
                        echo '            <div class="d-flex justify-content-between flex-lg-wrap">';
                        $formattedPrice = number_format($row["price"], 0, ',', '.') . 'đ';
                        echo '                <p class="text-dark fs-5 fw-bold mb-0">' . $formattedPrice . '</p>';
                        echo '                <a href="product-detail.php?id=' . $row["id"] . '" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Mua Hàng</a>';
                        echo '            </div>';
                        echo '        </div>';
                        echo '    </div>';
                        echo '</div>'; // Đóng cột
                    }
                } else {
                    echo "<div class='col-12'>Không có sản phẩm nào.</div>";
                }

                $stmt->close();
                $conn->close();
                ?>
            </div> <!-- Đóng row -->
        </div> <!-- Đóng container -->

        <div class="col-12">
            <div class="pagination d-flex justify-content-center mt-5">
                <a href="?category_id=<?php echo $category_id; ?>&page=1" class="rounded">&laquo;</a>
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a href="?category_id=<?php echo $category_id; ?>&page=<?php echo $i; ?>" class="rounded <?php echo $i === $currentPage ? 'active' : ''; ?>"><?php echo $i; ?></a>
                <?php endfor; ?>
                <a href="?category_id=<?php echo $category_id; ?>&page=<?php echo $totalPages; ?>" class="rounded">&raquo;</a>
            </div>
        </div>
    </div>
</div>
</div>



<!-- Fruits Shop End-->


<!-- Footer Start -->
<?php
include '../../share/footer.php'
?> 


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