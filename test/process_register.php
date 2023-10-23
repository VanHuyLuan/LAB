<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ biểu mẫu đăng ký
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // Hash mật khẩu

    // Kết nối đến cơ sở dữ liệu
    $dbHost = "127.0.0.1";
    $dbUser = "root";
    $dbPassword = "07122003";
    $dbName = "web";
    $conn = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);

    // Kiểm tra kết nối
    if ($conn->connect_error) {
        die("Kết nối cơ sở dữ liệu thất bại: " . $conn->connect_error);
    }

    // Thêm tài khoản mới vào cơ sở dữ liệu
    $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $username, $email, $password);

    if ($stmt->execute()) {
        // Đăng ký thành công, có thể thực hiện chuyển hướng hoặc thông báo
        echo "Đăng ký thành công!";
    } else {
        // Đăng ký thất bại, thông báo lỗi
        echo "Đăng ký thất bại: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    // Nếu không phải là yêu cầu POST, chuyển hướng về trang đăng ký
    header("Location: register.html");
    exit();
}
?>
