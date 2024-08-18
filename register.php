<?php

session_start();

include('server/connection.php');

if(isset($_POST['register'])){

  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $conf_password = $_POST['conf_password'];

  if($password !== $conf_password){
    header('location: register.php?error=Şifreler uyuşmuyor');
  }

  else if(strlen($password) < 6){
    header('location: register.php?error=Şifre en az 6 karakter olmalıdır');
  }

  else{
    $stmt1 = $conn->prepare("SELECT count(*) FROM users WHERE user_email = ?");
$stmt1->bind_param('s', $email);
$stmt1->execute();
$stmt1->bind_result($num_rows);
$stmt1->store_result();
$stmt1->fetch();

if($num_rows != 0){
  header('location: register.php?error=Email zaten kullanılıyor');
}
else{
  $stmt = $conn->prepare("INSERT INTO users(user_name, user_email, user_password)
  VALUES(?,?,?)");

$stmt->bind_param('sss', $name, $email, md5($password));
if($stmt->execute()){

  $_SESSION['user_email'] = $email;
  $_SESSION['user_name'] = $name;
  $_SESSION['logged_in'] = true;
  header('location:account.php?register=Kayıt başarılı');
}
else{
  header('location:register.php?error=Hesap oluşturulamadı');
}
}

 }

}

else if(isset($_SESSION['logged_in'])){
  header('location:account.php');
  exit;
}







?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-body-tertiary py-3 fixed-top">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse nav-buttons" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <!--<li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#">Home</a>
            </li>-->
            <li class="nav-item">
              <a class="nav-link" href="index.html">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="shop.html">Shop</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Blog</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="contact.html">Contact Us</a>
            </li>

            <!--İkonlar-->
            <li class="nav-item">
              <a href="cart.html"><i class="fa-brands fa-shopify"></i></a>
              <a href="account.html"><i class="fa-solid fa-user"></i></a>
            </li>
            

            <!--<li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Dropdown
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Action</a></li>
                <li><a class="dropdown-item" href="#">Another action</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="#">Something else here</a></li>
              </ul>
            </li>-->
            <!--<li class="nav-item">
              <a class="nav-link disabled" aria-disabled="true">Disabled</a>
            </li>-->
          </ul>
          <!--<form class="d-flex" role="search">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Search</button>
          </form>-->
        </div>
      </div>
    </nav>

        <!-- Register -->

        <section class="my-5 py-5">
            <div class="container text-center mt-3 pt-5">
                <h2 class="form-weight-bold">Üye Ol</h2>
                <hr class="mx-auto">
            </div>
            <div class="mx-auto container">
                <form id="register-form" method="POST" action="register.php">
                    <p style="color:red;"><?php if(isset($_GET['error'])){ echo $_GET['error']; }?></p>
                <div class="form-group">
                        <label>Ad</label>
                        <input type="text" class="form-control" id="register-name" name="name" placeholder="Ad" required/>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" id="register-email" name="email" placeholder="Email" required/>
                    </div>
                    <div class="form-group">
                        <label>Şifre</label>
                        <input type="password" class="form-control" id="register-password" name="password" placeholder="Şifre" required/>
                    </div>
                    <div class="form-group">
                        <label>Şifreyi Tekrar Girin</label>
                        <input type="password" class="form-control" id="register-conf_password" name="conf_password" placeholder="Şifre Tekrarı" required/>
                    </div>
                    <div class="form-group">
                        
                        <input type="submit" class="btn" id="register-btn" name="register" value="Üye Ol"/>
                    </div>
                    <div class="form-group">
                        <a id="login-url" href="login.php" class="btn">Zaten Bir Hesabınız Var Mı? Giriş Yap</a>
                    </div>
                </form>
            </div>
            
        </section>





        <!--Footer-->
      <footer class="mt-5 py-5">
        <div class="row container mx-auto pt-5">
          <div class="footer-one col-lg-3 col-md-6 col-sm-12">
            <img src=""/>
            
          </div>
          <div class="footer-one col-lg-3 col-md-6 col-sm-12">
            <h5 class="pb-2">Ürünler</h5>
            <ul class="text-uppercase">
              <li><a href="#">Erkek Giyim</a></li>
              <li><a href="#">Kadın Giyim</a>  </li>
              <li><a href="#">Çocuk</a></li>
              <li><a href="#">Aksesuar</a></li>
              
            </ul>
        </div>

        <div class="footer-one col-lg-3 col-md-6 col-sm-12">
          <h5 class="pb-2">Bize Ulaşın</h5>
          <div>
            <h6 class="text-uppercase">Adres</h6>
            <p>İstanbul, Türkiye</p>
          </div>
            <div>
              <h6 class="text-uppercase">Telefon</h6>
              <p>+90 5xx xxx xx xx</p>
            </div>
            <div>
              <h6 class="text-uppercase">Email</h6>
              <p>info@gmail.com</p>
            </div>
          </div>

          <div class="footer-one col-lg-3 col-md-6 col-sm-12">
            <h5 class="pb-2">sosyal Medya</h5>
            <div class="row">
              <div class="col-3">
                <i class="fa-brands fa-facebook"></i>
              </div>
              <div class="col-3">
                <i class="fa-brands fa-instagram"></i>
              </div>
              <div class="col-3">
                <i class="fa-brands fa-twitter"></i>
              </div>
              <div class="col-3">
                <i class="fa-brands fa-linkedin"></i>
              </div>
            </div>
         </div> 
        <div class="copyright mt-5">
          <div class="row container mx-auto">
            <div class="col-lg-6 col-md-6 col-sm-12 mb-4">
              <p>© 2024 All Rights Reserved</p>
            </div>
          </div>
        </div>

      </footer>

      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script> 
    </body>
    </html>