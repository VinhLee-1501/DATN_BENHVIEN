<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\MedicalRecord;
use App\Models\Medicine;
use App\Models\Patient;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use App\Repositories\User\UserInterface;
use Illuminate\Support\Facades\Auth;

class CheckupHealthController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $user_id = $user->user_id;
        // dd($user_id);
        $book = Book::join('schedules', 'schedules.shift_id', '=', 'books.shift_id')
            ->join('users', 'users.user_id', '=', 'schedules.user_id')
            ->where('users.user_id', $user_id)
            ->select(
                'books.status as status',
                'books.name as name',
                'books.phone as phone',
                'books.day as day',
                'books.symptoms as symptoms',
                'books.book_id as book_id',
            )
            ->get();
        // dd($book);
        return view('System.doctors.checkupHealth.index', compact('book'));
    }

    public function create($book_id)
    {
        // dd($book_id);
        $book = Book::where('book_id', $book_id)->get();


        $phone = $book[0]->phone;
        $patient = Patient::where('phone', $phone)->first();
        if (!$patient) {
            $user = $book->first();
        } else {

            $patient_id = $patient->patient_id;
            $medicalRecord = Book::join('medical_records','medical_records.book_id', 'books.book_id')
            ->join('patients', 'patients.patient_id', '=', 'medical_records.patient_id')
            ->select('medical_records.*', 'patients.first_name', 'patients.last_name', 'patients.gender')
            ->where('medical_records.patient_id', $patient_id)
            ->groupBy('medical_records.medical_id', 'patients.patient_id', 'patients.first_name', 'patients.last_name', 'patients.gender')
            ->get();

            // dd($patient_id);
            $user = [
                'medicalRecord' => $medicalRecord,
                'patient' => $patient,
                'book' => $book->first()
            ];
        }

        // dd($user);

        $service = Service::get();
        $medicine = Medicine::get();

        return view(
            'System.doctors.checkupHealth.checkupHealth',
            [
                'book' => $book,
                'patient' => $patient,
                'user' => $user,
                
                'service' => $service,
                'medicine' => $medicine,
            ]

        );
    }
}