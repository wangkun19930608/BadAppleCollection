<?php 
/**
	生成html格式的字符画文件
	@Author:kudoryafuka
*/
//这一段是CSS显示控制代码，宽度为960px，高度为720px，字符大小8px，间隔2px（字符宽度为6px，这样能够凑成一个方形点），word-break用于自动换行
$htmlContent = '<style type="text/css">div{width:960px;height:720px;word-break:break-all;font-size:8px;line-height:8px;letter-spacing:2px;display:none}</style>'

//这一段是JavaScript代码，125毫秒刚好是一秒8帧
$htmlCntent .='<script>
	window.onload = function () {
		var divTag = document.getElementsByTagName("div"),
			divTotal = divTag.length,
			currentNum = 1,
			timer = setInterval(function () {
				divTag[currentNum - 1].style.display = "none";
				divTag[currentNum].style.display = "block";
				currentNum++;
				if (currentNum >= divTotal){
					clearInterval(timer);
				}
			}, 125);
	}
</script>';
badApple();
$file = fopen('badapple.html', 'w');
fwrite($file, $htmlContent);
fclose($file);
/**
 主要函数
*/
function badApple(){
	$sourcePath = "D:/wamp/www/badapple";
	$array = scandir($sourcePath);
	$jpgNum =count($array) - 2;	//-2是除掉.和..两个文件夹，严密一点可以使用正则表达式判断jpg文件个数
	
	//循环生成字符
	for ($i = 1; $i <= $jpgNum; $i++){
		jpgToTxt("$i");
	}
	echo "Totally operated $i frames...Done...";
}
/**
 处理每一张图片
 @params:
	$value 要处理的图片编号 
*/
function jpgToTxt($value){
	$imageSource = "D:/wamp/www/badapple/$value.jpg";//必须双引号，不然不会解析$value的值，另外貌似wamp貌似不支持跨分区访问（运行时提示找不到文件）
	$image = imagecreatefromjpeg($imageSource);
	$width = imagesx($image);
	$height = imagesy($image);
	global $htmlContent;//php和C不同，需要手动指定全局变量覆盖
	
	$htmlContent .= '<div>';//用div括起来方便后续操作
	
	//隔12个像素取一点，注意循环先y后x
	for ($y = 0; $y < $height; $y += 12){
		for ($x = 0; $x < $width; $x += 12){
			$rgb = imagecolorat($image, $x, $y);//imagecolorat函数用于获得指定点的颜色信息，为一个6位16进制数（应该猜到是什么了吧）
			$blue = $rgb & 0xFF;//badapple全是黑白视频，所以三种颜色均可，这里是求蓝色色值，因为蓝色在最后2位
			$htmlContent .= blueTochar($blue);
		}
	}
	
	$htmlContent .= '</div>';
}
/**
 根据颜色判断值
 
 @param:
	$blue 蓝色值
 @return:
	'#' 小于30
	'&nbsp;' 大于210
	'0' 在中间
*/
function blueToChar($blue){
	if ($blue < 30) return '#';
	if ($blue > 210) return '&nbsp;';
	return '0';
}
?>
