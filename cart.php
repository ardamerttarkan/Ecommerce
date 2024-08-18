<?php

session_start();
if(isset($_POST['add_to_cart'])){

  //Eğer kullanıcı sepete ürün eklediyse
  if(isset($_SESSION['cart'])){
    $product_array_ids = array_column($_SESSION['cart'], 'product_id');
    //Ürün sepete eklendiyse veya eklenmediyse
    if( !in_array($_POST['product_id'], $product_array_ids)){

      $product_id= $_POST['product_id'];

    $product_array = array(
      'product_id' => $_POST['product_id'],
      'product_name' => $_POST['product_name'],
      'product_price' => $_POST['product_price'],
      'product_image' => $_POST['product_image'],
      'product_quantity' => $_POST['product_quantity']
      
    );
    
    $_SESSION['cart'][$product_id] = $product_array;
    }
    //Ürün zaten eklendiyse
    else{
      echo '<script>alert("Ürün Zaten Sepette");</script>';
      }

  }
  //Sepete ilk kez ürün eklicekse
  else{
   $product_id= $_POST['product_id'];
    $product_name= $_POST['product_name'];
    $product_price= $_POST['product_price'];
    $product_image= $_POST['product_image'];
    $product_quantity= $_POST['product_quantity'];
    
    

    $product_array = array(
      'product_id' => $product_id,
      'product_name' => $product_name,
      'product_price' => $product_price,
      'product_image' => $product_image,
      'product_quantity' => $product_quantity,
      
      
    );
    
    $_SESSION['cart'][$product_id] = $product_array;
  }
  calculateTotalCart();
}

else if(isset($_POST['remove_product'])){
  //Eğer kullanıcı sepetten ürün silecekse
  
 $product_id = $_POST['product_id'];
 unset($_SESSION['cart'][$product_id]);

  calculateTotalCart();
  

}
else if(isset($_POST['edit_quantity'])){
  //Eğer kullanıcı ürün adetini değiştirecekse
  $product_id = $_POST['product_id'];
  $product_quantity = $_POST['product_quantity'];

  $product_array = $_SESSION['cart'][$product_id];

  $product_array['product_quantity'] = $product_quantity;

  $_SESSION['cart'][$product_id] = $product_array;

calculateTotalCart();


}
else if(isset($_POST['checkout'])){
  //Eğer kullanıcı alışverişi tamamlayacaksa
  if(!empty($_SESSION['cart'])){
    header('Location: checkout.php');
  }
  else{
    echo '<script>alert("Sepetinizde ürün bulunmamaktadır.");</script>';
  }
}

else{
  //echo '<script>alert("Bir hata var");</script>';
}



function calculateTotalCart(){
  $total = 0;

  foreach($_SESSION['cart'] as $key =>$value){
    $product = $_SESSION['cart'][$key];

    $price = $product['product_price'];
    $quantity = $product['product_quantity'];
    $total = $total + ($price * $quantity);
  }

  $_SESSION['total'] = $total;

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
            <a class="nav-link" href="index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="shop.php">Shop</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Blog</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="contact.php">Contact Us</a>
          </li>

          <!--İkonlar-->
          <li class="nav-item">
            <a href="cart.php"><i class="fa-brands fa-shopify"></i></a>
            <a href="account.php"><i class="fa-solid fa-user"></i></a>
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

        <!--Cart-->
        <section class="cart container my-5 py-5">
            <div class="container mt-5">
                <h2 class="font-weight-bolde">Sepetiniz</h2>
                <hr>
            </div>

            <table class="mt-5 pt-5">
                <tr>
                    <th>Ürün</th>
                    <th>Adet</th>
                    <th>Fiyat</th>
                    
                </tr>

                <?php foreach($_SESSION['cart'] as $key =>$value){ ?>

                <tr>
                <td>
                    <div class="product-info">
                    <img src="images/<?php echo $value['product_image']; ?>"/>
                    <div>
                        <p><?php echo $value['product_name']; ?></p>
                         <small><span>TL</span><?php echo $value['product_price']; ?></small>
                         <br>
                         <form method="POST" action="cart.php">
                          <input type="hidden" name="product_id" value="<?php echo $value['product_id']; ?>"/>
                         <input type="submit" name="remove_product" class="remove-btn" value="remove"/>
                          </form>
                    </div>
                </div>  
                </td>

                <td>
                    
                    <form method="POST" action="cart.php">
                    <input type="hidden" name="product_id" value="<?php echo $value['product_id']; ?>"/>
                    <input type="number" name="product_quantity" value="<?php echo $value['product_quantity']; ?>"/>
                    <input type="submit" class="edit-btn" value="edit" name="edit_quantity"/>

                    
                </td>
                <td>
                    <span>TL</span>
                    <span class="product-price"><?php echo $value['product_quantity'] * $value['product_price'] ; ?></span>
                </td>
            </tr>

                  
                <?php } ?>

           
                </table>


                <div class="cart-total">
                    <table>
                       
                        <tr>
                            <td>Toplam</td>
                            <td><?php echo $_SESSION['total']; ?></td>
                        </tr>
                    </table>
                </div>

                <div class="checkout-container">
                  <form method="POST" action="checkout.php">
                    
                    <input type="submit" class="checkout-btn" value="Onayla" name="checkout"/>
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