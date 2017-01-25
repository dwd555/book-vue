<?php
header("Content-type:application/json;charset=utf-8");
@$aid=$_REQUEST['aid'] or die('{"msg":"aid required"}');
require("init.php");
$sql="SELECT * FROM address WHERE aid='$aid'";
$result=mysqli_query($conn,$sql);
$list=mysqli_fetch_assoc($result);
echo json_encode($list);