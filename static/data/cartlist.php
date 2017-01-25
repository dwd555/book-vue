<?php
header("Content-type:application/json;charset=UTF-8");
//@$uid=$_REQUEST['uid'] or die('{"msg":"uid required"}');
@$phone=$_REQUEST['phone'] or die('{"msg":"phone required"}');
require("init.php");
$sql="SELECT books.bid,books.img_sm,books.name,cartlist.count,cartlist.kid,cartlist.single_price,cartlist.selected FROM books,cartlist WHERE cartlist.bid=books.bid AND cartlist.cid=(SELECT cid FROM cart WHERE phone='$phone')";
$result=mysqli_query($conn,$sql);
if($result===false){
    echo '{"msg":"err"}';
}else{
    $row=mysqli_fetch_all($result,MYSQLI_ASSOC);
    if($row==null){
        echo '{"msg":"null"}';
    }else{
    	$output=[];
	    $output['msg']='succ';
	    $output['data']=$row;
        // echo json_encode($row);
        echo json_encode($output);
    }
}