<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Project:') . ' ' . $project->title }}
        </h2>
    </x-slot>
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Tips Alert for Dashboard -->
            <x-alert.tips-alert pageId="project" title="Tips untuk Anda">
                <p>Selamat datang di project! Berikut adalah beberapa tips untuk membantu Anda:</p>
                <ul class="list-disc pl-5 mt-2">
                    <li>Klik ikon garis 3 di sebelah nama guide untuk membuka opsi</li>
                    <li>Pilih "View" untuk melihat PDF di halaman yang sama</li>
                    <li>Pilih "Open in a new tab" untuk membuka di tab baru</li>
                    <li>Pilih "Download" untuk menyimpan PDF ke perangkat Anda</li>
                    <li>Klik "All Guides" di panel Download untuk mengunduh semua panduan sekaligus</li>
                    <li>Klik "All Supplements" di panel Download untuk mengunduh file tambahan/pendukung</li>
                </ul>
            </x-alert.tips-alert>
        </div>
    </div>
    <div class="pt-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                @include('nodejs.projects.partials.details')
            </div>
        </div>
    </div>
    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg pb-18">
                @include('nodejs.projects.partials.guides')
            </div>
        </div>
    </div>
    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                @include('nodejs.projects.partials.downloads')
            </div>
        </div>
    </div>
</x-app-layout>