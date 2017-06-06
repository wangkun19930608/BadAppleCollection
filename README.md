badapple-html
=============

## 前言
~~php为生成程序，请根据机器性能酌情修改生成帧数。~~    
~~两个html均为生成完毕的badapple字符画，用浏览器直接打开即可。~~    
~~180p版本有100帧左右重复了。但是编辑器载入此文件会假死，以致于无法修改。请见谅。~~    
~~另外一个版本完好，已在chrome以及firefox下测试通过。~~
时隔两年，重写这个程序（真懒），成功运行于    
```dos
PHP 5.6.25 (cli) (built: Aug 18 2016 11:40:20)
Copyright (c) 1997-2016 The PHP Group
Zend Engine v2.6.0, Copyright (c) 1998-2016 Zend Technologies
```
badapple视频未提供（需要自己去找

## 使用方法
1. 使用某些工具将badapple视频处理为图片
推荐使用[ffmpeg](https://ffmpeg.org/)，以及其他你认为可以的工具    
这里使用了ffmpeg，修改`video2pic.bat`批处理脚本中的`ffmpeg_folder`，`video_src`以及`pic_dst`的位置，使之与相应的位置对应，修改`fps`的值，推荐为20，如果你的机器性能很好，可以适当调高        
2. 修改`badapple_new.php`中的


欢迎提出意见和建议（尤其是生成算法上的）。

