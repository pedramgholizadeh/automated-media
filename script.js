function convert(param) {
    var makesBeforeChasban = ['ب', 'پ', 'ت', 'ث', 'ج', 'چ', 'ح', 'خ', 'س', 'ش', 'ص', 'ض', 'ط', 'ظ', 'ع', 'غ', 'ف', 'ق', 'ک', 'ك', 'گ', 'ل', 'م', 'ن', 'ه', 'ی', 'ي', 'ئ'];
    var makesAfterChasban = ['ا', 'آ', 'أ', 'إ', 'ب', 'پ', 'ت', 'ث', 'ج', 'چ', 'ح', 'خ', 'د', 'ذ', 'ر', 'ز', 'ژ', 'س', 'ش', 'ص', 'ض', 'ط', 'ظ', 'ع', 'غ', 'ف', 'ق', 'ک', 'ك', 'گ', 'ل', 'م', 'ن', 'و', 'ه', 'ی', 'ي', 'ؤ', 'ئ'];
    var reqularAlphabet = [
        'ا',
        'آ',
        'أ',
        'إ',
        'ب',
        'پ',
        'ت',
        'ث',
        'ج',
        'چ',
        'ح',
        'خ',
        'د',
        'ذ',
        'ر',
        'ز',
        'ژ',
        'س',
        'ش',
        'ص',
        'ض',
        'ط',
        'ظ',
        'ع',
        'غ',
        'ف',
        'ق',
        'ک',
        'ك',
        'گ',
        'ل',
        'م',
        'ن',
        'و',
        'ؤ',
        'ه',
        'ی',
        'ي',
        'ئ',
        'ء',
        '1',
        '2',
        '3',
        '4',
        '5',
        '6',
        '7',
        '8',
        '9',
        '0',
    ];
    var arabicAlphabet = [
        ['ﺍ', 'ﺍ', 'ﺎ', 'ﺎ'],
        ['ﺁ', 'ﺁ', 'ﺂ', 'ﺂ'],
        ['ﺃ', 'ﺃ', 'ﺄ', 'ﺄ'],
        ['ﺇ', 'ﺃ', 'ﺈ', 'ﺈ'],
        ['ﺏ', 'ﺑ', 'ﺐ', 'ﺒ'],
        ['ﭖ', 'ﭘ', 'ﭗ', 'ﭙ'],
        ['ﺕ', 'ﺗ', 'ﺖ', 'ﺘ'],
        ['ﺙ', 'ﺛ', 'ﺚ', 'ﺜ'],
        ['ﺝ', 'ﺟ', 'ﺞ', 'ﺠ'],
        ['ﭺ', 'ﭼ', 'ﭻ', 'ﭽ'],
        ['ﺡ', 'ﺣ', 'ﺢ', 'ﺤ'],
        ['ﺥ', 'ﺧ', 'ﺦ', 'ﺨ'],
        ['ﺩ', 'ﺩ', 'ﺪ', 'ﺪ'],
        ['ﺫ', 'ﺫ', 'ﺬ', 'ﺬ'],
        ['ﺭ', 'ﺭ', 'ﺮ', 'ﺮ'],
        ['ﺯ', 'ﺯ', 'ﺰ', 'ﺰ'],
        ['ﮊ', 'ژ', 'ﮋ', 'ﮋ'],
        ['ﺱ', 'ﺳ', 'ﺲ', 'ﺴ'],
        ['ﺵ', 'ﺷ', 'ﺶ', 'ﺸ'],
        ['ﺹ', 'ﺻ', 'ﺺ', 'ﺼ'],
        ['ﺽ', 'ﺿ', 'ﺾ', 'ﻀ'],
        ['ﻁ', 'ﻃ', 'ﻂ', 'ﻄ'],
        ['ﻅ', 'ﻇ', 'ﻆ', 'ﻈ'],
        ['ﻉ', 'ﻋ', 'ﻊ', 'ﻌ'],
        ['ﻍ', 'ﻏ', 'ﻎ', 'ﻐ'],
        ['ﻑ', 'ﻓ', 'ﻒ', 'ﻔ'],
        ['ﻕ', 'ﻗ', 'ﻖ', 'ﻘ'],
        ['ک', 'ﻛ ', 'ﻚ', 'ﻜ'],
        ['ک', 'ﻛ ', 'ﻚ', 'ﻜ'],
        ['ﮒ', 'ﮔ', 'ﮓ', 'ﮕ'],
        ['ﻝ', 'ﻟ', 'ﻞ', 'ﻠ'],
        ['ﻡ', 'ﻣ', 'ﻢ', 'ﻤ'],
        ['ﻥ', 'ﻧ', 'ﻦ', 'ﻨ'],
        ['ﻭ', 'ﻭ', 'ﻮ', 'ﻮ'],
        ['ﺅ', 'ﺅ', 'ﺆ', 'ﺆ'],
        ['ﻩ', 'ﻫ', 'ﻪ', 'ﻬ'],
        ['ى', 'ﯾ', 'ﯽ', 'ﯿ'],
        ['ى', 'ﯾ', 'ﯽ', 'ﯿ'],
        ['ﺉ', 'ﺋ', 'ﺊ', 'ﺌ'],
        ['ﺀ', 'ﺀ', 'ﺀ', 'ﺀ'],
        ['١', '١', '١', '١'],
        ['٢', '٢', '٢', '٢'],
        ['٣', '٣', '٣', '٣'],
        ['٤', '٤', '٤', '٤'],
        ['٥', '٥', '٥', '٥'],
        ['٦', '٦', '٦', '٦'],
        ['٧', '٧', '٧', '٧'],
        ['٨', '٨', '٨', '٨'],
        ['٩', '٩', '٩', '٩'],
        ['٠', '٠', '٠', '٠'],
    ];
    var numbers = ['١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩', '٠'];
    var strArray = document.getElementById('watermarkText').value.split("\n");
    var convertedStrArray = [];
    for (j = 0; j < strArray.length; j++) {
        var strInner = strArray[j].split(" ");
        var convertedStr = '';
        for (var m = 0; m < strInner.length; m++) {
            var str = strInner[m];
            var atleastOne = false;
            //
            var convertedWord = '';
            for (var i = 0; i < str.length; i++) {
                var beforeChasban, afterChasban;
                var currentCharPos = reqularAlphabet.indexOf(str[i]);
                console.log(currentCharPos)
                console.log(currentCharPos)
                if (currentCharPos >= 0) {
                    if (i > 0) {
                        if (makesBeforeChasban.includes(str[i - 1])) {
                            atleastOne = true;
                            beforeChasban = true;
                        } else {
                            beforeChasban = false;
                        }
                    } else {
                        beforeChasban = false;
                    }
                    if (i < str.length - 1) {
                        if (makesAfterChasban.includes(str[i + 1])) {
                            atleastOne = true;
                            afterChasban = true;
                        } else {
                            afterChasban = false;
                        }
                    } else {
                        afterChasban = false;
                    }

                    if (!beforeChasban && !afterChasban) {
                        convertedWord = arabicAlphabet[currentCharPos][0] + convertedWord;
                    }
                    if (beforeChasban && !afterChasban) {
                        convertedWord = arabicAlphabet[currentCharPos][2] + convertedWord;
                    }
                    if (!beforeChasban && afterChasban) {
                        convertedWord = arabicAlphabet[currentCharPos][1] + convertedWord;
                    }
                    if (beforeChasban && afterChasban) {
                        console.log(currentCharPos);
                        convertedWord = arabicAlphabet[currentCharPos][3] + convertedWord;
                    }
                } else {
                    if (atleastOne) {
                        convertedWord = str[i] + convertedWord;
                    } else {
                        convertedWord += str[i];
                    }

                }
            }
            convertedStr = convertedWord + ' ' + convertedStr;
        }

        convertedStrArray.push(convertedStr);
    }
    console.log(convertedStrArray)
    var finalValue = convertedStrArray.reduce(function (total, value) {
        return (total + "\n" + value).trim();
    });
    var numberWord = '';
    for (var i = 0; i < finalValue.length; i++) {

        //console.log('g', numbers.indexOf(finalValue[i]))
        if (numbers.indexOf(finalValue[i]) >= 0) {
            numberWord += finalValue[i];
            console.log(numberWord)
        } else {
            if (numberWord !== '') {
                var tempWord = numberWord.split("").reverse().join("");
                //console.log(finalValue.substring(0, i - tempWord.length));
                finalValue = finalValue.replace(numberWord, tempWord);
                numberWord = '';
            }
        }

    }
    return finalValue;
}
document.getElementById('watermarkTypeImage').addEventListener('change', function () {
    document.getElementById('watermarkTextSection').classList.add('hidden');
    document.getElementById('watermarkImageSection').classList.remove('hidden');
});

