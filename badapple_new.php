<?php
// 生产badapple字符画
class Badapple {
	private static $folder = Array (
		'source' => './jpeg/',
		'destination' => './'
	);
	
	private static $content = Array (
		'cssContent' = 'style 	type="text/css">div{width:960px;height:720px;word-break:break-all;font-size:8px;line-height:8px;letter-spacing:2px;display:none}</style>',
		'jsContent' = 'window.onload = function () {
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
		}'
	);
	
	private static function getFromJpg() {
		$fileArray = scandir(self::$folder['source']);
		$jpgNum = count($fileArray) - 2;
		
		$textContent = '';
		
		for($i = 1; $i < $jpgNum + 1; $i++) {
			$textContent .= self::jpgToText($i . '.jpg');
		}
		echo 'Totally operated ' . $i .' frames...';
		return $textContent;
	}
	
	private static function jpgToText($jpgFile) {
		$image = imagecreatefromjpeg($jpgFile);
		if (!$image) {
			die('Can not open ' . $jpgFile . '...');
		}
		$width = imagesx($image);
		$height = imagesy($image);
		
		$content = '<div>\n';
		
		for ($y = 0; $y < $height; $y += 4) {
			for ($x = 0; $x < $width; $x += 4) {
				$rgb = imagecolorat($image, $x, $y);
				$blue = $rgb & 0xFF;
				$content .= self::blueToChar($blue);
			}
			$content .= '<br />\n';
		}
		
		$content .= '</div>\n';
		return $content;
	} 
	
	private static function blueToChar($value) {
		if ($value < 30) {
			return '#';
		} else if ($value > 210) {
			return '&nbsp;';
		} else {
			return '0';
		}
	}
	
	private static function writeFile() {
		$htmlFile = fopen(self::$floder['destination'] . 'badapple.html', 'w');
		$cssFile = fopen(self::$floder['destination'] . 'main.css', 'w');
		$jsFile = fopen(self::$floder['destination'] . 'script.js', 'w');
		$text = self::getFromJpg();
		fwrite($htmlFile, $text);
		fclose($htmlFile);
	}
}

?>