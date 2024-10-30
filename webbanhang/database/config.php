<?php
define('HOST', 'localhost');
define('DATABASE', 'webbanhang');
define('USER', 'root');
define('PASSWORD', '');

// Hàm tạo kết nối
function getConnection() {
    $conn = new mysqli(HOST, USER, PASSWORD, DATABASE);
    
    // Kiểm tra kết nối
    if ($conn->connect_error) {
        die("Kết nối thất bại: " . $conn->connect_error);
    }
    
    return $conn;
}
?>