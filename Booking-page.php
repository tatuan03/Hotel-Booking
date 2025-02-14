<?php
include 'connect.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    setcookie('user_id', create_unique_id(), time() + 60 * 60 * 24 * 30, '/');
    header('location:index.php');
    exit();
}


if (isset($_POST['cancel'])) {
    $booking_id = filter_var($_POST['booking_id'], FILTER_SANITIZE_STRING);

    $verify_booking = $conn->prepare("SELECT * FROM `bookings` WHERE booking_id = ?");
    $verify_booking->execute([$booking_id]);

    if ($verify_booking->rowCount() > 0) {
        $delete_booking = $conn->prepare("DELETE FROM `bookings` WHERE booking_id = ?");
        $delete_booking->execute([$booking_id]);
        $success_msg[] = 'booking cancelled successfully!';
    } else {
        $warning_msg[] = 'booking cancelled already!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>bookings</title>

   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
   <link rel="stylesheet" href="./style.css">
</head>
<body>

<?php include 'user_header.php'; ?>

<!-- booking section starts  -->

<section class="bookings">
   <h1 class="heading">my bookings</h1>
   <div class="box-container">
   <?php
      $select_bookings = $conn->prepare("SELECT * FROM `bookings` WHERE user_id = ?");
      $select_bookings->execute([$user_id]);
      if ($select_bookings->rowCount() > 0) {
         while ($fetch_booking = $select_bookings->fetch(PDO::FETCH_ASSOC)) {
            $check_in_date = new DateTime($fetch_booking['check_in']);
            $check_out_date = new DateTime($fetch_booking['check_out']);
            $interval = $check_in_date->diff($check_out_date);
            $total_days = $interval->days + 1;
            $total_payment = $total_days * 200000;
   ?>
   <div class="box">
      <p>name : <span><?= htmlspecialchars($fetch_booking['name']); ?></span></p>
      <p>email : <span><?= htmlspecialchars($fetch_booking['email']); ?></span></p>
      <p>number : <span><?= htmlspecialchars($fetch_booking['number']); ?></span></p>
      <p>check in : <span><?= htmlspecialchars($fetch_booking['check_in']); ?></span></p>
      <p>check out : <span><?= htmlspecialchars($fetch_booking['check_out']); ?></span></p>
      <p>total days : <span><?= $total_days; ?></span></p>
      <p>rooms : <span><?= htmlspecialchars($fetch_booking['rooms']); ?></span></p>
      <p>adults : <span><?= htmlspecialchars($fetch_booking['adults']); ?></span></p>
      <p>childs : <span><?= htmlspecialchars($fetch_booking['childs']); ?></span></p>
      <form action="" method="POST">
         <input type="hidden" name="booking_id" value="<?= htmlspecialchars($fetch_booking['booking_id']); ?>">
         <input type="hidden" name="name" value="<?= htmlspecialchars($fetch_booking['name']); ?>">
         <input type="submit" value="Cancel booking" name="cancel" class="btn" onclick="return confirm('Cancel this booking?');">
      </form>
      <a href="./vnpay_php/index.php?total_days=<?= $total_days; ?>&total_payment=<?= $total_payment; ?>">
         <button class="btn" >Pay</button>
      </a>
      <a href="service.php?name=<?= urlencode($fetch_booking['name']); ?>&booking_id=<?= htmlspecialchars($fetch_booking['booking_id']); ?>">
      <button class="btn" >Add Service</button>
      </a>
      </a>
   </div>
   <?php
         }
      } else {
   ?>   
   <div class="box" style="text-align: center;">
      <p style="padding-bottom: .5rem; text-transform:capitalize;">no bookings found!</p>
      <a href="index.php#reservation" class="btn">book new</a>
   </div>
   <?php
      }
   ?>
   </div>
</section>

<!-- booking section ends -->

<?php include './footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="./js/script.js"></script>

<?php include 'message.php'; ?>

</body>
</html>
