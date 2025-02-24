<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>پردازش ویدئو با واترمارک</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@100..900&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="custom.css">
</head>
<body class="flex justify-center items-center min-h-screen bg-gray-100">
    <div class="w-full max-w-md p-6 bg-white rounded-lg shadow-md">
        <h1 class="text-2xl font-bold mb-4 text-center">پردازش ویدئو با واترمارک</h1>
        <form id="videoForm" enctype="multipart/form-data" class="space-y-4">
            <div>
                <label for="videoFile" class="block text-sm font-medium text-gray-700">انتخاب فایل ویدئو:</label>
                <input type="file" id="videoFile" name="videoFile" accept="video/*" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">نوع واترمارک:</label>
                <div class="mt-1 space-y-2">
                    <div>
                        <input type="radio" id="watermarkTypeText" name="watermarkType" value="text" checked>
                        <label for="watermarkTypeText" class="ml-2">متن</label>
                    </div>
                    <div>
                        <input type="radio" id="watermarkTypeImage" name="watermarkType" value="image">
                        <label for="watermarkTypeImage" class="ml-2">عکس</label>
                    </div>
                </div>
            </div>
            <div id="watermarkTextSection" class="space-y-2">
                <div>
                    <label for="watermarkText" class="block text-sm font-medium text-gray-700">متن واترمارک:</label>
                    <input type="text" id="watermarkText" name="watermarkText" placeholder="متن خود را وارد کنید" 
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
                <div>
                    <label for="textOpacity" class="block text-sm font-medium text-gray-700">شفافیت متن (0-100):</label>
                    <input type="range" id="textOpacity" name="textOpacity" min="0" max="100" value="100" 
                           class="mt-1 block w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer">
                    <span id="opacityValue" class="text-sm text-gray-500">100%</span>
                </div>
                <div>
                    <label for="fontSize" class="block text-sm font-medium text-gray-700">اندازه فونت:</label>
                    <select id="fontSize" name="fontSize" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        <?php 
                        $options = range(10, 60, 2);
                        foreach ($options as $size) {
                            $selected = $size == 44 ? 'selected' : '';
                            echo "<option value='$size' $selected>$size پیکسل</option>";
                        }
                        ?>
                    </select>
                </div>
                <div>
                    <label for="paddingValue" class="block text-sm font-medium text-gray-700">فاصله ویدیو تا اطراف</label>
                    <input type="text" value="50" id="paddingValue" name="paddingValue" placeholder="متن خود را وارد کنید" 
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
            </div>
            <div id="watermarkImageSection" class="hidden space-y-2">
                <label for="watermarkImage" class="block text-sm font-medium text-gray-700">انتخاب عکس واترمارک:</label>
                <input type="file" id="watermarkImage" name="watermarkImage" accept="image/*" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <button type="submit" id="submitButton" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">ارسال</button>
        </form>
        <div id="progressSection" class="mt-6 hidden">
            <div class="mb-4">
                <span id="progressText" class="text-sm text-gray-700">در حال پردازش...</span>
                <span id="estimatedTime" class="text-sm text-gray-500">(تخمین زمان باقی‌مانده: <span id="timeRemaining">--</span>)</span>
            </div>
            <progress id="progressBar" value="0" max="100" class="w-full h-2 bg-gray-200 rounded-full"></progress>
        </div>
        <div id="outputSection" class="mt-6 hidden">
            <video id="outputVideo" controls class="w-full mt-4 rounded-md"></video>
            <a id="downloadLink" href="#" class="mt-4 w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500" download="">دانلود ویدئو</a>
        </div>
    </div>

    <!-- Custom JavaScript -->
    <script src="script.js"></script>
</body>
</html>
