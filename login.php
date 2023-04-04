<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: login.php");
    exit;
}

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("location: index.php");
    exit;
}

$host = "localhost";
$username = "root";
$password = "";
$dbname = "energy";

$conn = mysqli_connect($host, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'add':
            $name = $_POST['name'];
            $price = $_POST['price'];
            $sql = "INSERT INTO aanbiedingen (name, price) VALUES ('$name', $price)";
            mysqli_query($conn, $sql);
            break;
        case 'remove':
            $id = $_POST['id'];
            $sql = "DELETE FROM aanbiedingen WHERE id = $id";
            mysqli_query($conn, $sql);
            break;
    }
}

$sql = "SELECT * FROM products";
$result = mysqli_query($conn, $sql);

if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
</head>
<body>
    <h1>Welcome, <?php echo $_SESSION['username']; ?></h1>
    <h3>Add a product:</h3>
    <form method="post">
        <input type="hidden" name="action" value="add">
        <label>Name:</label>
        <input type="text" name="name">
        <br>
        <label>Price:</label>
        <input type="number" name="price" step="0.01">
        <br>
        <input type="submit" value="Add">
    </form>
    <br>
    <h3>Remove a product:</h3>
    <form method="post">
        <input type="hidden" name="action" value="remove">
        <label>ID:</label>
        <input type="number" name="id">
        <br>
        <input type="submit" value="Remove">
    </form>
    <br>
    <h3>Product List:</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['price']; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <br>
    <form method="post">
        <input type="submit" name="logout" value="Logout">
    </form>
</body>
</html>