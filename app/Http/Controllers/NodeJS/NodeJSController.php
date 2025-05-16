<?php

namespace App\Http\Controllers\NodeJS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NodeJSController extends Controller
{
    public function index()
    {
       
    }

    public function dashboardStudent() {
        $topicCount = DB::table('projects')->count();
        return view('dashboard_student', compact('topicCountt'));
    }

    public function dashboardTeacher() {
        $topicCount = DB::table('projects')->count();
        return view('dashboard_teacher', compact('topicCount'));
    }

}