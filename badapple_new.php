<?php
/** 
* 生成badapple字符画
* by: yyd
*/
class Badapple {
	// jpg文件路径以及生成的文件的路径
	private static $folder = Array (
		'source' => './jpeg/',
		'destination' => './'
	);
	
	// css和js文件内容
	private static $content = Array (
		'cssContent' => 'div{font-family:monospace;word-break:break-all;font-size:6px;line-height:6px;letter-spacing:3px;display:none}',
		'jsContent' => 'window.onload = function () {
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
				}, 50);
		}'
	);
	
	// css和js引用
	private static $htmlHeader = '<head><link rel="stylesheet" type="text/css" href="main.css" ></head>' . "\n";
	private static $jsHeader = '<script type="text/javascript" src="script.js"></script>' . "\n";
	
	/**
	* 处理jpg文件
	*
	*/
	private static function getFromJpg($from, $to) {
		//$fileArray = scandir(self::$folder['source']);
		//$jpgNum = count($fileArray) - 2;
		
		$textContent = '';
		
		for($i = $from; $i < $to + 1; $i++) {
			$textContent .= self::jpgToText('jpeg/' . $i . '.jpg');
		}
		echo 'Totally operated ' . ($to - $from) .' frames...' . "\n";
		return $textContent;
	}
	
	/**
	* 转换图片为字符 
	*
	*/
	private static function jpgToText($jpgFile) {
		$image = imagecreatefromjpeg($jpgFile);
		if (!$image) {
			die('Can not open ' . $jpgFile . '...');
		}
		$width = imagesx($image);
		$height = imagesy($image);
		
		$content = "<div>\n";
		
		for ($y = 0; $y < $height; $y += 4) {
			for ($x = 0; $x < $width; $x += 4) {
				$rgb = imagecolorat($image, $x, $y);
				$blue = $rgb & 0xFF;
				$content .= self::blueToChar($blue);
			}
			$content .= "<br />\n";
		}
		
		$content .= "</div>\n";
		echo 'operated ' . $jpgFile . '...' . "\n";
		return $content;
	} 
	
	/**
	* 根据像素点计算字符
	*
	*/
	private static function blueToChar($value) {
		if ($value < 30) {
			return '#';
		} else if ($value > 210) {
			return '&nbsp;';
		} else {
			return '0';
		}
	}
	
	/**
	* 写入文件
	*
	*/
	public static function writeFile() {
		$htmlFile = fopen(self::$folder['destination'] . 'badapple.html', 'w');
		$cssFile = fopen(self::$folder['destination'] . 'main.css', 'w');
		$jsFile = fopen(self::$folder['destination'] . 'script.js', 'w');
		fwrite($htmlFile, self::$htmlHeader);
		fwrite($htmlFile, "<body>\n");
		$text = self::getFromJpg(1,1500);
		fwrite($htmlFile, $text);
		unset($text);
		$text = self::getFromJpg(1500,3000);
		fwrite($htmlFile, $text);
		unset($text);
		$text = self::getFromJpg(3000,4383);
		fwrite($htmlFile, $text);
		unset($text);
		// $text = self::getFromJpg(4500,6000);
		// fwrite($htmlFile, $text);
		// unset($text);
		// $text = self::getFromJpg(6000,6574);
		// fwrite($htmlFile, $text);
		// unset($text);
		fwrite($htmlFile, self::$jsHeader);
		fwrite($htmlFile, "</body>\n");
		fclose($htmlFile);
		fwrite($cssFile, self::$content['cssContent']);
		fclose($cssFile);
		fwrite($jsFile, self::$content['jsContent']);
		fclose($jsFile);
	}
}

Badapple::writeFile();

?>