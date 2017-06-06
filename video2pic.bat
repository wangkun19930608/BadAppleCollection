set ffmpeg_folder=c:\users\yyd\downloads\ffmpeg\bin
set video_src=c:\users\yyd\documents\badapple-html\video
set pic_dst=c:\users\yyd\documents\badapple-html\jpeg
set fps=20

%ffmpeg_folder%\ffmpeg -i "%video_src%\Bad Apple!.mp4" -vf fps=%fps% %pic_dst%\%%d.jpg