<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Teacher Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 pb-12">
            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-16">
                <!-- Total Projects -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-indigo-500 bg-opacity-75">
                                <i class="fas fa-project-diagram text-white text-2xl"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Projects</p>
                                <p class="text-lg font-semibold">{{ $totalProyek }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Total Students -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-500 bg-opacity-75">
                                <i class="fas fa-users text-white text-2xl"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Students</p>
                                <p class="text-lg font-semibold">{{ $totalSiswa }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Total Submissions -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-500 bg-opacity-75">
                                <i class="fas fa-file-code text-white text-2xl"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Submissions</p>
                                <p class="text-lg font-semibold">{{ $totalSubmisi }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Completed Submissions -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-purple-500 bg-opacity-75">
                                <i class="fas fa-check-circle text-white text-2xl"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Completed Submissions</p>
                                <p class="text-lg font-semibold">{{ $submissionSelesai }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Failed Submissions -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-purple-500 bg-opacity-75">
                                <i class="fas fa-times-circle text-white text-2xl"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Failed Submissions</p>
                                <p class="text-lg font-semibold">{{ $submissionGagal }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Average Submissions -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-yellow-500 bg-opacity-75">
                                <i class="fas fa-calculator text-white text-2xl"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Average Submissions Attempts</p>
                                <p class="text-lg font-semibold">{{ $ratarataPecobaan }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Row -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-8 mt-4">
                <!-- Submission Status Chart -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Submission Status</h3>
                        <div class="relative h-64">
                            <canvas id="submissionStatusChart"></canvas>
                        </div>
                    </div>
                </div>
                
                <!-- Project Distribution Chart -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Projects with vs without Submissions</h3>
                        <div class="relative h-64">
                            <canvas id="projectDistributionChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-4 mb-8 mt-4">
                <!-- Student Participation Rate -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Student Participation</h3>
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Active Students</p>
                                <p class="text-2xl font-bold">{{ $siswaSubmisi }} / {{ $totalSiswa }}</p>
                            </div>
                            <div class="relative w-24 h-24">
                                <canvas id="participationChart"></canvas>
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <span class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ $tingkatPartisipasiSiswa }}%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Success Rate -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Submission Success Rate</h3>
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Completed Submissions</p>
                                <p class="text-2xl font-bold">{{ $submissionSelesai }} / {{ $totalSubmisi }}</p>
                            </div>
                            <div class="relative w-24 h-24">
                                <canvas id="successRateChart"></canvas>
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <span class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ $tingkatKeberhasilan ?? 0 }}%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Detailed Statistics -->
            <div class="grid grid-cols-1 gap-4 mb-8 mt-4 w-full">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg w-full">
                    <div class="p-6 w-full">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Detailed Statistics</h3>
                        <div class="overflow-x-auto w-full">
                            <table class="w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead>
                                    <tr>
                                        <th class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Metric</th>
                                        <th class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Value</th>
                                        <th class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Description</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">Projects with Submissions</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $proyekDenganSubmisi }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">Number of projects that have at least one submission</td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">Projects without Submissions</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $proyekTanpaSubmisi }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">Number of projects that have no submissions yet</td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">Processing Submissions</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $submisiDalamProses }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">Number of submissions currently being processed</td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">Pending Submissions</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $submisiTertunda }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">Number of submissions awaiting action</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Submission Status Chart
        const submissionStatusCtx = document.getElementById('submissionStatusChart').getContext('2d');
        const submissionStatusChart = new Chart(submissionStatusCtx, {
            type: 'bar',
            data: {
                labels: ['Completed', 'Processing', 'Pending', 'Failed'],  // Tambah label Failed
                datasets: [{
                    label: 'Submission Status',
                    data: [{{ $submissionSelesai }}, {{ $submisiDalamProses }}, {{ $submisiTertunda }}, {{ $submissionGagal }}],  // Tambah data failed
                    backgroundColor: [
                        'rgba(72, 187, 120, 0.7)', // Green for completed
                        'rgba(66, 153, 225, 0.7)', // Blue for processing
                        'rgba(237, 137, 54, 0.7)',  // Orange for pending
                        'rgba(220, 53, 69, 0.7)'    // Red for failed
                    ],
                    borderColor: [
                        'rgba(72, 187, 120, 1)',
                        'rgba(66, 153, 225, 1)',
                        'rgba(237, 137, 54, 1)',
                        'rgba(220, 53, 69, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });


        // Project Distribution Chart
        const projectDistributionCtx = document.getElementById('projectDistributionChart').getContext('2d');
        const projectDistributionChart = new Chart(projectDistributionCtx, {
            type: 'pie',
            data: {
                labels: ['Projects with Submissions', 'Projects without Submissions'],
                datasets: [{
                    data: [{{ $proyekDenganSubmisi }}, {{ $proyekTanpaSubmisi }}],
                    backgroundColor: [
                        'rgba(79, 209, 197, 0.7)', // Teal
                        'rgba(159, 122, 234, 0.7)' // Purple
                    ],
                    borderColor: [
                        'rgba(79, 209, 197, 1)',
                        'rgba(159, 122, 234, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });

        // Participation Rate Chart
        const participationCtx = document.getElementById('participationChart').getContext('2d');
        const participationChart = new Chart(participationCtx, {
            type: 'doughnut',
            data: {
                labels: ['Active', 'Inactive'],
                datasets: [{
                    data: [{{ $siswaSubmisi }}, {{ $totalSiswa - $siswaSubmisi }}],
                    backgroundColor: [
                        'rgba(104, 211, 145, 0.7)', // Green
                        'rgba(226, 232, 240, 0.7)'  // Light gray
                    ],
                    borderColor: [
                        'rgba(104, 211, 145, 1)',
                        'rgba(226, 232, 240, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                cutout: '70%',
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

        // Success Rate Chart
        const successRateCtx = document.getElementById('successRateChart').getContext('2d');
        const successRateChart = new Chart(successRateCtx, {
            type: 'doughnut',
            data: {
                labels: ['Completed', 'Incomplete'],
                datasets: [{
                    data: [{{ $submissionSelesai }}, {{ $totalSubmisi - $submissionSelesai }}],
                    backgroundColor: [
                        'rgba(72, 187, 120, 0.7)', // Green
                        'rgba(226, 232, 240, 0.7)'  // Light gray
                    ],
                    borderColor: [
                        'rgba(72, 187, 120, 1)',
                        'rgba(226, 232, 240, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                cutout: '70%',
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    </script>
    @endsection
</x-app-layout>