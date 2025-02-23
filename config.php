<?php
return [
    'ffmpeg_path' => '/opt/homebrew/bin/ffmpeg', // آدرس ffmpeg
    'ffprobe_path' => '/opt/homebrew/bin/ffprobe', // آدرس ffprobe
    'upload_dir' => __DIR__ . '/uploads/',       // دایرکتوری آپلود
    'output_dir' => __DIR__ . '/outputs/',        // دایرکتوری خروجی

    // تنظیمات واترمارک
    'watermark' => [
        'max_dimensions' => 200, // حداکثر ابعاد واترمارک (برای عکس)
        'text_font_size' => 45,  // سایز متن واترمارک (برای متن)
        'text_font' => 'Doran',  // فونت متن واترمارک (پشتیبانی فارسی: Vazir یا B Nazanin)
        'opacity' => 0.3,        // شفافیت واترمارک (0 تا 1)
    ],

    // تنظیمات padding و رنگ پس‌زمینه
    'video_padding' => [
        'width' => 1080,         // عرض نهایی ویدئو
        'height' => 1920,        // ارتفاع نهایی ویدئو
        'background_color' => 'white', // رنگ پس‌زمینه (white, black, red, blue, etc.)
        'padding' => 100
    ],
];