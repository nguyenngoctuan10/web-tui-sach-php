<?php
  include '../../database/config.php'; // Kết nối cơ sở dữ liệu
                $conn = getConnection();

// Lấy ID danh mục từ URL
$category_id = isset($_GET['category_id']) ? intval($_GET['category_id']) : 0;

// Lấy sản phẩm theo danh mục
$sql = "SELECT * FROM product WHERE category_id = $category_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo '<ul class="list-unstyled">';
    while ($row = $result->fetch_assoc()) {
        echo '<li>' . $row["category_id"] . '</li>';
    }
    echo '</ul>';
} else {
    echo "Không có sản phẩm nào trong danh mục này.";
}
$conn->close();
?>