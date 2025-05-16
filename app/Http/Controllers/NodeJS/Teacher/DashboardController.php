<?php
namespace App\Http\Controllers\NodeJS\Teacher;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik yang sudah ada
        $totalProyek = DB::table('projects')->count();
        
        $totalSiswa = DB::table('users')
            ->where('role', 'student')
            ->count();
            
        // Statistik baru
        
        // 1. Hitung submission yang selesai (status 'completed' atau yang sesuai)
        $submissionSelesai = DB::table('submissions')
            ->where('status', 'completed')
            ->count();
            
        // 2. Hitung siswa yang telah mengirimkan minimal satu proyek
        $siswaSubmisi = DB::table('submissions')
            ->join('users', 'users.id', '=', 'submissions.user_id')
            ->where('users.role', 'student')
            ->distinct('submissions.user_id')
            ->count('submissions.user_id');
            
        // 3. Hitung total submission
        $totalSubmisi = DB::table('submissions')->count();
        
        // 4. Hitung submission yang gagal (status 'failed')
        $submissionGagal = DB::table('submissions')
            ->where('status', 'failed')
            ->count();
        
        // 5. Hitung tingkat keberhasilan (submission selesai vs total submission)
        $tingkatKeberhasilan = $totalSubmisi > 0 
            ? round(($submissionSelesai / $totalSubmisi) * 100) 
            : 0;
        
        // 6. Hitung tingkat kegagalan (submission gagal vs total submission)
        $tingkatKegagalan = $totalSubmisi > 0 
            ? round(($submissionGagal / $totalSubmisi) * 100) 
            : 0;
            
        // 7. Hitung proyek dengan minimal satu submission
        $proyekDenganSubmisi = DB::table('submissions')
            ->distinct('project_id')
            ->count('project_id');
            
        // 8. Hitung proyek tanpa submission
        $proyekTanpaSubmisi = $totalProyek - $proyekDenganSubmisi;
        
        // 9. Hitung persentase siswa yang telah membuat submission
        $tingkatPartisipasiSiswa = $totalSiswa > 0 
            ? round(($siswaSubmisi / $totalSiswa) * 100) 
            : 0;
            
        // 10. Hitung submission yang sedang diproses
        $submisiDalamProses = DB::table('submissions')
            ->where('status', 'processing')
            ->count();
            
        // 11. Hitung submission yang tertunda
        $submisiTertunda = DB::table('submissions')
            ->where('status', 'pending')
            ->count();
            
        // 12. Hitung rata-rata percobaan per submission
        $ratarataPecobaan = DB::table('submissions')
            ->avg('attempts');
        $ratarataPecobaan = round($ratarataPecobaan, 1); // Bulatkan ke 1 angka desimal
        
        return view('nodejs.dashboard-teacher.index', compact(
        'totalProyek',
        'totalSiswa',
        'submissionSelesai',
        'totalSubmisi',
        'tingkatPartisipasiSiswa',
        'submisiDalamProses',
        'submisiTertunda',
        'proyekDenganSubmisi',
        'proyekTanpaSubmisi',
        'siswaSubmisi',
        'ratarataPecobaan',
        'tingkatKeberhasilan',
        'submissionGagal',
        'tingkatKegagalan'
        ));
    }
}