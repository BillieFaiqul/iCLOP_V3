<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Submissions') }}
            </h2>
            <button id="resetIntroBtn" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                <i class="fas fa-question-circle mr-1"></i>Tutorial
            </button>
        </div>
    </x-slot>

    <div class="py-4"></div>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg pb-12">
                @include('nodejs.submissions.partials.container')
            </div>
        </div>
    </div>
</x-app-layout>
