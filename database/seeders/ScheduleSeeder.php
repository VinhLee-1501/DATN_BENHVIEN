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
            'day' => ' 2024-09-28',
            'user_id' => $user->user_id
        ]);

        Schedule::create([
            'shift_id' => strtoupper(Str::random(10)),
            'note' => 'ngày 2',
            'status' => '1',
            'day' => ' 2024-09-27',
            'user_id' => $user->user_id
        ]);

        Schedule::create([
            'shift_id' => strtoupper(Str::random(10)),
            'note' => 'ngày 2',
            'status' => '1',
            'day' => ' 2024-09-27',
            'user_id' => $user->user_id
        ]);
    }
}