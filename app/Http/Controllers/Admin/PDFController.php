<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\MedicalRecord;
use App\Models\Medicine;
use App\Models\Service;
use App\Models\TreatmentDetail;
use App\Models\TreatmentMedication;
use Illuminate\Support\Facades\DB;
use App\Models\TreatmentService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PDFController extends Controller
{
    public function printService(Request $request, $treatment_id)
    {
       

        $services = Service::join('treatment_services', 'treatment_services.service_id', '=', 'services.service_id')
            ->join('treatment_details', 'treatment_details.treatment_id', '=', 'treatment_services.treatment_id')
            ->where('treatment_services.treatment_id', $treatment_id)
            ->get();

        $totalprice = TreatmentService::where('treatment_id', $treatment_id)
            ->join('services', 'treatment_services.service_id', '=', 'services.service_id')
            ->select(
                'treatment_services.treatment_id',
                DB::raw('COUNT(services.service_id) AS service_count'),
                DB::raw('SUM(services.price) AS total_price')
            )
            ->groupBy('treatment_services.treatment_id')
            ->get();

        $streatment = TreatmentDetail::where('treatment_id',$treatment_id)->get();
        $medical_id = $streatment[0]->medical_id;
        
        $medical = MedicalRecord::join('patients', 'patients.patient_id', '=', 'medical_records.patient_id')
        ->join('users', 'users.user_id', '=', 'medical_records.user_id')
        ->where('medical_id', $medical_id)
        ->get();

        $specialty = Book::where('book_id',$medical[0]->book_id)
        ->join('specialties', 'specialties.specialty_id', '=', 'books.specialty_id')
        ->select('specialties.name as name')
        ->get();
 
        $data = [
            'services' => $services,
            'totalprice' => $totalprice,
            'medical' => $medical,
            'specialty' => $specialty,
        ];

        //   dd($data['medical']);
        $pdf = Pdf::loadView('System.doctors.checkupHealth.pdfService', ['data' => $data]);
        $pdf->setPaper('A4', 'landscape');
        return $pdf->download('Dichvu.pdf');
    }

}
