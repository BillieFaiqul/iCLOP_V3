<x-app-layout>
     <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight" data-step="1" data-intro="Ini adalah judul dari project yang sedang Anda lihat saat ini" data-title="Project Name" data-position="top" data-disable-interaction="false">
                {{ __('Project:') . ' ' . $project->title }}
            </h2>
            <button id="resetIntroBtn" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                <i class="fas fa-question-circle mr-1"></i> Lihat Tutorial
            </button>
        </div>
    </x-slot>
    <div class="pt-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg" data-step="2" data-intro="Bagian ini berisi detail project termasuk judul, deskripsi dan teknologi yang digunakan dalam project ini" data-title="Project Detail" data-position="top" data-disable-interaction="false">
                @include('nodejs.projects.partials.details')
            </div>
        </div>
    </div>
    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg pb-18" data-step="3" data-intro="Di bagian ini, Anda dapat melihat semua panduan PDF terkait project ini. Klik 'View' untuk membuka panduan PDF langsung di halaman ini" data-title="Project Guide" data-position="top" data-disable-interaction="false">
                @include('nodejs.projects.partials.guides')
            </div>
        </div>
    </div>
    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg" data-step="4" data-intro="Di sini Anda dapat mengunduh semua materi project sekaligus berdasarkan kategori - panduan, materi tambahan, dan tes" data-title="Project Download" data-position="top" data-disable-interaction="false">
                @include('nodejs.projects.partials.downloads')
            </div>
        </div>
    </div>
</x-app-layout>