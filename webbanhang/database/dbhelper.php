<?php
require_once('config.php');
function execute($sql) {
    $conn = new mysqli(HOST, USER, '', DATABASE);

    // Kiểm tra kết nối
    if ($conn->connect_error) {
        die("Kết nối thất bại: " . $conn->connect_error);
    }

    // Đặt charset
    $conn->set_charset('utf8');

    // Thực hiện câu lệnh SQL
    $result = $conn->query($sql);

    // Kiểm tra và xử lý kết quả
    if ($result === TRUE) {
        $conn->close();
        return true; // Dành cho INSERT, UPDATE, DELETE
    } elseif ($result->num_rows > 0) {
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        $conn->close();
        return $data; // Trả về dữ liệu cho SELECT
    } else {
        $conn->close();
        return null; // Không có kết quả
    }
}
// SQL select lấy dữ liệu ra
function executeResult($sql, $isSingle=fasle){
	$data = null;
	// open connect
	$conn = mysqli_connect(HOST,DATABASE,USER,PASSWORD);
	mysqli_set_charset('utf8');

	// query
    $resultset=mysqli_query($conn,$sql);
    if($isSingle){
        $data=mysqli_fetch_array($resultset,1);
    }else{
    	$data=[];
    	while (($row=mysqli_fetch_array($resultset,1))!=null) {
    	$data[]=$row;
        }
    }
	// close connect
	mysqli_close($conn);
	return $data;
}	