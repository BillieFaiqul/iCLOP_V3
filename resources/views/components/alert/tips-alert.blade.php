<!-- File: resources/views/components/alert/tips-alert.blade.php -->
@props([
    'pageId' => 'default',
    'title' => 'Tips untuk Anda',
    'dontShowAgainText' => 'Jangan Tampilkan Lagi'
])

<div id="tipsAlert_{{ $pageId }}" class="mb-6 bg-white dark:bg-gray-700 border-l-4 border-blue-500 shadow-md rounded-md overflow-hidden">
    <div class="bg-blue-500 text-white px-4 py-2 flex justify-between items-center">
        <h3 class="font-medium flex items-center">
            <span class="mr-2 text-xl">💡</span> {{ $title }}
        </h3>
        <div class="flex items-center">
            <button id="dontShowAgain_{{ $pageId }}" class="text-xs bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded mr-2">
                {{ $dontShowAgainText }}
            </button>
            <button id="closeButton_{{ $pageId }}" class="text-white hover:text-gray-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>
    </div>
    <div class="px-4 py-3 bg-white dark:bg-gray-800 dark:text-gray-200">
        {{ $slot }}
    </div>
</div>

<!-- Tombol untuk menampilkan kembali tips -->
<div id="showTipsAgainButton_{{ $pageId }}" class="hidden mb-6">
    <button class="flex items-center text-white font-bold hover:text-blue-200 dark:text-white dark:hover:text-blue-300">
        <span class="mr-1 text-xl">💡</span>
        <span>Tampilkan tips untuk halaman ini</span>
    </button>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const pageId = '{{ $pageId }}';
        const tipsAlert = document.getElementById('tipsAlert_' + pageId);
        const closeButton = document.getElementById('closeButton_' + pageId);
        const dontShowAgainButton = document.getElementById('dontShowAgain_' + pageId);
        const showTipsAgainButton = document.getElementById('showTipsAgainButton_' + pageId);
        const storageKey = 'tips_dismissed_' + pageId;

        // Check if tips should be shown
        function checkShowTips() {
            if (localStorage.getItem(storageKey) === 'true') {
                hideTips(true);
            }
        }

        function hideTips(showToggleButton = false) {
            if (tipsAlert) {
                tipsAlert.style.display = 'none';
            }
            
            // Tampilkan tombol untuk menampilkan tips kembali
            if (showToggleButton && showTipsAgainButton) {
                showTipsAgainButton.style.display = 'block';
            }
        }

        function showTips() {
            if (tipsAlert) {
                tipsAlert.style.display = 'block';
            }
            
            if (showTipsAgainButton) {
                showTipsAgainButton.style.display = 'none';
            }
        }

        function dontShowAgain() {
            localStorage.setItem(storageKey, 'true');
            hideTips(true);
        }

        function resetTipsPreference() {
            localStorage.removeItem(storageKey);
            showTips();
        }

        // Event listeners
        if (closeButton) {
            closeButton.addEventListener('click', function() {
                hideTips(false); // Sembunyikan tips tanpa menampilkan tombol toggle
            });
        }
        
        if (dontShowAgainButton) {
            dontShowAgainButton.addEventListener('click', dontShowAgain);
        }

        if (showTipsAgainButton) {
            showTipsAgainButton.addEventListener('click', resetTipsPreference);
        }

        // Check on page load
        checkShowTips();
    });
</script>