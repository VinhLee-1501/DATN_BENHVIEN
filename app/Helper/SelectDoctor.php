<?php

namespace App\Helper;

use App\Models\Book;
use App\Models\User;

class SelectDoctor
{
    public static function selectDoctorName($id)
    {
        $excludedShiftIds = Book::select('shift_id')
            ->whereDate('day', now()->toDateString())
            ->groupBy('shift_id')
            ->havingRaw('COUNT(*) > 5')
            ->pluck('shift_id')
            ->toArray();

        $doctor = Book::join('schedules', 'schedules.shift_id', 'books.shift_id')
            ->join('users', 'users.user_id', 'schedules.user_id')
            ->where('books.book_id', $id)
            ->whereNotIn('books.shift_id', $excludedShiftIds)
            ->select('books.*', 'users.firstname', 'users.lastname', 'users.user_id')
            ->first();

        $html = '';

        if ($doctor) {
            $html .= "<option value='{$doctor->user_id}' selected>{$doctor->firstname} {$doctor->lastname}</option>";
        }

        $doctors = User::where('role', 2)->get();

        foreach ($doctors as $doc) {
            if (!$doctor || $doc->user_id != $doctor->user_id) {
                $html .= "<option value='{$doc->user_id}'>{$doc->firstname} {$doc->lastname}</option>";
            }
        }

        return $html;
    }
}
