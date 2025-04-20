<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Residential;
use Illuminate\Support\Facades\Auth;
use App\Models\Visits;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{
    public function index()
    {
        $dataVisit = Visits::select(
            DB::raw("DATE(visit_date) as date"),
            DB::raw("COUNT(*) as total")
        )
        ->groupBy('date')
        ->orderBy('date')
        ->get();

        $barLabels = $dataVisit->pluck('date')->map(function($date) {
            return \Carbon\Carbon::parse($date)->format('d/m');
        });
        $barData = $dataVisit->pluck('total');

        $datatreatments = Visits::select('treatments.name', DB::raw('COUNT(*) as total'))
        ->join('treatments', 'visits.treatment_id', '=', 'treatments.id')
        ->whereNotNull('visits.treatment_id')
        ->groupBy('treatments.name')
        ->orderByDesc('total')
        ->get();

        $polarLabels = $datatreatments->pluck('name');
        $polarData = $datatreatments->pluck('total');

        return view('dashboard.index', compact('barLabels', 'barData', 'polarLabels', 'polarData'));
    }
}
