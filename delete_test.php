<?php 
require "connection.php";

$id_delete = $_GET['id'];
//$id_test = $_GET['test'];

$sql1 = "DELETE from tests WHERE id = '$id_delete'";
$sql2 = "DELETE from questions WHERE test_id = '$id_delete'";
$query = mysqli_query($conn, $sql1);
$query = mysqli_query($conn, $sql2);
header("Location: test_list.php");

?>