<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\TreatmentDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SystemController extends Controller
{
    public function getDashboard()
    {
        $dashboardColumnChartData = $this->getDashboardColumnChart();
        $dashboardPieChartData = $this->getDashboardPieChart();
        $getService = $this->getServiceTop();
        $getRecentTransactions = $this->getRecentTransactions();
        $transactionsMonthData = $this->getDashboardLineChart();

        return view(
            'System.index',
            [
                'patientData' => $dashboardColumnChartData,
                'priceData' => $dashboardPieChartData,
                'serviceTop' => $getService,
                'transactions' => $getRecentTransactions,
                'transactionsMonthData' => $transactionsMonthData
            ]
        );
    }

    public function getDashboardColumnChart()
    {
        Carbon::setLocale('vi');
        $now = Carbon::now();

        $patientData = [];
        for ($i = 0; $i < 13; $i++) {
            $date = $now->copy()->subMonths($i);
            $totalPatient = Patient::whereMonth('created_at', $date->format('m'))
                ->whereYear('created_at', $date->format('Y'))
                ->whereNull('deleted_at')
                ->count();
            //    dd($totalPatient);

            $patientData[] = ['date_month' => $date->format('M'), 'total_patient' => $totalPatient,];
        }
        $patientData = array_reverse($patientData);
        //    dd($patientData);

        return $patientData;
    }

    public function getDashboardPieChart()
    {
        Carbon::setLocale('vi');
        $now = Carbon::now();

        $priceData = [];

        for ($i = 0; $i < 3; $i++) {
            $date = $now->copy()->subMonths($i);
            $totalPrice = TreatmentDetail::join('treatment_services', 'treatment_services.treatment_id', '=', 'treatment_details.treatment_id')
                ->join('services', 'services.service_id', '=', 'treatment_services.service_id')
                ->whereMonth('treatment_details.created_at', $date->format('m'))
                ->sum('services.price');
            //            dd($totalPrice);

            $priceData[] = ['data_months' => $date->format('M'), 'total_price' => $totalPrice,];
        }
        $priceData = array_reverse($priceData);
        //            dd($priceData);

        return $priceData;
    }

    public function getDashboardLineChart()
    {
        Carbon::setLocale('vi');
        $now = Carbon::now();

        $transactionsMonthData = TreatmentDetail::join('treatment_services', 'treatment_services.treatment_id', '=', 'treatment_details.treatment_id')
            ->join('services', 'services.service_id', '=', 'treatment_services.service_id')
            ->select(
                DB::raw('DATE(treatment_details.created_at) as day'),
                DB::raw('SUM(services.price) as total_price')
            )
            ->whereMonth('treatment_details.created_at', $now->format('m'))
            ->whereYear('treatment_details.created_at', $now->format('Y'))
            ->groupBy(DB::raw('DATE(treatment_details.created_at)'))
            ->orderBy(DB::raw('DATE(treatment_details.created_at)'))
            ->get();
        //        dd($transactionsMonthData);

        return $transactionsMonthData;
    }

    public function getServiceTop()
    {
        $serviceTop = TreatmentDetail::join('services', 'services.service_id', '=', 'treatment_details.service_id')
            ->select('treatment_details.treatment_id', 'services.name', DB::raw('COUNT(treatment_details.service_id) as usage_count'))
            ->groupBy('treatment_details.treatment_id', 'services.name')
            ->orderBy('usage_count', 'desc')
            ->limit(6)
            ->get();

        foreach ($serviceTop as $item) {
            $item->percentage = ($item->usage_count / 100);
        }


        return $serviceTop;
    }

    public function getRecentTransactions()
    {
        $transactions = TreatmentDetail::join('services', 'services.service_id', '=', 'treatment_details.service_id')
            ->select('treatment_details.*', 'services.name', 'services.price')
            ->orderByDesc('treatment_details.treatment_id')
            ->limit(6)
            ->get();

        //        dd($transactions);

        return $transactions;
    }
}
