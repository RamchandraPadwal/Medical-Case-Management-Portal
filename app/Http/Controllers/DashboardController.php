<?php

namespace App\Http\Controllers;

use App\Models\MedicalCase;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $byStatus = MedicalCase::query()
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $counts = [
            'Total cases' => $byStatus->sum(),
            'Planning' => $byStatus['Planning'] ?? 0,
            'In Review' => $byStatus['In Review'] ?? 0,
            'Approved' => $byStatus['Approved'] ?? 0,
            'Completed' => $byStatus['Completed'] ?? 0,
        ];

        return view('dashboard', compact('counts'));
    }
}
