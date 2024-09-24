<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Support\Str;
class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('role', 2)->first();
        Schedule::create([
            'shift_id' => strtoupper(Str::random(10)),
            'note' => 'ngày 2',
            'status' => '1',
            'time' => ' 2024-10-05 09:00:00',
            'user_id' => $user->user_id
        ]);
    }
}