<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Student Rankings') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="w-full mx-auto px-4 sm:px-6 lg:px-8">
            <div class=" dark:bg-slate-800 overflow-hidden shadow-xl sm:rounded-lg border  dark:border-gray-700">
                <!-- Header with project selector -->
                <div class="flex flex-col md:flex-row justify-between items-center dark:bg-slate-900 p-4 border-b border-gray-200 dark:border-gray-700">
                    <span class="text-xl font-bold text-gray-800 dark:text-white mb-4 md:mb-0">Student Rankings</span>
                    <div class="w-full md:w-96">
                        <select id="project-selector" class= "bg-gray-50 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-secondary-500 focus:border-secondary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-secondary-500 dark:focus:border-secondary-500">
                            <option value="">Select Project</option>
                        </select>
                    </div>
                </div>

                <div class="p-6">
                    <!-- Loading indicator -->
                    <div id="loading" class="text-center my-8 hidden">
                        <div class="inline-block animate-spin rounded-full h-12 w-12 border-4 border-blue-500 border-t-transparent"></div>
                        <p class="mt-4 text-gray-600 dark:text-gray-400">Loading data...</p>
                    </div>

                    <!-- No project selected message -->
                    <div id="no-project-selected" class="text-center my-12">
                        <svg class="mx-auto h-16 w-16 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        <p class="mt-4 text-lg font-medium text-gray-600 dark:text-gray-400">Please select a project to view rankings</p>
                    </div>

                    <!-- Rankings data container -->
                    <div id="ranking-data" class="hidden">
                        <!-- Export button -->
                        <div class="flex justify-end mb-5">
                            <button id="export-csv" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors flex items-center shadow-md">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                Export to CSV
                            </button>
                        </div>

                        <!-- Rankings table -->
                        <div class="overflow-x-auto dark:bg-slate-800 rounded-lg shadow-md">
                            <table class="w-full table-fixed divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700 text-gray-500 dark:text-gray-300">
                                    <tr>
                                        <th scope="col" class="w-1/12 px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-white uppercase tracking-wider">Rank</th>
                                        <th scope="col" class="w-3/12 px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-white uppercase tracking-wider">Name</th>
                                        <th scope="col" class="w-1/12 px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-white uppercase tracking-wider">Attempts</th>
                                        <th scope="col" class="w-1/12 px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-white uppercase tracking-wider">Score</th>
                                        <th scope="col" class="w-1/12 px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-white uppercase tracking-wider">Passed</th>
                                        <th scope="col" class="w-1/12 px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-white uppercase tracking-wider">Total</th>
                                        <th scope="col" class="w-2/12 px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-white uppercase tracking-wider">Last Submission</th>
                                    </tr>
                                </thead>
                                <tbody id="ranking-table-body" class="divide-y divide-gray-200 dark:divide-gray-700">
                                    <!-- Rankings will be populated here -->
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- No data message -->
                    <div id="no-data" class="text-center my-12 hidden">
                        <svg class="mx-auto h-16 w-16 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M12 14h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="mt-4 text-lg font-medium text-gray-600 dark:text-gray-400">No submissions found for this project</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            // Load projects for dropdown
            loadProjects();

            // Project selection change event
            $('#project-selector').change(function() {
                const projectId = $(this).val();
                if (projectId) {
                    loadRankings(projectId);
                } else {
                    $('#ranking-data').hide();
                    $('#no-project-selected').show();
                    $('#no-data').hide();
                }
            });

            // Export to CSV button click event
            $('#export-csv').click(function() {
                const projectId = $('#project-selector').val();
                if (projectId) {
                    window.location.href = `{{ route('nodejs.teacher.rank.export') }}?project_id=${projectId}`;
                }
            });
        });

        function loadProjects() {
            $.ajax({
                url: "{{ route('nodejs.teacher.rank.projects') }}",
                type: "GET",
                beforeSend: function() {
                    $('#loading').show();
                },
                success: function(response) {
                    if (response.status === 'success') {
                        const projects = response.data.projects;
                        let options = '<option value="">Pilih Proyek</option>';
                        
                        projects.forEach(project => {
                            options += `<option value="${project.id}">${project.title}</option>`;
                        });
                        
                        $('#project-selector').html(options);
                    }
                },
                error: function(xhr) {
                    console.error('Error loading projects', xhr);
                    alert('Gagal memuat proyek. Silakan coba lagi.');
                },
                complete: function() {
                    $('#loading').hide();
                }
            });
        }

        function loadRankings(projectId) {
            $.ajax({
                url: "{{ route('nodejs.teacher.rank.by-project') }}",
                type: "GET",
                data: {
                    project_id: projectId
                },
                beforeSend: function() {
                    $('#ranking-data').hide();
                    $('#no-project-selected').hide();
                    $('#no-data').hide();
                    $('#loading').show();
                },
                success: function(response) {
                    if (response.status === 'success') {
                        const rankings = response.data.rankings;
                        
                        if (rankings.length > 0) {
                            populateRankingsTable(rankings);
                            $('#ranking-data').show();
                        } else {
                            $('#no-data').show();
                        }
                    }
                },
                error: function(xhr) {
                    console.error('Error loading rankings', xhr);
                    alert('Gagal memuat peringkat. Silakan coba lagi.');
                },
                complete: function() {
                    $('#loading').hide();
                }
            });
        }

        function populateRankingsTable(rankings) {
            let tableRows = '';
            
            rankings.forEach(student => {
                const submissionDate = new Date(student.submission_date).toLocaleString();
                
                // Adding special class for top 3 performers with improved contrast
                let rowClass = '';
                if (student.rank <= 3) {
                    rowClass = 'top-performer';
                }
                
                tableRows += `
                    <tr class="${rowClass}">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                            ${student.rank <= 3 ? 
                                `<span class="inline-flex items-center justify-center w-6 h-6 rounded-full ${
                                    student.rank === 1 ? 'bg-yellow-400 gold-medal' : 
                                    student.rank === 2 ? 'bg-gray-300 silver-medal' : 
                                    'bg-amber-600 bronze-medal'} text-white font-bold">
                                    ${student.rank}
                                </span>` : 
                                student.rank
                            }
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">${student.user_name}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">${student.attempts}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white font-medium">${student.score}%</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">${student.passed_tests}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">${student.total_tests}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">${submissionDate}</td>
                    </tr>
                `;
            });
            
            $('#ranking-table-body').html(tableRows);
        }
    </script>
    @endsection
</x-app-layout>