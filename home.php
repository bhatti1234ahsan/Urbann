<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

include 'components/wishlist_cart.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="icon" type="image/x-icon" href="images/favi.ico">
   <title>UrbanStitch | Home</title>

   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="./css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<div class="home-bg" style=" background-image: url('images/Background.jpg')  ;background-repeat: no-repeat; background-size: cover;
   background-position: center" >

<section class="home">

   <div class="swiper home-slider" >
   
   <div class="swiper-wrapper" >

      <div class="swiper-slide slide">
         <div class="image">
            <img src="images\mens.png" alt="">
         </div>
         <div class="content">
            <span style="color: black">Upto 50% Off</span>
            <h3 style="color: black">Men's Outfits</h3>
            <a href="category.php?category=suit" class="btn">Shop Now</a>
         </div>
      </div>

      <div class="swiper-slide slide">
         <div class="image">
            <img src="images/home-img-2.png" alt="">
         </div>
         <div class="content">
            <span style="color: black">Upto 50% off</span>
            <h3 style="color: black">Men's Watches</h3>
            <a href="category.php?category=watch" class="btn">Shop Now</a>
         </div>
      </div>

      <div class="swiper-slide slide">
         <div class="image">
            <img src="images/perfumeee.png" alt="">
         </div>
         <div class="content">
            <span style="color: black">upto 50% off</span>
            <h3 style="color: black">Men's Perfumes</h3>
            <a href="category.php?category=perfume" class="btn">Shop Now</a>
         </div>
      </div>

   </div>

      <div class="swiper-pagination"></div>

   </div>

</section>

</div>

<section class="category">

   <h1 class="heading">Shop by Category</h1>

   <div class="swiper category-slider">

   <div class="swiper-wrapper">

   <a href="category.php?category=suit" class="swiper-slide slide">
      <img src="images/suit.png" alt="">
      <h3>Men's Suit</h3>
   </a>

   <a href="category.php?category=shoes" class="swiper-slide slide">
      <img src="images/shoe.png" alt="">
      <h3>Shoes</h3>
   </a>

   <a href="category.php?category=shirt" class="swiper-slide slide">
      <img src="images/shirt.png" alt="">
      <h3>Men's Shirts</h3>
   </a>

   <a href="category.php?category=perfume" class="swiper-slide slide">
      <img src="images/perfume.png" alt="">
      <h3>Men's Perfumes</h3>
   </a>

   <a href="category.php?category=jacket" class="swiper-slide slide">
      <img src="images/suit.png" alt="">
      <h3>Men's Jacket</h3>
   </a>

   <a href="category.php?category=pant" class="swiper-slide slide">
      <img src="images/pant.png" alt="">
      <h3>Men's Pants</h3>
   </a>

   <a href="category.php?category=kurta" class="swiper-slide slide">
      <img src="images/kurta.png" alt="">
      <h3>Men's Kurta</h3>
   </a>

   
   <a href="category.php?category=salwar" class="swiper-slide slide">
      <img src="images/kurta.png" alt="">
      <h3> Salwar Kameez</h3>
   </a>

   

   <a href="category.php?category=accessories" class="swiper-slide slide">
      <img src="images/accessories.png" alt="">
      <h3>Accessories</h3>
   </a>


  

   <a href="category.php?category=watch" class="swiper-slide slide">
      <img src="images/icon-8.png" alt="">
      <h3>Watch</h3>
   </a>

   </div>

   <div class="swiper-pagination"></div>

   </div>

</section>

<section class="home-products">

   <h1 class="heading">Latest products</h1>

   <div class="swiper products-slider" >

   <div class="swiper-wrapper" >

   <?php
     $select_products = $conn->prepare("SELECT * FROM `products` LIMIT 6"); 
     $select_products->execute();
     if($select_products->rowCount() > 0){
      while($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)){
   ?>
   <form action="" method="post" class="swiper-slide slide">
      <input type="hidden" name="pid" value="<?= $fetch_product['id']; ?>">
      <input type="hidden" name="name" value="<?= $fetch_product['name']; ?>">
      <input type="hidden" name="price" value="<?= $fetch_product['price']; ?>">
      <input type="hidden" name="image" value="<?= $fetch_product['image_01']; ?>">
      <button class="fas fa-heart" type="submit" name="add_to_wishlist"></button>
      <a href="quick_view.php?pid=<?= $fetch_product['id']; ?>" class="fas fa-eye"></a>
      <img src="uploaded_img/<?= $fetch_product['image_01']; ?>" alt="">
      <div class="name"><?= $fetch_product['name']; ?></div>
      <div class="flex">
         <div class="price"><span>Rs.</span><?= $fetch_product['price']; ?><span>/-</span></div>
         <input type="number" name="qty" class="qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="1">
      </div>
      <input type="submit" value="add to cart" class="btn" name="add_to_cart">
   </form>
   <?php
      }
   }else{
      echo '<p class="empty">no products added yet!</p>';
   }
   ?>

   </div>

   <div class="swiper-pagination"></div>

   </div>

</section>









<?php include 'components/footer.php'; ?>

<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<script src="/js/script.js"></script>

<script>

var swiper = new Swiper(".home-slider", {
   loop:true,
   spaceBetween: 20,
   pagination: {
      el: ".swiper-pagination",
      clickable:true,
    },
});

 var swiper = new Swiper(".category-slider", {
   loop:true,
   spaceBetween: 20,
   pagination: {
      el: ".swiper-pagination",
      clickable:true,
   },
   breakpoints: {
      0: {
         slidesPerView: 2,
       },
      650: {
        slidesPerView: 3,
      },
      768: {
        slidesPerView: 4,
      },
      1024: {
        slidesPerView: 5,
      },
   },
});

var swiper = new Swiper(".products-slider", {
   loop:true,
   spaceBetween: 20,
   pagination: {
      el: ".swiper-pagination",
      clickable:true,
   },
   breakpoints: {
      550: {
        slidesPerView: 2,
      },
      768: {
        slidesPerView: 2,
      },
      1024: {
        slidesPerView: 3,
      },
   },
});

</script>

</body>
</html>