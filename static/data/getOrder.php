<?php
header("Content-Type:application/json;charset=UTF-8");
@$uid=$_REQUEST['uid'] or die('{"msg":"uid required"}');

require("init.php");
$sql="SELECT cid FROM cart WHERE uid='$uid'";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_row($result);
$cid=$row[0];

$output=[];

$sql="SELECT cartlist.count,cartlist.single_price,books.img_sm,books.name FROM cartlist,books WHERE books.bid in (SELECT bid FROM cartlist WHERE cid='$cid' AND selected=5)AND cartlist.cid='$cid' AND cartlist.selected=5 AND books.bid=cartlist.bid";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_all($result,MYSQL_ASSOC);
//var_dump($row);
$sum=0;
foreach ($row as $key => $value) {
	$sum+=$value['single_price']*$value['count'];
}
//echo number_format($sum, 2, '.', '');
$output['total']=number_format($sum, 2, '.', '');
$output['cart']=$row;

$sql="SELECT * FROM address WHERE uid='$uid' AND choose=5";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_all($result,MYSQL_ASSOC);
$output['address']=$row;

echo json_encode($output);
