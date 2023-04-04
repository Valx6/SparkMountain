<?php
session_start();

if(!isset($_SESSION['username'])){
    header('Location: login.php');
}

$host = "localhost";
$user = "root";
$password = "";
$dbname = "energy";
$conn = mysqli_connect($host, $user, $password, $dbname);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

if(isset($_SESSION['username'])) {
  $username = $_SESSION['username'];

  $sql = "SELECT * FROM gebruikers WHERE username='$username' AND permission=2";
  $result = mysqli_query($conn, $sql);

  if(mysqli_num_rows($result) == 1) {
    echo "<h1>Welcome, $username!</h1>";
    echo "<h2>Add a new energy drink product:</h2>";
    echo "<form action='process_product.php' method='post'>";
    echo "<label for='product_name'>Product Name:</label>";
    echo "<input type='text' id='product_name' name='product_name'><br><br>";
    echo "<label for='product_price'>Price:</label>";
    echo "<input type='text' id='product_price' name='product_price'><br><br>";
    echo "<input type='hidden' name='product_type' value='energy_drink'>";
    echo "<input type='submit' value='Add Product'>";
    echo "</form>";
  } else {
    echo "You do not have permission to access this page.";
  }

} else {
  header("Location: login.php");
  exit();
}

mysqli_close($conn);

?>
