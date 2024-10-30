<?php
include '../../database/config.php';
session_start();
$conn = getConnection();


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Kiểm tra xem người dùng đã đăng nhập chưa
    if (!isset($_SESSION['user_id'])) {
        echo '<div class="alert alert-danger text-center">Bạn cần đăng nhập để thực hiện thao tác này.</div>';
        exit();
    }

    // Lấy cart_id từ POST
    $cart_id = $_POST['cart_id']; // Chỉnh sửa từ 'id' thành 'cart_id'
    echo $cart_id;
    $user_id = $_SESSION['user_id'];
    
    // Kiểm tra xem sản phẩm có trong giỏ hàng của người dùng không
    $stmt = $conn->prepare("SELECT * FROM cart WHERE cart_id = ? AND user_id = ?");
    if ($stmt === false) {
        echo '<div class="alert alert-danger text-center">Có lỗi xảy ra khi chuẩn bị truy vấn: ' . $conn->error . '</div>';
        exit();
    }

    $stmt->bind_param("ii", $cart_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Xóa sản phẩm khỏi giỏ hàng
        $stmt = $conn->prepare("DELETE FROM cart WHERE cart_id = ? AND user_id = ?");
        if ($stmt === false) {
            echo '<div class="alert alert-danger text-center">Có lỗi xảy ra khi chuẩn bị truy vấn xóa: ' . $conn->error . '</div>';
            exit();
        }

        $stmt->bind_param("ii", $cart_id, $user_id);

        if ($stmt->execute()) {
            echo '<div class="alert alert-success text-center">Sản phẩm đã được xóa khỏi giỏ hàng.</div>';
        } else {
            echo '<div class="alert alert-danger text-center">Có lỗi xảy ra khi xóa sản phẩm: ' . $stmt->error . '</div>';
        }
    } else {
        echo '<div class="alert alert-warning text-center">Sản phẩm không tồn tại trong giỏ hàng.</div>';
    }

    
    header('Location: cart.php'); 
    exit();
}
?>