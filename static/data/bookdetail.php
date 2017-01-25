<?php
header("Content-type:application;charset=utf-8");
@$id=$_REQUEST['id'] or die("{'msg':'id required'}");
require('init.php');
$sql="SELECT * FROM books WHERE bid='$id'";
$result=mysqli_query($conn,$sql);
$list=mysqli_fetch_assoc($result);

echo json_encode($list);
