<?php session_start() ?>
<?php require_once('layout/header.php'); ?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
</head>
<style>

    form {
        display: flex;
        flex-flow: column;
        justify-content: center;
        align-items: center;
    }

    .form-group {
        padding: 10px;
        width: 650px;
    }

    .form-group input {
        padding: 5px 0;
        width: 100%;
    }

    textarea {
        width: 100%;
    }

    button {
        padding: 10px 50px;
        border-radius: 5px;
        color: white;
        background-color: red;
        border: none;
        outline: 0;
    }

    button:hover {
        opacity: 0.7;
        cursor: pointer;
    }

    center {
        font-size: 20px;
        font-weight: bold;
        color: green;
        padding: 20px;
    }
</style>

<body>
    <h2 style="text-align: center;">Hãy liên hệ với chúng tôi nếu các bạn gặp các vấn đề trên Website</h2>
    <form method="POST" action="">
        <div class="form-group">
            <label>Tên của bạn:</label>
            <input type="text" name="name" required="required" />
        </div>
        <div class="form-group">
            <label>Gửi đến gmail:</label>
            <input type="email" name="email" required="required" />
        </div>
        <div class="form-group">
            <label>Tên Email</label>
            <input type="text" name="subject" required="required" />
        </div>
        <div class="form-group">
            <label>Nội dung email</label>
            <textarea name="message" id="" cols="30" rows="10"></textarea>
        </div>
        <button name="send"> Send</button>
    </form>

    <?php
    //nhúng thư viện vào để dùng
    require "PHPMailer-master/src/PHPMailer.php";
    require "PHPMailer-master/src/SMTP.php";
    require 'PHPMailer-master/src/Exception.php';

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $name = $_POST['name']; // lấy ra tên của bạn
        $email = $_POST['email']; // Email cần gửi đến
        $subject = $_POST['subject']; // Tiêu đề email
        $message = $_POST['message']; // Nội dung email
        $mail = new PHPMailer\PHPMailer\PHPMailer(true);  //true: cho phép các trường hợp ngoại lệ

        // TRY có thể nó sẽ xảy ra ngoại lệ
        try {
            //Server settings
            $mail->isSMTP(); // gửi mail SMTP
            $mail->CharSet  = "utf-8";
            $mail->Host = 'smtp.gmail.com';  // khai báo SMTP servers
            $mail->SMTPAuth = true; // Enable authentication
            $nguoigui = 'hellook332@gmail.com'; // Tài khoản Email
            $matkhau = 'thanh1010'; // Mật khẩu Email
            $mail->SMTPSecure = 'ssl';  // encryption TLS/SSL 
            $mail->Port = 465;  // Port kết nối: khai báo 465 hoặc 587                


            // Recipients - Người nhận
            $tennguoigui = $name; // Tên người gửi lấy từ form nhập
            $mail->Username = $nguoigui; // SMTP username
            $mail->Password = $matkhau;   // SMTP password
            $mail->setFrom($nguoigui, $tennguoigui); //mail và tên người nhận 
            $to = $email; // Email cần gửi đến lấy từ form nhập
            $to_name = "Nguyễn Đăng Thành"; // Tên người cần gửi đến

            // Content 
            $mail->addAddress($to, $to_name); //mail và tên người nhận  
            $mail->isHTML(true);  // Khai báo nội dung email hiển thị định dạng html
            $mail->Subject = $subject; // Tiêu đề email
            $mail->Body = $message; // Nội dung email

            $mail->send(); // Tiến hành gửi thư
            echo '<center>Đã gửi mail xong</center>';
        }
        // nếu ở trên lỗi thì CATCH sẽ chạy
        catch (Exception $e) {
            echo 'Mail không gửi được. Lỗi: ', $mail->ErrorInfo;
        }
    }
    ?>
    
</body>
<?php require_once('layout/footer.php'); ?>

</html>