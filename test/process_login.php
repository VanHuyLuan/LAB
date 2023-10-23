<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ biểu mẫu đăng nhập
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Kết nối đến cơ sở dữ liệu
    $dbHost = "127.0.0.1";
    $dbUser = "root";
    $dbPassword = "07122003";
    $dbName = "web";
    $conn = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);

    if ($conn->connect_error) {
        die("Kết nối cơ sở dữ liệu thất bại: " . $conn->connect_error);
    }
    else
    {
        die("ket noi thanh cong");
    }

    // Thực hiện truy vấn SQL để lấy thông tin tài khoản dựa trên email
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $hashedPassword = $row["password"];
            // Kiểm tra mật khẩu băm
            if (password_verify($password, $hashedPassword)) {
                // Đăng nhập thành công, có thể thực hiện chuyển hướng hoặc thông báo
                echo "Đăng nhập thành công!";
            } else {
                // Đăng nhập thất bại, thông báo lỗi mật khẩu
                echo "Mật khẩu không chính xác!";
            }
        } else {
            // Đăng nhập thất bại, thông báo email không tồn tại
            echo "Email không tồn tại!";
        }
    } else {
        // Đăng nhập thất bại, thông báo lỗi
        echo "Đăng nhập thất bại: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    // Nếu không phải là yêu cầu POST, chuyển hướng về trang đăng nhập
    header("Location: login.html");
    exit();
}
?>
