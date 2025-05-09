<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Submissions') }}
        </h2>
    </x-slot>
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Tips Alert for Dashboard -->
            <x-alert.tips-alert pageId="submission-index" title="Tips untuk Anda">
                <p>Selamat datang di Submission! Berikut adalah beberapa tips untuk membantu Anda:</p>
                <ul class="list-disc pl-5 mt-2">
                    <li>Perhatikan kolom "Status" untuk melihat hasil pengajuan Anda</li>
                    <li>Klik ikon menu garis 3 untuk melihat opsi tindakan</li>
                    <li>Pilih "Restart submission" untuk mencoba ulang pengajuan yang gagal</li>
                    <li>Pilih "Delete submission" untuk menghapus pengajuan dari daftar</li>
                    <li>Klik judul project untuk melihat history dan lebih detail mengenai submission</li>
                </ul>
            </x-alert.tips-alert>
        </div>
    </div>
    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg pb-12">
                @include('nodejs.submissions.partials.container')
            </div>
        </div>
    </div>
</x-app-layout>