document.getElementById('watermarkTypeText').addEventListener('change', function () {
    document.getElementById('watermarkTextSection').classList.remove('hidden');
    document.getElementById('watermarkImageSection').classList.add('hidden');
});

document.getElementById('videoForm').addEventListener('submit', async function (e) {
    e.preventDefault();

    document.getElementById('outputSection').classList.add('hidden');
    
    const videoFile = document.getElementById('videoFile').files[0];
    const watermarkType = document.querySelector('input[name="watermarkType"]:checked').value;
    const watermarkText = document.getElementById('watermarkText').value;
    const watermarkImage = document.getElementById('watermarkImage').files[0];

    if (!videoFile) {
        Swal.fire({
            icon: 'error',
            title: 'خطا!',
            text: 'لطفاً یک فایل ویدئو انتخاب کنید.',
        });
        return;
    }

    if (watermarkType === 'text' && !watermarkText.trim()) {
        Swal.fire({
            icon: 'error',
            title: 'خطا!',
            text: 'لطفاً متن واترمارک وارد کنید.',
        });
        return;
    }

    if (watermarkType === 'image' && !watermarkImage) {
        Swal.fire({
            icon: 'error',
            title: 'خطا!',
            text: 'لطفاً یک عکس واترمارک انتخاب کنید.',
        });
        return;
    }

    const formData = new FormData();
    formData.append('videoFile', videoFile);
    formData.append('watermarkType', watermarkType);
    if (watermarkType === 'text') {
        formData.append('fontSize', document.getElementById('fontSize').value);
        formData.append('textOpacity', document.getElementById('textOpacity').value);
        formData.append('watermarkText', convert(watermarkText));
    } else {
        formData.append('watermarkImage', watermarkImage);
    }

    // Show progress section
    document.getElementById('progressSection').classList.remove('hidden');
    document.getElementById('submitButton').disabled = true;

    try {
        const response = await fetch('process.php', {
            method: 'POST',
            body: formData,
        });

        const result = await response.json();

        if (result.success) {
            document.getElementById('outputSection').classList.remove('hidden');
            document.getElementById('outputVideo').src = result.fileUrl;
            document.getElementById('downloadLink').href = result.fileUrl;
            document.getElementById('downloadLink').textContent = 'دانلود ویدئو';
        } else {
            Swal.fire({
                icon: 'error',
                title: 'خطا!',
                text: result.message,
            });
        }
    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'خطا!',
            text: 'مشکلی در پردازش درخواست شما به وجود آمد.',
        });
    } finally {
        document.getElementById('progressSection').classList.add('hidden');
        document.getElementById('submitButton').disabled = false;
    }
});

