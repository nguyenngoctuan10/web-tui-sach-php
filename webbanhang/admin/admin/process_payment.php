<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh Toán</title>
    <style>
        /* Định dạng cho container */
        .container {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
        }

        /* Định dạng cho tiêu đề */
        h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
        }

        /* Định dạng cho đoạn văn */
        p {
            font-size: 1.2rem;
            margin-bottom: 30px;
        }

        /* Định dạng cho nút */
        .btn {
            display: inline-block;
            padding: 10px 20px;
            font-size: 1rem;
            color: #ffffff;
            background-color: #007bff; /* Màu xanh */
            border: none;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #0056b3; /* Màu xanh đậm khi hover */
        }

        /* Định dạng cho thông báo lỗi */
        .error {
            color: #dc3545; /* Màu đỏ */
        }

        /* Định dạng cho thông báo thành công */
        .success {
            color: #28a745; /* Màu xanh lá */
        }
    </style>
</head>
<body>
    <?php
    session_start();
    include '../../database/config.php';
    $conn = getConnection();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $fullname = $_POST['fullname'];
        $address = $_POST['address'];
        $phone_number = $_POST['phone_number'];
        $email = $_POST['email'];
        $user_id = $_SESSION['user_id'];
        
        $sql = "INSERT INTO orders (user_id, fullname, email, phone_number, address) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issss", $user_id, $fullname, $email, $phone_number, $address);

        if ($stmt->execute()) {
            echo "<div class='container text-center py-5 success'>";
            echo "<h1>Thanh toán thành công!</h1>";
            echo "<p>Cảm ơn bạn, $fullname! Chúng tôi đã nhận được thanh toán của bạn.</p>";
            echo "<a href='index.php' class='btn'>Quay về trang chủ</a>";
            echo "</div>";
        } else {
            echo "<div class='container text-center py-5 error'>";
            echo "<h1>Có lỗi xảy ra!</h1>";
            echo "<p>Vui lòng thử lại sau.</p>";
            echo "</div>";
        }

        $stmt->close();
    } else {
        header("Location: checkout.php");
        exit();
    }
    ?>
</body>
</html>