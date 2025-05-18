<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Icon -->
    <link rel="icon" href="{{ asset('/application_icon.ico') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" />
    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/intro.js/minified/introjs.min.css" />
    <!-- Tambahan: tema Intro.js untuk tampilan yang lebih baik -->
    <link rel="stylesheet" href="https://unpkg.com/intro.js/themes/introjs-modern.css" />

    <link href="{{asset('css/nodejs_style.css')}}" rel="stylesheet">

    <!-- Custom CSS for IntroJS modification -->
    <style>
        /* Hide the default skip button */
        .introjs-skipbutton {
            display: none !important;
        }
        
        /* Custom navigation container at bottom */
        .introjs-tooltipbuttons {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        /* Custom skip button at bottom */
        .custom-skip-button {
            display: inline-block;
            text-decoration: none;
            padding: 6px 16px;
            font-size: 14px;
            font-weight: bold;
            line-height: 1.5;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            cursor: pointer;

            color: white;
            background-color: transparent;
            border: 1px solid transparent; /* awalnya tidak terlihat */
            border-radius: 999px;
            transition: all 0.2s ease;
        }

        .custom-skip-button:hover {
            border-color: white;
            background-color: transparent;
        }

    </style>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.4.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
    <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://unpkg.com/pdfobject@2.2.10/pdfobject.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/intro.js/minified/intro.min.js"></script>
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        @include('nodejs.layouts.navigation')

        <!-- Page Heading -->
        @if (isset($header))
        <header class="bg-white dark:bg-gray-800 shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
        @endif

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>

    <!-- Konfigurasi Intro.js yang dimodifikasi -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Cek apakah pengguna sudah pernah melihat intro (menggunakan localStorage)
            const hasSeenIntro = localStorage.getItem('hasSeenNodeJSIntro');
            
            // Cek apakah ada elemen dengan data-step di halaman
            const hasIntroElements = document.querySelectorAll('[data-step]').length > 0;
            
            if (hasIntroElements && !hasSeenIntro) {
                startTutorial();
            }
            
            // Tambahkan event listener untuk tombol reset tutorial
            const resetIntroBtn = document.getElementById('resetIntroBtn');
            if (resetIntroBtn) {
                resetIntroBtn.addEventListener('click', function() {
                    localStorage.removeItem('hasSeenNodeJSIntro');
                    startTutorial();
                });
            }
            
            // Fungsi untuk memulai tutorial
            function startTutorial() {
                if (document.querySelectorAll('[data-step]').length === 0) return;
                
                // Konfigurasi yang lebih lengkap untuk intro.js
                const intro = introJs();
                
                // Konfigurasi umum
                intro.setOptions({
                    nextLabel: 'Lanjut',
                    prevLabel: 'Kembali',
                    skipLabel: 'Lewati', // Ini tidak akan terlihat karena kita sembunyikan button aslinya
                    doneLabel: 'Selesai',
                    hidePrev: false,
                    hideNext: false,
                    showStepNumbers: true,
                    showBullets: true,
                    showProgress: true,
                    scrollToElement: true,
                    scrollTo: 'element',
                    disableInteraction: false,
                    tooltipPosition: 'auto',
                    highlightClass: 'intro-highlight',
                    tooltipClass: 'customTooltip',
                    exitOnOverlayClick: false,
                    exitOnEsc: true,
                    overlayOpacity: 0.8
                });
                
                // Event untuk memodifikasi tooltips setelah mereka dibuat
                intro.onafterchange(function(targetElement) {
                    // Sembunyikan tombol skip default dan buat tombol skip kustom
                    setTimeout(function() {
                        const tooltipButtons = document.querySelector('.introjs-tooltipbuttons');
                        const skipExists = tooltipButtons.querySelector('.custom-skip-button');
                        
                        // Hanya tambahkan tombol jika belum ada
                        if (!skipExists) {
                            const skipButton = document.createElement('button');
                            skipButton.className = 'custom-skip-button';
                            skipButton.innerHTML = 'Lewati';
                            
                            // Tambahkan event untuk skip
                            skipButton.addEventListener('click', function() {
                                intro.exit();
                                localStorage.setItem('hasSeenNodeJSIntro', 'true');
                            });
                            
                            // Tempatkan tombol Lewati di sebelah paling kanan
                            const nextButtons = tooltipButtons.querySelector('.introjs-nextbutton');
                            tooltipButtons.appendChild(skipButton);
                        }
                    }, 10);
                });
                
                // Jalankan tutorial
                intro.start();
                
                // Simpan bahwa pengguna sudah melihat intro
                intro.oncomplete(function() {
                    localStorage.setItem('hasSeenNodeJSIntro', 'true');
                });
                
                intro.onexit(function() {
                    localStorage.setItem('hasSeenNodeJSIntro', 'true');
                });
            }
        });
    </script>

    @yield('scripts')
</body>

</html>