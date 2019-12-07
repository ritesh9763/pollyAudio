# pollyAudio
Generate MP3 file by inputting audio-content in any supported language through use of AWS Polly and PHP 

Please use a Linux server for easy configuration.
This is a simple URL application which gets input from any web-browser and downloads the MP3 file on the local computer. The URL is written in Core-PHP and can be copied directly in the root folder of your web-server. The URL accepts 2 parameters:- filename and content. The content parameter contains the text which shall be converted into audio and filename parameter shall be the name of the downloaded mp3 file.
Before beginning, you need to create an account on the Amazon web services panel and subscribe to their Polly Service. Once done, you can download the Polly's PHP library and store it in some location on the same server. The PHP Polly library shall be a directory named "polly" with the file polly\aws.autoloader.php inside it. You will also get your Polly credentials when you subscribe to their service.

Replace your polly credentials, file paths and polly library path in the URL application file: pollyAudio.php
Now install "lame" on the server for MP3 encodings. For ubuntu and other debian, you can use "sudo apt-get install -y lame" in the terminal. Same can be done on Fedora using yum command.
Get the lame install path by typing "which lame" in the terminal. Replace the lame install path in the pollyAudio.php file. 

Thats it and you are good to go.
Simply, browse to your web-server's URL\pollyAudio.php?content="Any text for which you need the mp3"&filename="Name of the MP3 file" and hit enter. If the configurations are correct, an MP3 file with the name specified in the URL shall be downloaded onto your computer.

You can also tweak the application to generate the output file in any format supported by AWS-Polly. Just use the correct encoder application to build the file correctly before download. One such method is presented in the application in comment section to generate a SLN file using Sox.

Happy Coding !!

