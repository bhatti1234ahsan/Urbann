<?php
include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:user_login.php');
   exit();
}

if(isset($_POST['order'])){

   $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
   $number = filter_var($_POST['number'], FILTER_SANITIZE_STRING);
   $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
   $method = filter_var($_POST['method'], FILTER_SANITIZE_STRING);
   $address = filter_var($_POST['flat'] .', '. $_POST['city'] .', '. $_POST['state'] .', '.'ZIP : ' . $_POST['pin_code'], FILTER_SANITIZE_STRING);
   $total_products = $_POST['total_products'];
   $total_price = $_POST['total_price'];

   $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
   $check_cart->execute([$user_id]);

   if($check_cart->rowCount() > 0){
      $total_price += 250; // Adding delivery charge only if cart is not empty

      $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price) VALUES(?,?,?,?,?,?,?,?)");
      $insert_order->execute([$user_id, $name, $number, $email, $method, $address, $total_products, $total_price]);

      $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
      $delete_cart->execute([$user_id]);

      $message[] = 'order placed successfully!';
   }else{
      $message[] = 'your cart is empty';
   }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="icon" type="image/x-icon" href="images/favi.ico">
   <title>checkout</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="checkout-orders">

   <form action="" method="POST">

   <h3>Your Orders</h3>

      <div class="display-orders">
      <?php
         $grand_total = 0;
         $cart_items = [];
         $total_products = '';
         $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
         $select_cart->execute([$user_id]);
         if($select_cart->rowCount() > 0){
            while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
               $cart_items[] = $fetch_cart['name'].' ('.$fetch_cart['price'].' x '. $fetch_cart['quantity'].') - ';
               $total_products = implode($cart_items);
               $grand_total += ($fetch_cart['price'] * $fetch_cart['quantity']);
      ?>
         <p> <?= $fetch_cart['name']; ?> <span>(<?= 'Rs.'.$fetch_cart['price'].'/- x '. $fetch_cart['quantity']; ?>)</span> </p>
      <?php
            }
      ?>
            <input type="hidden" name="total_products" value="<?= $total_products; ?>">
            <input type="hidden" name="total_price" value="<?= $grand_total; ?>">
            <div class="grand-total">Grand Total (without delivery): <span>Rs.<?= $grand_total; ?>/-</span></div>
            <div class="grand-total">Delivery Charges: <span>Rs.250/-</span></div>
            <div class="grand-total">Final Total (with delivery): <span>Rs.<?= $grand_total + 250; ?>/-</span></div>
      <?php
         }else{
            echo '<p class="empty">your cart is empty!</p>';
         }
      ?>
      </div>

      <h3>Place Your Order</h3>

      <div class="flex">
         <div class="inputBox">
            <span>Your Name :</span>
            <input type="text" name="name" placeholder="Enter your name" class="box" maxlength="20" required>
         </div>
         <div class="inputBox">
            <span>Your Number :</span>
            <input type="tel" name="number" placeholder="Enter your number" class="box" min="0" max="99999999999999" onkeypress="if(this.value.length == 14) return false;" required>
         </div>
         <div class="inputBox">
            <span>Your Email :</span>
            <input type="email" name="email" placeholder="Enter your email" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>Payment Method :</span>
            <select name="method" class="box" required>
               <option value="cash on delivery">Cash On Delivery</option>
            </select>
         </div>
         <div class="inputBox">
            <span>Address :</span>
            <input type="text" name="flat" placeholder="e.g. House number, street number, Area" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>City :</span>
            <select name="city" class="box" required>
            <option value="Lahore">Lahore</option>
               <option value="Karachi">Karachi</option>
               <option value="Faisalabad">Faisalabad</option>
               <option value="Rawalpindi">Rawalpindi</option>
               <option value="Gujranwala">Gujranwala</option>
               <option value="Peshawar">Peshawar</option>
               <option value="Multan">Multan</option>
               <option value="Islamabad">Islamabad</option>
               <option value="Hyderabad">Hyderabad</option>
               <option value="Quetta">Quetta</option>
               <option value="Bahawalpur">Bahawalpur</option>
               <option value="Sargodha">Sargodha</option>
               <option value="Sialkot">Sialkot</option>
               <option value="Sukkur">Sukkur</option>
               <option value="Larkana">Larkana</option>
               <option value="Rahim Yar Khan">Rahim Yar Khan</option>
               <option value="Mardan">Mardan</option>
               <option value="Jhang">Jhang</option>
               <option value="Sheikhupura">Sheikhupura</option>
               <option value="Dera Ghazi Khan">Dera Ghazi Khan</option>
            </select>
         </div>
         <div class="inputBox">
            <span>Province:</span>
            <select name="state" class="box" required>
               <<option value="punjab">Punjab</option>
               <option value="Sindh">Sindh</option>
               <option value="Khyber Pakhtunkhwa">Khyber Pakhtunkhwa</option>
               <option value="Balochistan">Balochistan</option>
               <option value="Gilgit Baltistan">Gilgit Baltistan</option>
            </select>
         </div>
         <div class="inputBox">
            <span>ZIP CODE :</span>
            <input type="number" min="0" name="pin_code" placeholder="e.g. 56400" onkeypress="if(this.value.length == 6) return false;" class="box" required>
         </div>
      </div>

      <input type="submit" name="order" class="btn <?= ($grand_total > 0) ? '' : 'disabled'; ?>" value="Place Order">

   </form>

</section>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>