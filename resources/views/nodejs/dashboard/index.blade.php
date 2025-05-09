<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Tips Alert for Dashboard -->
            <x-alert.tips-alert pageId="dashboard" title="Tips untuk Anda">
                <p>Selamat datang di dashboard! Berikut adalah beberapa tips untuk membantu Anda:</p>
                <ul class="list-disc pl-5 mt-2">
                    <li>Gunakan panel Projects untuk melihat detail project</li>
                    <li>Untuk submissions bisa dilihat di panel Submissions</li>
                    <li>Pilih proyek dari dropdown sebelum mengunggah</li>
                    <li>Unggah file dengan cara drag & drop ZIP atau klik Browse Atau, masukkan link GitHub lengkap di kolom yang tersedia. Lalu klik tombol SUBMIT</li>
                    <li>Maka anda akan di arahkan ke proses pengujian</li>
                    <li>Anda bisa kemabali ke halaman dashboard untuk melihat status pengumpulan</li>
                </ul>
            </x-alert.tips-alert>
        </div>
    </div>

    <div class="pb-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                @include('nodejs.dashboard.partials.projects.list')
            </div>
        </div>
    </div>

    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                @include('nodejs.dashboard.partials.submissions.container')
            </div>
        </div>
    </div>
</x-app-layout>