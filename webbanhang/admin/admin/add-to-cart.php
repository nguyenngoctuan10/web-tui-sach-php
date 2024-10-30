<?php
include '../../database/config.php';
session_start();
$conn = getConnection();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$product_id= $_POST['id'];
	$user_id = $_SESSION['user_id'];
    $quantity= $_POST['quantity'];
    $stmt = $conn->prepare("SELECT * FROM product WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();    

    if ($result->num_rows > 0) {
    	$product = $result->fetch_assoc();
    	$stmt = $conn->prepare("INSERT INTO cart (user_id, thumbnail, title, price, quantity) VALUES (?, ?, ?, ?, ?)");
    	$thumbnail = $product["thumbnail"];
    	$title = $product["title"];
    	$price = $product["price"];
    	
    	$stmt->bind_param("sssii",$user_id, $thumbnail, $title, $price, $quantity);

    	if ($stmt->execute()) {
    		echo '<div class="alert alert-success text-center"></div>';
    	} else {
    		echo '<div class="alert alert-danger text-center"></div>';
    	}
        header('Location: cart.php'); // Chuyển hướng đến trang giỏ hàng
        exit();
    }
}
?>