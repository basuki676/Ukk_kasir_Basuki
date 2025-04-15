<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function ViewDashboard()
    {
        $data = [];

        if (auth()->user()->role == 'employe') {
            // Data untuk pegawai
            $data['todayTransactionCount'] = Sale::whereDate('created_at', Carbon::today())->count();

            $lastSale = Sale::whereDate('created_at', Carbon::today())
                            ->latest()
                            ->first();

            $data['lastUpdated'] = $lastSale
                ? $lastSale->created_at->format('d M Y H:i')
                : 'Belum ada transaksi hari ini';

        } elseif (auth()->user()->role == 'admin') {
            // Data perbandingan penjualan hari ini dan kemarin
            $todaySales = Sale::whereDate('created_at', Carbon::today())->count();
            $yesterdaySales = Sale::whereDate('created_at', Carbon::yesterday())->count();

            $change = $yesterdaySales
                ? round((($todaySales - $yesterdaySales) / $yesterdaySales) * 100, 2)
                : 0;

            $data['salesComparison'] = [
                'today' => $todaySales,
                'yesterday' => $yesterdaySales,
                'change' => $change
            ];

            // Data untuk chart penjualan 7 hari terakhir
            $startDate = Carbon::now()->subDays(6)->startOfDay();
            $endDate = Carbon::now()->endOfDay();

            $chartRawData = Sale::select(
                    DB::raw('DATE(created_at) as date'),
                    DB::raw('COUNT(*) as total')
                )
                ->whereBetween('created_at', [$startDate, $endDate])
                ->groupBy(DB::raw('DATE(created_at)'))
                ->orderBy('date')
                ->get()
                ->keyBy('date');

            $dates = [];
            $totals = [];

            for ($i = 0; $i < 7; $i++) {
                $date = Carbon::now()->subDays(6 - $i)->format('Y-m-d');
                $dates[] = Carbon::parse($date)->format('M d');
                $totals[] = $chartRawData->has($date) ? $chartRawData[$date]->total : 0;
            }

            $data['chartData'] = [
                'dates' => $dates,
                'totals' => $totals
            ];

            // Data untuk pie chart produk
            $startDate = Carbon::now()->subDays(6)->startOfDay();
            $endDate = Carbon::now()->endOfDay();

            $products = Product::withCount(['detailSales as sales_count' => function($query) use ($startDate, $endDate) {
                $query->select(DB::raw('COALESCE(SUM(amount), 0)'))
                      ->whereBetween('created_at', [$startDate, $endDate]);
            }])
            ->orderByDesc('sales_count')
            ->limit(6)
            ->get();

            $data['productData'] = [
                'products' => $products->pluck('name')->toArray(),
                'quantities' => $products->pluck('sales_count')->toArray()
            ];
}

        return view('dashboard', $data);
    }
}
