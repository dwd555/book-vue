<?php
header("Content-type:application/json;charset=UTF-8");
@$start = $_REQUEST['start'];
if(empty($start))
{
    $start = 0;
}
$count = 5;
require('init.php');
$sql="SELECT * FROM books LIMIT $start,$count";
$result=mysqli_query($conn,$sql);
$output = [];
while(true)
{
    $row = mysqli_fetch_assoc($result);
    if(!$row)
    {
        break;
    }
    $output[] = $row;
}
echo json_encode($output);