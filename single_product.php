<?php
ini_set("display_errors", "1");
ini_set("display_startup_errors", "1");
error_reporting(E_ALL);

include('server/connection.php');

if(isset($_GET['product_id'])){

  $product_id = $_GET['product_id'];
 
  $stmt = $conn ->prepare("SELECT *FROM products  WHERE product_id =?");
  

  $stmt->bind_param("i", $product_id);

  $stmt->execute();
  
  $product= $result = $stmt->get_result();
  


}
else{
    header('Location: index.php');

}

?>




m

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

        <!--Single Product-->
      <section class=" container single-product my-5 pt-5">
        <div class="row mt-5">

        <?php while($row = $product->fetch_assoc()){ ?>
          <div class="col-lg-5 col-md-6 col-sm-12">
                <img class="img-fluid w-100 pb-1" src="images/<?php echo $row['product_image'] ?>" id="mainImg"/>
            <div class="small-img-group">
            <div class="small-img-col">
                <img src="images/<?php echo $row['product_image'] ?>" width="100%" class="small-img"/>
            </div>
            <div class="small-img-col">
                <img src="images/<?php echo $row['product_image2'] ?>" width="100%"  class="small-img"/>
            </div>
            <div class="small-img-col">
                <img src="images/<?php echo $row['product_image3'] ?>" width="100%" class="small-img"/>
             </div>
            <div class="small-img-col">
                 <img src="images/<?php echo $row['product_image4'] ?>"width="100%"  class="small-img"/>
             </div>
            </div>
        </div>
       

        <div class="col-lg-6 col-md-12 col-12">
            <h6> Erkek Sweatshirt</h6>
            <h3 class="py-4"><?php echo $row['product_name'] ?></h3>
            <h2><?php echo $row['product_price'] ?></h2>
            
            <form method="POST" action="cart.php">
            <input type="hidden" name="product_id" value="<?php echo $row['product_id'] ?>">
            <input type="hidden" name="product_image" value="<?php echo $row['product_image'] ?>">
            <input type="hidden" name="product_name" value="<?php echo $row['product_name'] ?>">
            <input type="hidden" name="product_price" value="<?php echo $row['product_price'] ?>">
            
            <!--Quantity=Miktar-->
            <input type="number"  name="product_quantity" value="1"/>
            <button class="buy-btn" type="submit" name="add_to_cart">Sepete Ekle</button>
             
          </form>
             <h4 class="mt-5 mb-5">Ürün Detayları</h4> 
             <span><?php echo $row['product_description'] ?></span>
            </div>
          

            <?php } ?>
        </div>
      </section>

      <!--Releated Products-->
      <section id="releated-products" class="my-5 pb-5">
        <div class="container text-center mt-5 py-5">
          <h3>Öne Çıkan Ürünler</h3>
          <hr>
          <p>Öne Çıkan Ürünlerimize Bir Göz Atın!</p>
        </div>
        <div class="row mx-auto container-fluid">
          <!--One-->
          <div class="product text-center col-lg-3 col-md-4 col-sm-12">
            <img class="img-fluid mb-3" src="images/shoe.jpg"/>
        <div class="star">
          <i class="fa-solid fa-star"></i>
          <i class="fa-solid fa-star"></i>
          <i class="fa-solid fa-star"></i>
          <i class="fa-solid fa-star"></i>
          <i class="fa-solid fa-star"></i>

        </div>
            <h5 class="p-name">Spor Ayakkabısı</h5>
            <h4 class="p-price">₺2.999</h4>
            <button class="buy-btn">Sepete Ekle</button>
          </div>
          <!--Two-->
          <div class="product text-center col-lg-3 col-md-4 col-sm-12">
            <img class="img-fluid mb-3" src="images/tshirt.jpg"/>
        <div class="star">
          <i class="fa-solid fa-star"></i>
          <i class="fa-solid fa-star"></i>
          <i class="fa-solid fa-star"></i>
          <i class="fa-solid fa-star"></i>
          <i class="fa-solid fa-star"></i>

        </div>
            <h5 class="p-name">Tişört</h5>
            <h4 class="p-price">₺199</h4>
            <button class="buy-btn">Sepete Ekle</button>
          </div>
          <!--Three-->
          <div class="product text-center col-lg-3 col-md-4 col-sm-12">
            <img class="img-fluid mb-3" src="images/jean.jpg"/>
        <div class="star">
          <i class="fa-solid fa-star"></i>
          <i class="fa-solid fa-star"></i>
          <i class="fa-solid fa-star"></i>
          <i class="fa-solid fa-star"></i>
          <i class="fa-solid fa-star"></i>

        </div>
            <h5 class="p-name">Pantolon</h5>
            <h4 class="p-price">₺999</h4>
            <button class="buy-btn">Sepete Ekle</button>
          </div>
          <!--Four-->
          <div class="product text-center col-lg-3 col-md-4 col-sm-12">
            <img class="img-fluid mb-3" src="images/çorap.jpg"/>
        <div class="star">
          <i class="fa-solid fa-star"></i>
          <i class="fa-solid fa-star"></i>
          <i class="fa-solid fa-star"></i>
          <i class="fa-solid fa-star"></i>
          <i class="fa-solid fa-star"></i>

        </div>
            <h5 class="p-name">Çorap</h5>
            <h4 class="p-price">₺99</h4>
            <button class="buy-btn">Sepete Ekle</button>
          </div>

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
<script>

    var mainImg = document.getElementById('mainImg');
    var smallImg = document.getElementsByClassName('small-img');
    
    for(let i=0; i<smallImg.length; i++){
        smallImg[i].onclick = function(){
            mainImg.src = smallImg[i].src;
        }
    }
</script>

</body>
</html>m