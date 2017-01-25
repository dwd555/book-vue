<?php
header("Content-type:application;charset=utf-8");
require('init.php');

$sql="select bid,img_sm,name,newprice,introduction from books  order by rand() limit 0,4 ";
$result=mysqli_query($conn,$sql);
$list=mysqli_fetch_all($result,MYSQLI_ASSOC);

echo json_encode($list);