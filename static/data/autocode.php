<?php
 session_start();
 header("Access-Control-Allow-Origin: *");
 header("Content-type:image/PNG");
 srand((double)microtime() * 1000000);
 $imagewidth = 80;
 $imageheight = 40;
 $authimage = imagecreate($imagewidth, $imageheight);
 $black = ImageColorAllocate($authimage, 0, 0, 0);
 $white = ImageColorAllocate($authimage, 255, 255, 255);
 $red = ImageColorAllocate($authimage, 255, 0, 0);
 $gray = ImageColorAllocate($authimage, 200, 200, 200);
 $c = imagecolorallocate($authimage,rand(150,230),rand(150,230),rand(150,230));//创建一个颜色
 $authcode='';
 //背景颜色为随机
 imagefill($authimage, 0, 0, $c);

 //随机的生成一些干扰像素
 for($i = 0; $i < 400; $i++)
 {
    $randcolor = ImageColorallocate($authimage, rand(10, 255), rand(10, 255), rand(10, 255));
    imagesetpixel($authimage, rand()%$imagewidth, rand()%$imageheight, $randcolor); 
 }
 
 //随机的画几条线段
 for($i = 0; $i < 6; $i++)
 {
  imageline($authimage, rand()%$imagewidth, rand()%$imageheight, 
   rand()%$imagewidth, rand()%$imageheight, $black);
 }
 
 //生成验证串
 $array = "123456789bcdefghjkmnpqrstuvwxyz";
 for($i = 0; $i < 4; $i++)
 {
  //$authcode.=substr($array, rand(0, 35), 1);
  $s = $array[rand(0,strlen($array)-1)]; //获取一个随机字符
  $authcode.=$s;
  $c = imagecolorallocate($authimage,rand(50,150),rand(50,150),rand(50,150));//创建一个颜色
	imagettftext($authimage, rand(20,25), rand(10,20), 20*$i+5, rand(25,30), $c, 'arial.ttf', $s);//在图片上绘制一个文字
 }
 //imagettftext($authimage, 20, 0, 0, $imageheight, $red, 'arial.ttf', $authcode);

 ImagePNG($authimage);
 ImageDestroy($authimage);
 $_SESSION['authcode'] = $authcode;
?>