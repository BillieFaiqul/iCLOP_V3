<?php

namespace App\Http\Controllers\NodeJS\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RankController extends Controller
{
    /**
     * Display the ranking page
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('nodejs.rank-teacher.index');
    }

    /**
     * Get the ranking data for a specific project
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRankingByProject(Request $request)
    {
        $projectId = $request->input('project_id');
        
        if (!$projectId) {
            return response()->json([
                'status' => 'error',
                'message' => 'Project ID is required'
            ], 400);
        }

        // Get all submissions for this project
        $submissions = DB::table('submissions')
            ->join('users', 'submissions.user_id', '=', 'users.id')
            ->where('submissions.project_id', $projectId)
            ->select(
                'submissions.id',
                'submissions.user_id',
                'users.name as user_name',
                'submissions.attempts',
                'submissions.results',
                'submissions.updated_at'
            )
            ->get();

        // Process the submissions to calculate scores
        $rankings = [];
        $processedUsers = [];

        foreach ($submissions as $submission) {
            $userId = $submission->user_id;
            
            // Parse the results JSON
            $resultsData = json_decode($submission->results, true);
            
            if (!$resultsData) {
                continue; // Skip invalid results
            }

            // Calculate total tests and passed tests
            $totalTests = 0;
            $passedTests = 0;

            foreach ($resultsData as $testSuite) {
                if (isset($testSuite['testResults'])) {
                    foreach ($testSuite['testResults'] as $result) {
                        if (isset($result['totalTests']) && isset($result['passedTests'])) {
                            $totalTests += $result['totalTests'];
                            $passedTests += $result['passedTests'];
                        }
                    }
                }
            }

            // Calculate percentage score
            $score = $totalTests > 0 ? ($passedTests / $totalTests) * 100 : 0;
            $score = round($score, 2); // Round to 2 decimal places

            // If we already processed this user, only keep the higher score
            if (isset($processedUsers[$userId])) {
                if ($score > $processedUsers[$userId]['score']) {
                    $processedUsers[$userId] = [
                        'user_id' => $userId,
                        'user_name' => $submission->user_name,
                        'attempts' => $submission->attempts,
                        'score' => $score,
                        'total_tests' => $totalTests,
                        'passed_tests' => $passedTests,
                        'submission_date' => $submission->updated_at,
                    ];
                }
            } else {
                $processedUsers[$userId] = [
                    'user_id' => $userId,
                    'user_name' => $submission->user_name,
                    'attempts' => $submission->attempts,
                    'score' => $score,
                    'total_tests' => $totalTests,
                    'passed_tests' => $passedTests,
                    'submission_date' => $submission->updated_at,
                ];
            }
        }

        // Convert to array and sort by score (descending)
        $rankings = array_values($processedUsers);
        usort($rankings, function($a, $b) {
            if ($a['score'] == $b['score']) {
                // If scores are equal, sort by submission date (earlier is better)
                return strtotime($a['submission_date']) - strtotime($b['submission_date']);
            }
            return $b['score'] - $a['score'];
        });

        // Add rank information
        $rank = 1;
        foreach ($rankings as $key => $value) {
            $rankings[$key]['rank'] = $rank++;
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'rankings' => $rankings
            ]
        ]);
    }

    /**
     * Get all projects for the ranking dropdown
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProjects()
    {
        $projects = DB::table('projects')
            ->select('id', 'title')  // Alias 'title' as 'name' to match frontend expectations
            ->orderBy('title')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => [
                'projects' => $projects
            ]
        ]);
    }

    /**
     * Export ranking data to CSV
     * 
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportRanking(Request $request)
    {
        $projectId = $request->input('project_id');
        
        if (!$projectId) {
            return response()->json([
                'status' => 'error',
                'message' => 'Project ID is required'
            ], 400);
        }

        // Get project name
        $project = DB::table('projects')
            ->where('id', $projectId)
            ->first();

        if (!$project) {
            return response()->json([
                'status' => 'error',
                'message' => 'Project not found'
            ], 404);
        }

        // Get rankings data by calling the existing method
        $rankingResponse = $this->getRankingByProject($request);
        $content = json_decode($rankingResponse->getContent(), true);
        
        if (!isset($content['data']['rankings'])) {
            return response()->json([
                'status' => 'error',
                'message' => 'No ranking data available'
            ], 404);
        }

        $rankings = $content['data']['rankings'];
        $filename = 'ranking_' . \Illuminate\Support\Str::slug($project->title) . '_' . date('Y-m-d') . '.csv';

        // Create CSV headers
        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        // Create the CSV file
        $callback = function() use ($rankings) {
            $file = fopen('php://output', 'w');
            
            // Add CSV header row
            fputcsv($file, ['Rank', 'Name', 'Attempts', 'Score (%)', 'Passed Tests', 'Total Tests', 'Submission Date']);
            
            // Add data rows
            foreach ($rankings as $ranking) {
                fputcsv($file, [
                    $ranking['rank'],
                    $ranking['user_name'],
                    $ranking['attempts'],
                    $ranking['score'],
                    $ranking['passed_tests'],
                    $ranking['total_tests'],
                    $ranking['submission_date']
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}