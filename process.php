<?php
// process.php

// Load configuration
$config = require __DIR__ . '/config.php';

// Include FFMpeg library
require 'vendor/autoload.php';
use FFMpeg\FFMpeg;
function resizeWatermarkImage($inputPath, $outputPath, $maxWidth, $maxHeight) {
    // Get image dimensions
    list($width, $height) = getimagesize($inputPath);

    // Calculate new dimensions while maintaining aspect ratio
    if ($width > $maxWidth || $height > $maxHeight) {
        $ratio = min($maxWidth / $width, $maxHeight / $height);
        $newWidth = $width * $ratio;
        $newHeight = $height * $ratio;
    } else {
        $newWidth = $width;
        $newHeight = $height;
    }

    // Create a new true-color image with transparency support
    $image = imagecreatefromstring(file_get_contents($inputPath));
    $resizedImage = imagecreatetruecolor($newWidth, $newHeight);

    // Preserve transparency for PNG images
    imagealphablending($resizedImage, false);
    imagesavealpha($resizedImage, true);
    $transparent = imagecolorallocatealpha($resizedImage, 0, 0, 0, 127);
    imagefill($resizedImage, 0, 0, $transparent);

    // Resample the image
    imagecopyresampled($resizedImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

    // Save the resized image
    imagepng($resizedImage, $outputPath);

    // Free memory
    imagedestroy($image);
    imagedestroy($resizedImage);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['videoFile']) && isset($_POST['watermarkType'])) {
        $videoFile = $_FILES['videoFile'];
        $watermarkType = $_POST['watermarkType'];

        // Validation
        if ($videoFile['error'] !== UPLOAD_ERR_OK) {
            echo json_encode(['success' => false, 'message' => 'خطا در آپلود فایل ویدئو.']);
            exit;
        }

        if ($videoFile['size'] === 0) {
            echo json_encode(['success' => false, 'message' => 'فایل ویدئوی ورودی خراب است.']);
            exit;
        }

        if ($watermarkType === 'text' && empty($_POST['watermarkText'])) {
            echo json_encode(['success' => false, 'message' => 'لطفاً متن واترمارک وارد کنید.']);
            exit;
        }

        if ($watermarkType === 'image' && !isset($_FILES['watermarkImage'])) {
            echo json_encode(['success' => false, 'message' => 'لطفاً یک عکس واترمارک انتخاب کنید.']);
            exit;
        }

        // Define paths from configuration
        $uploadDir = $config['upload_dir'];
        $outputDir = $config['output_dir'];
        $tempVideoPath = $uploadDir . basename($videoFile['name']);
        $outputVideoPath = $outputDir . 'output_' . basename($videoFile['name']);

        // Create directories if not exist
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
        if (!is_dir($outputDir)) mkdir($outputDir, 0777, true);

        // Move uploaded file
        move_uploaded_file($videoFile['tmp_name'], $tempVideoPath);

        try {
            // Initialize FFMpeg
            
            $ffmpeg = FFMpeg::create([
                'ffmpeg.binaries'  => $config['ffmpeg_path'],
                'ffprobe.binaries' => $config['ffprobe_path'],
                'timeout'          => 3600,
                'ffmpeg.threads'   => 12,
            ]);

            // Open the video file
            $video = $ffmpeg->open($tempVideoPath);

            // Apply padding and background color
            // Get video dimensions and calculate padding
            $videoWidth = $config['video_padding']['width'];
            $videoHeight = $config['video_padding']['height'];
            $padding = $config['video_padding']['padding'];

            // Get input video dimensions using instance method
            $ffprobe = $ffmpeg->getFFProbe();
            $inputVideoInfo = $ffprobe->streams($tempVideoPath)->videos()->first();
            $inputDimensions = $inputVideoInfo->getDimensions();
            $inputWidth = $inputDimensions->getWidth();
            $inputHeight = $inputDimensions->getHeight();

            // Check if the input video is already in 9:16 aspect ratio
            if (($inputWidth * 1920) === ($inputHeight * 1080)) { // 9:16 aspect ratio
                // Add padding to the existing 9:16 video
                $finalWidth = $inputWidth + (2 * $padding);
                $finalHeight = $inputHeight + (2 * $padding);

                
                $video->filters()->custom("pad=w={$finalWidth}:h={$finalHeight}:x={$padding}:y={$padding}:color=white", new \FFMpeg\Format\Video\X264());
            } else {
                // Resize and pad non-9:16 videos to fit in 1080x1920 with white background
                $video->filters()->custom("pad=w={$videoWidth}:h={$videoHeight}:x=(ow-iw)/2:y=(oh-ih)/2:color=white", new \FFMpeg\Format\Video\X264());
            }
            // Watermark processing
            if ($watermarkType === 'text') {
                $watermarkText = htmlspecialchars($_POST['watermarkText']);
                $font = $config['watermark']['text_font'];
                $fontSize = isset($_POST['fontSize']) ? (int)$_POST['fontSize'] : 44;
                $opacity = isset($_POST['textOpacity']) ? max(0, min(1, $_POST['textOpacity'] / 100)) : 1;

                // Add text watermark at the center
                // Use a Persian-supported font (e.g., Vazir or B Nazanin)
                $fontPath = __DIR__ . '/fonts/' . $font . '.ttf'; // Path to the font file
                if (!file_exists($fontPath)) {
                    throw new Exception("Font file not found: {$fontPath}");
                }

                $video->filters()->custom(
                    "drawtext=text='{$watermarkText}':x=(w-tw)/2:y=(h-th)/2:fontsize={$fontSize}:fontfile={$fontPath}:fontcolor=white@{$opacity}",
                    new \FFMpeg\Format\Video\X264()
                );
            } elseif ($watermarkType === 'image') {
                $watermarkImagePath = $uploadDir . 'watermark.' . pathinfo($_FILES['watermarkImage']['name'], PATHINFO_EXTENSION);
                move_uploaded_file($_FILES['watermarkImage']['tmp_name'], $watermarkImagePath);
            
                // Validate image format
                $allowedFormats = ['png', 'jpg', 'jpeg'];
                $extension = strtolower(pathinfo($watermarkImagePath, PATHINFO_EXTENSION));
                if (!in_array($extension, $allowedFormats)) {
                    throw new Exception("Unsupported image format. Allowed formats: " . implode(', ', $allowedFormats));
                }
            
                // Resize watermark image if necessary
                $maxDimensions = $config['watermark']['max_dimensions'];
                $resizedImagePath = $uploadDir . 'resized_watermark.png'; // Path for resized watermark
            
                resizeWatermarkImage($watermarkImagePath, $resizedImagePath, $maxDimensions, $maxDimensions);
            
                $finalWidth = $videoWidth;
                $finalHeight = $videoHeight;

                // Get resized watermark dimensions
                list($watermarkWidth, $watermarkHeight) = getimagesize($resizedImagePath);

                // Calculate center position for watermark
                $x = ($finalWidth - $watermarkWidth) / 2;
                $y = ($finalHeight - $watermarkHeight) / 2;

                // Add image watermark at the calculated center position
                $video->filters()->watermark($resizedImagePath, [
                    'position' => 'absolute',
                    'x' => $x,
                    'y' => $y,
                ])->synchronize();
            }

            // Save the processed video
            $format = new \FFMpeg\Format\Video\X264();
            $format->setAudioCodec('aac');
            $video->save($format, $outputVideoPath);

            // Return download link
            $fileUrl = 'outputs/output_' . basename($videoFile['name']);
            echo json_encode(['success' => true, 'fileUrl' => $fileUrl]);

        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }

        exit;
    } else {
        echo json_encode(['success' => false, 'message' => 'اطلاعات ارسالی ناقص است.']);
        exit;
    }
}
?>