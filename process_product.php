<?php
session_start();

if(!isset($_SESSION['username'])){
    header('Location: login.php');
}

// Set up connection to database
$host = "localhost";
$user = "root";
$password = "";
$dbname = "energy";
$conn = mysqli_connect($host, $user, $password, $dbname);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Check if user is already logged in
if(isset($_SESSION['username'])) {
  $username = $_SESSION['username'];

  // Check if user is an administrator
  $sql = "SELECT * FROM users WHERE username='$username' AND is_admin=1";
  $result = mysqli_query($conn, $sql);

  if(mysqli_num_rows($result) == 1) {
    // User is an administrator, display admin options
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
    // User is not an administrator, display error message
    echo "You do not have permission to access this page.";
  }

} else {
  // User is not logged in, redirect to login page
  header("Location: login.php");
  exit();
}

mysqli_close($conn);

?>
