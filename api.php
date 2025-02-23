<?php
$accessToken = 'ACCESS_TOKEN';
$pageId = 'PAGE_ID';
$videoPath = 'path/to/video.mp4';

// مرحله 1: ایجاد نشست آپلود
$initUrl = "https://graph.facebook.com/v13.0/{$pageId}/media";
$initData = [
    'access_token' => $accessToken,
    'upload_phase' => 'start',
    'media_type' => 'VIDEO'
];

$ch = curl_init($initUrl);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $initData);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = json_decode(curl_exec($ch), true);
$videoId = $response['video_id'];
$uploadUrl = $response['upload_url'];

// مرحله 2: آپلود ویدیو
$ch = curl_init($uploadUrl);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, file_get_contents($videoPath));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: video/mp4']);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$uploadResponse = json_decode(curl_exec($ch), true);

// مرحله 3: انتشار
$publishUrl = "https://graph.facebook.com/v13.0/{$pageId}/media_publish";
$publishData = [
    'access_token' => $accessToken,
    'creation_id' => $videoId
];

$ch = curl_init($publishUrl);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $publishData);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = json_decode(curl_exec($ch), true);

if(isset($result['id'])) {
    echo "ویدیو با موفقیت آپلود شد! آیدی پست: " . $result['id'];
} else {
    echo "خطا در آپلود: " . print_r($result, true);
}
