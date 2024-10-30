<?php
session_start(); // Bắt đầu phiên

// Xóa tất cả các biến trong session
session_unset();

// Hủy phiên
session_destroy();

// Chuyển hướng về trang đăng nhập
header('Location: index.php');
exit();
?>