// Update opacity display
document.getElementById('textOpacity').addEventListener('input', function(e) {
    document.getElementById('opacityValue').textContent = `${e.target.value}%`;
});

// Update font size display
document.getElementById('fontSize').addEventListener('input', function(e) {
    document.getElementById('fontSizeValue').textContent = `${e.target.value}px`;
});

// ذخیره و بازیابی تنظیمات
function saveSettings() {
    const settings = {
        watermarkText: document.getElementById('watermarkText').value,
        textOpacity: document.getElementById('textOpacity').value,
        fontSize: document.getElementById('fontSize').value,
        watermarkType: document.querySelector('input[name="watermarkType"]:checked').value
    };
    localStorage.setItem('watermarkSettings', JSON.stringify(settings));
}

function loadSettings() {
    const saved = localStorage.getItem('watermarkSettings');
    if (saved) {
        const settings = JSON.parse(saved);
        
        // اعمال تنظیمات ذخیره شده
        document.getElementById('watermarkText').value = settings.watermarkText || '';
        document.getElementById('textOpacity').value = settings.textOpacity || 100;
        document.getElementById('fontSize').value = settings.fontSize || 44;
        document.querySelector(`input[name="watermarkType"][value="${settings.watermarkType}"]`).checked = true;

        // بروزرسانی نمایش مقادیر
        document.getElementById('opacityValue').textContent = `${settings.textOpacity}%`;
    }
}

// رویدادهای ذخیره تنظیمات
document.querySelectorAll('input, select').forEach(element => {
    element.addEventListener('input', saveSettings);
});

// بارگذاری تنظیمات هنگام لود صفحه
window.addEventListener('DOMContentLoaded', loadSettings);



