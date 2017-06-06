<?php
/** 
* 生成badapple字符画
* by: yyd
*/
class Badapple {
	/**
	* 配置参数
	*/
	private static $config = Array(
		'sourceFolder' => './jpeg/',	// 源文件路径
		'destinationFolder' => './',	// 生成文件路径
		'picturesPerTime' => 1000		// 每次转换图片张数
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
		
		
		$textContent = '';
		
		for($i = $from; $i < $to + 1; $i++) {
			$textContent .= self::jpgToText(self::$config['sourceFolder'] . $i . '.jpg');
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
		$htmlFile = fopen(self::$config['destinationFolder'] . 'badapple.html', 'w');
		$cssFile = fopen(self::$config['destinationFolder'] . 'main.css', 'w');
		$jsFile = fopen(self::$config['destinationFolder'] . 'script.js', 'w');
		fwrite($htmlFile, self::$htmlHeader);
		fwrite($htmlFile, "<body>\n");

		$jpgNum = count(scandir(self::$config['sourceFolder'])) - 2;
		for ($i = 1; $i < $jpgNum; $i += self::$config['picturesPerTime']) {
			$startPicNum = $i;
			if ($i + self::$config['picturesPerTime'] > $jpgNum) {
				$endPic = $jpgNum;
			} else {
				$endPic = $i + self::$config['picturesPerTime'];
			}
			
			$text = self::getFromJpg($startPicNum, $endPicNum);
			fwrite($htmlFile, $text);
			unset($text);
		}
		
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