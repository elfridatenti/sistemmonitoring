<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Downtime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Setup;
use App\Models\Defect;
use App\Models\User;
use App\Models\MonthlyDefects;
class DashboardController extends Controller
{
    protected $middleware = ['auth'];
    public function index()
    {
        $user = Auth::user();
        $data = [          
            'downtime' => [
                'total' => Downtime::count(),
                'Menunggu' => Downtime::where('status', 'Menunggu')->count(),
                'Sedang_Diproses' => Downtime::where('status', 'Sedang Diproses')->count(),
                'Menunggu_QC_Approve' => Downtime::where('status', 'Menunggu QC Approve')->count(),
                'Completed' => Downtime::where('status', 'Completed')->count()
            ],
            'setup' => [
                'total' => Setup::count(),
                'Menunggu' => Setup::where('status', 'Menunggu')->count(),
                'Sedang Diproses' => Setup::where('status', 'Sedang Diproses')->count(),
                'Menunggu_QC_Approve' => Setup::where('status', 'Menunggu QC Approve')->count(),
                'Completed' => Setup::where('status', 'Completed')->count()
            ],
            'user' => [
                'total' => User::count(),
                'admin' => User::where('role', 'admin')->count(),
                'teknisi' => User::where('role', 'teknisi')->count(),
                'leader' => User::where('role', 'leader')->count(),
                'ipqc' => User::where('role', 'ipqc')->count()
            ]

        ];
        
        if (!$user) {
            return redirect()->route('login');
        }
        
        return view('dashboard', compact('user', 'data'));
    }
    public function chart()
    {
        // Ambil daftar valid defect IDs dan categories dari tabel defects
        $validDefects = DB::table('defects')
            ->select('id', 'defect_category')
            ->get()
            ->keyBy('id');
    
        // Ambil data dari tabel 'downtimes' dengan penanganan kategori yang lebih kompleks
        $defectData = DB::table('downtimes')
            ->leftJoin('defects', 'downtimes.defect_category', '=', 'defects.id')
            ->select(
                DB::raw('CASE
                    WHEN downtimes.defect_category REGEXP \'^[0-9]+$\' AND defects.defect_category IS NOT NULL 
                        THEN defects.defect_category
                    ELSE \'Lainya\'
                END as defect_category'),
                DB::raw('COUNT(*) as category_count')
            )
            ->groupBy('defect_category')
            ->get();
    
        // Kelompokkan dan jumlahkan kategori
        $groupedData = $defectData->groupBy('defect_category')
            ->map(function ($group) {
                return [
                    'defect_category' => $group->first()->defect_category,
                    'category_count' => $group->sum('category_count')
                ];
            })->values();
    
        // Ekstraksi kategori dan jumlahnya untuk grafik
        $categories = $groupedData->pluck('defect_category')->toArray();
        $counts = $groupedData->pluck('category_count')->toArray();
    
        // Buat warna acak untuk grafik
        $backgroundColor = array_map(function () {
            return sprintf('rgba(%d, %d, %d, 0.6)', rand(0, 255), rand(0, 255), rand(0, 255));
        }, $categories);
    
        // Warna border dengan transparansi penuh
        $borderColor = array_map(function ($color) {
            return str_replace('0.6', '1', $color);
        }, $backgroundColor);
    
        // Return data dalam format JSON
        return response()->json([
            'categories' => $categories,
            'counts' => $counts,
            'backgroundColor' => $backgroundColor,
            'borderColor' => $borderColor
        ]);
    }
    public function getSetupRequestsCount()
    {
        return Setup::where('status', '!=', 'Completed')->count();
    }

    public function getDowntimeRequestsCount()
    {
        return Downtime::where('status', '!=', 'Completed')->count();
    }

    public function getUserRequestsCount()
    {
        return User::where('role', '!=', 'role')->count();
    }

   
}

