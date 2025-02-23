<?php
$ffmpegPath = '/opt/homebrew/bin/ffmpeg'; // مسیر ffmpeg
$inputFile = 'test.mp4'; // فایل ورودی
$outputFile = 'out_test.mp4'; // فایل خروجی

// دستور FFMPEG
$command = escapeshellcmd("{$ffmpegPath} -i {$inputFile} -vf \"pad=1080:1920:(ow-iw)/2:(oh-ih)/2:white\" -c:a copy {$outputFile}");

// اجرای دستور
exec($command, $output, $returnVar);

if ($returnVar === 0) {
    echo "FFMPEG is working correctly.\n";
} else {
    echo "Error executing FFMPEG:\n";
    print_r($output);
}