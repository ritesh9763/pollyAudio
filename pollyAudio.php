<?php
require('POLLY_LIBRARY_AUTOLOADER_PHP_FILE_PATH'); /* require('/opt/polly/aws-autoloader.php'); */

class makeAudio {
    
    Private $request;
    Private $content;
    Private $ttsPath = "AUDIO_PATH"; /* Private $ttsPath = "/opt/mp3dir/"; */
    Private $pollyCredentials;
    Private $downloadFileName;

    Public function __construct($request) {
        $this->request = $request;
        $this->content = $this->request['content'];
        $this->pollyCredentials = new \Aws\Credentials\Credentials('POLLY_KEY', 'POLLY_SECRET');
        $this->downloadFileName = $this->request['filename'] . ".mp3";
        $audioFile = $this->tts($this->content);
        if (file_exists($audioFile)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . $this->downloadFileName . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($audioFile));
            readfile($audioFile);
        }
    }

    Private function tts($text) {
   /* To download file in other format than MP3, use this example for SLN files:
      Replace MP3 with SLN below.
      Install SOX on the server and get SOX path.
      Replace Line Number 57 to :
      shell_exec("SOX_INSTALl_PATH $temp_file_name -t raw -r 8000 -e signed-integer -b 16 -c 1 -V0 $sln_filename");
   */
        $mp3_filename = $this->ttsPath . md5($text) . ".mp3";
        $temp_file_name = $this->ttsPath . "temp/" . md5($text) . ".mp3";
        if (!file_exists($mp3_filename)) {
            // Generate AUDIO
            $client = new \Aws\Polly\PollyClient([
                'version' => 'latest',
                'credentials' => $this->pollyCredentials,
                'region' => 'ap-south-1',
            ]);
            $result = $client->synthesizeSpeech([
                'OutputFormat' => 'mp3',
                'Text' => $text,
                'TextType' => 'text',
                'VoiceId' => 'Aditi',
                'SampleRate' => '8000'
            ]);
            $resultData = $result->get('AudioStream')->getContents();
            $file = fopen($temp_file_name, "w");
            fwrite($file, $resultData);
            fclose($file);
            shell_exec("LAME_INSTALL_PATH --silent" . " $temp_file_name" . " $mp3_filename"); 
            /* shell_exec("/usr/bin/lame --silent" . " $temp_file_name" . " $mp3_filename"); */
            shell_exec("chmod 755 $mp3_filename");
            shell_exec("/bin/rm -rf $temp_file_name");
            return($mp3_filename);
        } else {
            return($mp3_filename);
        }
    }

}

if (isset($_REQUEST['content']) && isset($_REQUEST['filename'])) {
    $audio = new makeAudio($_REQUEST);
}
?>
