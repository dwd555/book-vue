<?php
header("Content-type:application/json;charset=UTF-8");
require("init.php");
$sql="SELECT name,bid FROM books ORDER BY comment DESC LIMIT 0,6";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_all($result,MYSQLI_ASSOC);
echo json_encode($row);