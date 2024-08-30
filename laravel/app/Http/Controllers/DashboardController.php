<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Predictions;
use App\Models\User;
use Carbon\Carbon;
class DashboardController extends Controller
{
    //
    public function index()
    {
        // Menghitung total user dan total prediksi
        $totalUsers = User::count();
        $totalPredictions = Predictions::count();

        // Mendapatkan data pertumbuhan pengguna per bulan
        $userGrowth = User::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                          ->groupBy('month')
                          ->pluck('count', 'month');

        // Mendapatkan data pertumbuhan prediksi per bulan
        $predictionGrowth = Predictions::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                                      ->groupBy('month')
                                      ->pluck('count', 'month');

        // Mengatur label bulan
        $months = collect(range(1, 12))->map(function($month) {
            return Carbon::create()->month($month)->format('F');
        });

        // Menyesuaikan data untuk chart
        $userChartData = $months->map(function($month, $key) use ($userGrowth) {
            return $userGrowth->get($key + 1, 0);
        });

        $predictionChartData = $months->map(function($month, $key) use ($predictionGrowth) {
            return $predictionGrowth->get($key + 1, 0);
        });

        return view('admin.index', compact('totalUsers', 'totalPredictions', 'userChartData', 'predictionChartData', 'months'));
    }
    
}
