<?php

namespace App\Http\Controllers\NodeJS\Student;

use App\Http\Controllers\Controller;
use Exception;
use ZipArchive;
use App\Models\NodeJS\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\Process\Process;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $projects = Project::all();
        return view('nodejs.projects.index', compact('projects'));
    }

    public function show(Request $request, $project_id)
    {
        $project = Project::find($project_id);
        if (!$project) {
            return redirect()->route('projects');
        }
        return view('nodejs.projects.show', compact('project'));
    }

    public function showPDF(Request $request)
    {
        if ($request->ajax()) {
            if ($request->id) {
                $media = Media::find($request->id);
                if ($media) {
                    $path = $media->getUrl();
                    return response()->json($path, 200);
                }
                return response()->json(["message" => "media not found"], 404);
            }
            return response()->json(["message" => "no media was requested"], 400);
        }
    }

    public function download(Request $request, $project_id)
    {
        if ($request->ajax()) {
            $project = Project::find($project_id);
            if (!$project) {
                return response()->json(["message" => "project not found"], 404);
            }
            if ($request->type) {
                switch ($request->type) {
                    case 'guides':
                        $zipMedia = $project->getMedia('project_zips')->where('file_name', 'guides.zip')->first();
                        if ($zipMedia) {
                            return response()->json($zipMedia->getUrl(), 200);
                        } else {
                            $guides = $project->getMedia('project_guides');
                            $tempDir = storage_path('app/public/assets/projects/' . $project->title . '/zips');
                            if (!is_dir($tempDir)) mkdir($tempDir);
                            foreach ($guides as $guide) {
                                $path = $guide->getPath();
                                $filename = $guide->file_name;
                                copy($path, $tempDir . '/' . $filename);
                            }
                            $zipPath = $tempDir . '/guides.zip';
                            $zip = new ZipArchive;
                            if ($zip->open($zipPath, ZipArchive::CREATE) === TRUE) {
                                $files = Storage::files('public/assets/projects/' . $project->title . '/zips');
                                foreach ($files as $file) {
                                    $zip->addFile(storage_path('app/' . $file), basename($file));
                                }
                                $zip->close();
                                foreach ($files as $file) {
                                    unlink(storage_path('app/' . $file));
                                }
                            } else {
                                throw new Exception('Failed to create zip archive');
                            }
                            $media = $project->addMedia($zipPath)->toMediaCollection('project_zips', 'public_projects_files');
                            return response()->json($media->getUrl(), 200);
                        }
                        break;
                    case 'supplements':
                        $zipMedia = $project->getMedia('project_zips')->where('file_name', 'supplements.zip')->first();
                        if ($zipMedia) {
                            return response()->json($zipMedia->getUrl(), 200);
                        } else {
                            $supplements = $project->getMedia('project_supplements');
                            $tempDir = storage_path('app/public/assets/projects/' . $project->title . '/zips');
                            if (!is_dir($tempDir)) mkdir($tempDir);
                            foreach ($supplements as $supplement) {
                                $path = $supplement->getPath();
                                $filename = $supplement->file_name;
                                copy($path, $tempDir . '/' . $filename);
                            }
                            $zipPath = $tempDir . '/supplements.zip';
                            $zip = new ZipArchive;
                            if ($zip->open($zipPath, ZipArchive::CREATE) === TRUE) {
                                $files = Storage::files('public/assets/projects/' . $project->title . '/zips');
                                foreach ($files as $file) {
                                    $zip->addFile(storage_path('app/' . $file), basename($file));
                                }
                                $zip->close();
                                foreach ($files as $file) {
                                    unlink(storage_path('app/' . $file));
                                }
                            } else {
                                throw new Exception('Failed to create zip archive');
                            }
                            $media = $project->addMedia($zipPath)->toMediaCollection('project_zips', 'public_projects_files');
                            return response()->json($media->getUrl(), 200);
                        }
                        break;
                    case 'tests':
                        $zipMedia = $project->getMedia('project_zips')->where('file_name', 'tests.zip')->first();
                        if ($zipMedia) {
                            return response()->json($zipMedia->getUrl(), 200);
                        } else {
                            // Perbaiki collection name sesuai database
                            $tests = $project->getMedia('project_tests');

                            // Tambahkan pengecekan apakah ada file tests
                            if (count($tests) === 0) {
                                return response()->json(["message" => "no tests available"], 404);
                            }

                            $tempDir = storage_path('app/public/assets/projects/' . $project->title . '/zips');
                            if (!is_dir($tempDir)) mkdir($tempDir);

                            // Copy semua file tests ke tempDir
                            foreach ($tests as $test) {
                                $path = $test->getPath();
                                $filename = $test->file_name;
                                copy($path, $tempDir . '/' . $filename);
                            }

                            $zipPath = $tempDir . '/tests.zip';
                            $zip = new ZipArchive;
                            if ($zip->open($zipPath, ZipArchive::CREATE) === TRUE) {
                                $files = Storage::files('public/assets/projects/' . $project->title . '/zips');
                                foreach ($files as $file) {
                                    // Skip jika file adalah zip itu sendiri
                                    if (basename(storage_path('app/' . $file)) !== 'tests.zip') {
                                        $zip->addFile(storage_path('app/' . $file), basename($file));
                                    }
                                }
                                $zip->close();
                                
                                // Hapus file individual setelah di-zip
                                foreach ($files as $file) {
                                    if (basename(storage_path('app/' . $file)) !== 'tests.zip') {
                                        unlink(storage_path('app/' . $file));
                                    }
                                }
                            } else {
                                throw new Exception('Failed to create zip archive');
                            }
                            $media = $project->addMedia($zipPath)->toMediaCollection('project_zips', 'public_projects_files');
                            return response()->json($media->getUrl(), 200);
                        }
                        break;
                }
            } else {
                return response()->json(["message" => "no type was requested"], 400);
            }
        }
    }
}
