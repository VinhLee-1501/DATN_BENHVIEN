<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

class OrdersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('orders')->insert([
        //     'row_id' => 1,
        //     'order_id' => '1F4X8IG0C1',
        //     'total_price' => 165,
        //     'status' => 0, // 0 = Chưa thanh toán
        //     'payment' => 0,
        //     'cashier' => null,
        //     'cash_received' => null,
        //     'change_amount' => null,
        //     'total_amount' => null,
        //     'treatment_id' => 'TREATMENT1',
        //     'deleted_at' => null,
        //     'created_at' => Carbon::create(2024, 11, 8, 16, 26, 45),
        //     'updated_at' => Carbon::create(2024, 11, 11, 12, 17, 37),
        // ]);
    }
}
