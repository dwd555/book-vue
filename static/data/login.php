<?php
header("Content-type:application/json;charset=utf-8");
require('init.php');
@$phone=$_REQUEST['phone'] or die('{"msg":"phone required"}');
@$upwd=$_REQUEST['upwd'] or die("{'msg':'upwd required'}");
$sql="SELECT uid FROM book_user WHERE phone='$phone' AND upwd='$upwd'";
$result=mysqli_query($conn,$sql);
if($result==false){
    echo '{"msg":"err"}';
}else{
    $row=mysqli_fetch_row($result);
    $output=[];
    $output['msg']='succ';
    $output['uid']=$row[0];
    	if($row===null){
    		echo '{"msg":"err"}';
    	}else{
    		echo json_encode($output);
    	}
}