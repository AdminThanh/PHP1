<?php
require_once('../database/config.php');
require_once('../database/dbhelper.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <!-- jQuery library -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <!-- Popper JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <!-- Latest compiled JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="plugin/fontawesome/css/all.css">

  <link rel="stylesheet" href="header.css">
  <title>Đăng ký tài khoản</title>
</head>

<body>
  <div id="wrapper" style="padding-bottom: 4rem;">
    <header>
      <div class="container">
        <section class="logo">
          <a href="../index.php"><img src="../images/logo-grabfood.svg" alt=""></a>
        </section>
        <nav>
          <ul>
            <li><a href="../index.php">Trang chủ</a></li>
            <li class="nav-cha">
              <a href="../thucdon.php?page=thucdon">Thực đơn</a>
              <ul class="nav-con">
                <?php
                $sql = "SELECT * FROM category";
                $result = executeResult($sql);
                foreach ($result as $item) {
                  echo '<li><a href="../thucdon.php?id_category=' . $item['id'] . '">' . $item['name'] . '</a></li>';
                }
                ?>
                <!-- <li><a href="thucdon.php?page=trasua">Trà sữa</a></li>
                                <li><a href="thucdon.php?page=monannhe">Món ăn nhẹ</a></li>
                                <li><a href="thucdon.php?page=banhmi">Bánh mì</a></li>
                                <li><a href="thucdon.php?page=caphe">Cà phê</a></li> -->
              </ul>
            </li>
            <li><a href="../about.php">Về chúng tôi</a></li>
            <li><a href="../sendMail.php">Liên hệ</a></li>
          </ul>
        </nav>
        <section class="menu-right">
          <div class="cart">
            <a href="../cart.php"><img src="../images/icon/cart.svg" alt=""></a>
            <?php
            $cart = [];
            if (isset($_COOKIE['cart'])) {
              $json = $_COOKIE['cart'];
              $cart = json_decode($json, true);
            }
            $count = 0;
            foreach ($cart as $item) {
              $count += $item['num']; // đếm tổng số item
            }
            ?>
          </div>
          <div class="login">
            <?php
            if (isset($_COOKIE['username'])) {
              echo '<a style="color:black;" href="">' . $_COOKIE['username'] . '</a>
                            <div class="logout">
                                <a href="changePass.php"><i class="fas fa-exchange-alt"></i>Đổi mật khẩu</a> <br>
                                <a href="logout.php"><i class="fas fa-sign-out-alt"></i>Đăng xuất</a>
                            </div>
                            ';
            } else {
              echo '<a href="login.php"">Đăng nhập</a>';
            }

            ?>


          </div>
        </section>
      </div>
    </header>
    <div class="container">
      <form action="reg.php" method="POST">
        <h1 style="text-align: center;">Đăng ký hệ thống</h1>
        <div class="form-group">
          <label for="">Họ và tên:</label>
          <input type="text" name="name" class="form-control" placeholder="Họ và tên" required="required">
        </div>
        <div class="form-group">
          <label for="">Tài khoản:</label>
          <input type="text" name="username" class="form-control" placeholder="Tài khoản" required="required">
        </div>
        <div class="form-group">
          <label for="">Mật khẩu:</label>
          <input type="password" name="password" class="form-control" placeholder="Mật khẩu" required="required">
        </div>
        <div class="form-group">
          <label for="">Nhập lại mật khẩu:</label>
          <input type="password" name="repassword" class="form-control" placeholder="Nhập lại mật khẩu" required="required">
        </div>
        <div class="form-group">
          <label for="">Số điện thoại:</label>
          <input type="text" name="phone" class="form-control" placeholder="Số điện thoại" required="required">
        </div>
        <div class="form-group">
          <label for="">Email:</label>
          <input type="email" name="email" class="form-control" placeholder="Email" required="required">
        </div>
        <!-- <div class="form-check">
          <input type="checkbox" class="form-check-input" id="exampleCheck1">
          <label class="form-check-label" for="exampleCheck1">Check me out</label>
        </div> -->
        <div class="form-group">
          <input type="submit" name="submit" class="btn btn-primary" value="Đăng ký">
          <p style="padding-top: 1rem;">Bạn đã có tài khoản? <a href="login.php">Đăng nhập</a></p>
        </div>
      </form>
    </div>
  </div>

  <?php
  require_once('../database/config.php');
  require_once('../database/dbhelper.php');
  if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['submit']) && $_POST['name'] != "" && $_POST['username'] != "" && $_POST['password'] != "" && $_POST['phone'] != "" && $_POST['email'] != "") {
      $name = $_POST['name'];
      $username = $_POST['username'];
      $pass = $_POST['password'];
      $repass = $_POST['repassword'];
      $phone = $_POST['phone'];
      $email = $_POST['email'];
      //kiểm tra trùng paswword không
      if ($pass != $repass) {
        echo '<script language="javascript">
                    alert("Nhập không trùng mật khẩu, vui lòng đăng ký lại!");
                    window.location = "reg.php";
              </script>';
        die();
      }
      //kiểm tra username
      $sql = "SELECT * FROM user where username = '$username' OR email='$email'";
      $conn = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);
      $result = mysqli_query($conn, $sql);
      if (mysqli_num_rows($result) > 0) {
        echo '<script language="javascript">
                 alert("Tài khoản hoặc Email đã được sử dụng!");
                 window.location = "reg.php";
             </script>';
        die();
      }
      $sql = 'INSERT INTO user(hoten,username,password,phone,email) values ("' . $name . '","' . $username . '","' . $pass . '","' . $phone . '","' . $email . '")';
      execute($sql);
      echo '<script language="javascript">
                alert("Bạn đăng ký thành công!");
                window.location = "login.php";
             </script>';
    } else {
      echo '<script language="javascript">
    alert("hãy nhập đủ thông tin!");
    window.location = "reg.php";
    </script>';
    }
  }
  ?>

</body>

</html>