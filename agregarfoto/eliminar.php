<?php include("db.php"); ?>
<?php
$id = $_GET['id'];
$sql = "DELETE FROM carros WHERE id=$id";
$conn->query($sql);
header("Location: index.php");
?>
