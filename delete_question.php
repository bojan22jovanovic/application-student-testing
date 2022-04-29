<?php 
require "connection.php";

$id_delete = $_GET['id'];
$id_test = $_GET['test'];

$sql = "DELETE from questions WHERE id = '$id_delete'";
$query = mysqli_query($conn, $sql);
header("Location: preview_test.php?id=$id_test");

?>