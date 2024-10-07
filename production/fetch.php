<?php
if (isset($_SESSION['user_id'])) {
  $ceo_id = $_SESSION['user_id'];
$total_products_counter = "SELECT COUNT(id) AS 'Total' FROM `products`WHERE ceo_id = $ceo_id";
  $products_counter_stmt = $conn->prepare($total_products_counter);
  $products_counter_stmt->execute();
  $products_counter_result = $products_counter_stmt->get_result();
  
  if ($products_counter_result->num_rows > 0) {
      $total = $products_counter_result->fetch_assoc();
      $products_counter_total = $total['Total'];
  }
}
$total_products = "SELECT COUNT(id) AS 'Total' FROM `products`";
  $products_stmt = $conn->prepare($total_products);
  $products_stmt->execute();
  $products_result = $products_stmt->get_result();
  
  if ($products_result->num_rows > 0) {
      $total = $products_result->fetch_assoc();
      $products_total = $total['Total'];
  }

$total_ceo = "SELECT COUNT(id) AS 'Total' FROM `ceo_profiles`";
  $ceo_stmt = $conn->prepare($total_ceo);
  $ceo_stmt->execute();
  $ceo_result = $ceo_stmt->get_result();
  
  if ($ceo_result->num_rows > 0) {
      $total = $ceo_result->fetch_assoc();
      $ceo_total = $total['Total'];
  }

$total_payment = "SELECT COUNT(id) AS 'Total' FROM `payments`";
  $payment_stmt = $conn->prepare($total_payment);
  $payment_stmt->execute();
  $payment_result = $payment_stmt->get_result();
  
  if ($payment_result->num_rows > 0) {
      $total = $payment_result->fetch_assoc();
      $payment_total = $total['Total'];
      $payment_total = number_format(10000 * $payment_total, 2);
  }

$total_shop_registered = "SELECT COUNT(id) AS 'Total' FROM `shop_profiles`";
  $shop_registered_stmt = $conn->prepare($total_shop_registered);
  $shop_registered_stmt->execute();
  $shop_registered_result = $shop_registered_stmt->get_result();
  
  if ($shop_registered_result->num_rows > 0) {
      $total = $shop_registered_result->fetch_assoc();
      $shop_registered_total = $total['Total'];
}

$total_shop_verified = "SELECT COUNT(id) AS 'Total' FROM `shop_profiles` WHERE verify = 1";
  $shop_verified_stmt = $conn->prepare($total_shop_verified);
  $shop_verified_stmt->execute();
  $shop_verified_result = $shop_verified_stmt->get_result();
  
  if ($shop_verified_result->num_rows > 0) {
      $total = $shop_verified_result->fetch_assoc();
      $shop_verified_total = $total['Total'];
  }

$total_shop_suspended = "SELECT COUNT(id) AS 'Total' FROM `shop_profiles` WHERE verify = 2";
  $shop_suspended_stmt = $conn->prepare($total_shop_suspended);
  $shop_suspended_stmt->execute();
  $shop_suspended_result = $shop_suspended_stmt->get_result();
  
  if ($shop_suspended_result->num_rows > 0) {
      $total = $shop_suspended_result->fetch_assoc();
      $shop_suspended_total = $total['Total'];
  }

$total_shop_pending_verified = "SELECT COUNT(id) AS 'Total' FROM `shop_profiles` WHERE verify = 0";
  $shop_pending_verified_stmt = $conn->prepare($total_shop_pending_verified);
  $shop_pending_verified_stmt->execute();
  $shop_pending_verified_result = $shop_pending_verified_stmt->get_result();
  
  if ($shop_pending_verified_result->num_rows > 0) {
      $total = $shop_pending_verified_result->fetch_assoc();
      $shop_pending_verified_total = $total['Total'];
  }
$user_id = $_SESSION['user_id'];
$total_shop = "SELECT `id`, `ceo_id`, `name`, `motto`, `address`, `email`, `phone_number`, `rc_number`, `logo`, `banner`, `created_at` FROM `shop_profiles` WHERE ceo_id = '$user_id'";
  $shop_stmt = $conn->prepare($total_shop);
  $shop_stmt->execute();
  $shop_result = $shop_stmt->get_result();
  
  if ($shop_result->num_rows > 0) {
      $total = $shop_result->fetch_assoc();
      $shop_name = $total['name'];
      $shop_motto = $total['motto'];
      $shop_address = $total['address'];
      $shop_email = $total['email']?? '';
      $shop_phone_number = $total['phone_number'];
      $shop_rc_number = $total['rc_number'];
      $shop_logo = $total['logo'];
      $shop_banner = $total['banner'];
      $shop_created_at = $total['created_at'];
  }
  
  $total_messages = "SELECT COUNT(id) AS 'Total' FROM `messages`";
  $messages_stmt = $conn->prepare($total_messages);
  $messages_stmt->execute();
  $messages_result = $messages_stmt->get_result();
  
  if ($messages_result->num_rows > 0) {
      $total = $messages_result->fetch_assoc();
      $messages_total = $total['Total'];
  }

  $total_messages_id = "SELECT COUNT(id) AS 'Total' FROM `messages` WHERE status = 0";
  $messages_id_stmt = $conn->prepare($total_messages_id);
  $messages_id_stmt->execute();
  $messages_id_result = $messages_id_stmt->get_result();
  
  if ($messages_id_result->num_rows > 0) {
      $total = $messages_id_result->fetch_assoc();
      $messages_id_total = $total['Total'];
  }