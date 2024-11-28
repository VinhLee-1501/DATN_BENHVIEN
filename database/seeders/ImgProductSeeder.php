<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB as FacadesDB;

class ImgProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FacadesDB::table('img_products')->insert([
            ['img' => '1.webp', 'product_id' => 1, 'created_at' => now(), 'updated_at' => now()],

            ['img' => '2.webp', 'product_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['img' => '2.1.webp', 'product_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['img' => '2.2.webp', 'product_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['img' => '2.3.webp', 'product_id' => 2, 'created_at' => now(), 'updated_at' => now()],

            ['img' => '3.webp', 'product_id' => 3, 'created_at' => now(), 'updated_at' => now()],

            ['img' => '4.jpg', 'product_id' => 4, 'created_at' => now(), 'updated_at' => now()],

            ['img' => '5.jpg', 'product_id' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['img' => '5.1.jpg', 'product_id' => 5, 'created_at' => now(), 'updated_at' => now()],

            ['img' => '6.webp', 'product_id' => 6, 'created_at' => now(), 'updated_at' => now()],
            ['img' => '6.1.webp', 'product_id' => 6, 'created_at' => now(), 'updated_at' => now()],
            ['img' => '6.2.webp', 'product_id' => 6, 'created_at' => now(), 'updated_at' => now()],
            ['img' => '6.3.webp', 'product_id' => 6, 'created_at' => now(), 'updated_at' => now()],

            ['img' => '7.webp', 'product_id' => 7, 'created_at' => now(), 'updated_at' => now()],
            ['img' => '7.1.jpg', 'product_id' => 7, 'created_at' => now(), 'updated_at' => now()],
            ['img' => '7.2.jpg', 'product_id' => 7, 'created_at' => now(), 'updated_at' => now()],

            ['img' => '8.webp', 'product_id' => 8, 'created_at' => now(), 'updated_at' => now()],
            ['img' => '8.1.webp', 'product_id' => 8, 'created_at' => now(), 'updated_at' => now()],
            ['img' => '8.2.webp', 'product_id' => 8, 'created_at' => now(), 'updated_at' => now()],

            ['img' => '9.webp', 'product_id' => 9, 'created_at' => now(), 'updated_at' => now()],
            ['img' => '9.1.jpg', 'product_id' => 9, 'created_at' => now(), 'updated_at' => now()],
            ['img' => '9.2.jpg', 'product_id' => 9, 'created_at' => now(), 'updated_at' => now()],
            ['img' => '9.3.jpg', 'product_id' => 9, 'created_at' => now(), 'updated_at' => now()],

            ['img' => '10.webp', 'product_id' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['img' => '10.1.jpg', 'product_id' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['img' => '10.2.jpg', 'product_id' => 10, 'created_at' => now(), 'updated_at' => now()],

            ['img' => '11.jpg', 'product_id' => 11, 'created_at' => now(), 'updated_at' => now()],

            ['img' => '12.webp', 'product_id' => 12, 'created_at' => now(), 'updated_at' => now()],
            ['img' => '12.1.webp', 'product_id' => 12, 'created_at' => now(), 'updated_at' => now()],
            ['img' => '12.2.webp', 'product_id' => 12, 'created_at' => now(), 'updated_at' => now()],
            ['img' => '12.3.webp', 'product_id' => 12, 'created_at' => now(), 'updated_at' => now()],
            ['img' => '13.jpg', 'product_id' => 13, 'created_at' => now(), 'updated_at' => now()],

            ['img' => '14.jpg', 'product_id' => 14, 'created_at' => now(), 'updated_at' => now()],
            ['img' => '14.1.jpg', 'product_id' => 14, 'created_at' => now(), 'updated_at' => now()],

            ['img' => '15.jpg', 'product_id' => 15, 'created_at' => now(), 'updated_at' => now()],
            ['img' => '15.1.jpg', 'product_id' => 15, 'created_at' => now(), 'updated_at' => now()],
            ['img' => '15.2.jpg', 'product_id' => 15, 'created_at' => now(), 'updated_at' => now()],
            ['img' => '15.3.jpg', 'product_id' => 15, 'created_at' => now(), 'updated_at' => now()],
            ['img' => '15.4.jpg', 'product_id' => 15, 'created_at' => now(), 'updated_at' => now()],


            ['img' => '16.jpg', 'product_id' => 16, 'created_at' => now(), 'updated_at' => now()],
            ['img' => '16.1.jpg', 'product_id' => 16, 'created_at' => now(), 'updated_at' => now()],
            ['img' => '16.2.jpg', 'product_id' => 16, 'created_at' => now(), 'updated_at' => now()],
            ['img' => '16.3.jpg', 'product_id' => 16, 'created_at' => now(), 'updated_at' => now()],
            ['img' => '16.4.webp', 'product_id' => 16, 'created_at' => now(), 'updated_at' => now()],

            ['img' => '17.webp', 'product_id' => 17, 'created_at' => now(), 'updated_at' => now()],
            ['img' => '17.1.webp', 'product_id' => 17, 'created_at' => now(), 'updated_at' => now()],
            ['img' => '17.2.webp', 'product_id' => 17, 'created_at' => now(), 'updated_at' => now()],
            ['img' => '17.3.webp', 'product_id' => 17, 'created_at' => now(), 'updated_at' => now()],

            ['img' => '18.jpg', 'product_id' => 18, 'created_at' => now(), 'updated_at' => now()],
            ['img' => '18.1.jpg', 'product_id' => 18, 'created_at' => now(), 'updated_at' => now()],
            ['img' => '18.2.jpg', 'product_id' => 18, 'created_at' => now(), 'updated_at' => now()],
            ['img' => '18.3.jpg', 'product_id' => 18, 'created_at' => now(), 'updated_at' => now()],
            ['img' => '18.4.jpg', 'product_id' => 18, 'created_at' => now(), 'updated_at' => now()],

            ['img' => '19.webp', 'product_id' => 19, 'created_at' => now(), 'updated_at' => now()],

            ['img' => '20.jpg', 'product_id' => 20, 'created_at' => now(), 'updated_at' => now()],

            ['img' => '21.jpg', 'product_id' => 21, 'created_at' => now(), 'updated_at' => now()],
            ['img' => '21.1.jpg', 'product_id' => 21, 'created_at' => now(), 'updated_at' => now()],
            ['img' => '21.2.jpg', 'product_id' => 21, 'created_at' => now(), 'updated_at' => now()],
            ['img' => '21.3.jpg', 'product_id' => 21, 'created_at' => now(), 'updated_at' => now()],

            ['img' => '22.jpg', 'product_id' => 22, 'created_at' => now(), 'updated_at' => now()],

            ['img' => '23.jpg', 'product_id' => 23, 'created_at' => now(), 'updated_at' => now()],
            ['img' => '23.1.jpg', 'product_id' => 23, 'created_at' => now(), 'updated_at' => now()],
            ['img' => '23.2.jpg', 'product_id' => 23, 'created_at' => now(), 'updated_at' => now()],

            ['img' => '24.jpg', 'product_id' => 24, 'created_at' => now(), 'updated_at' => now()],
            ['img' => '24.1.jpg', 'product_id' => 24, 'created_at' => now(), 'updated_at' => now()],
            ['img' => '24.2.jpg', 'product_id' => 24, 'created_at' => now(), 'updated_at' => now()],

            ['img' => '25.jpg', 'product_id' => 25, 'created_at' => now(), 'updated_at' => now()],
            ['img' => '25.1.jpg', 'product_id' => 25, 'created_at' => now(), 'updated_at' => now()],

            ['img' => '26.jpg', 'product_id' => 26, 'created_at' => now(), 'updated_at' => now()],
            ['img' => '26.1.jpg', 'product_id' => 26, 'created_at' => now(), 'updated_at' => now()],
            ['img' => '26.2.webp', 'product_id' => 26, 'created_at' => now(), 'updated_at' => now()],
            ['img' => '26.3.webp', 'product_id' => 26, 'created_at' => now(), 'updated_at' => now()],
            ['img' => '26.4.webp', 'product_id' => 26, 'created_at' => now(), 'updated_at' => now()],

            ['img' => '27.webp', 'product_id' => 27, 'created_at' => now(), 'updated_at' => now()],
            ['img' => '27.1.webp', 'product_id' => 27, 'created_at' => now(), 'updated_at' => now()],
            ['img' => '27.2.webp', 'product_id' => 27, 'created_at' => now(), 'updated_at' => now()],
            ['img' => '27.3.webp', 'product_id' => 27, 'created_at' => now(), 'updated_at' => now()],
            ['img' => '27.4.webp', 'product_id' => 27, 'created_at' => now(), 'updated_at' => now()],

            ['img' => '28.jpg', 'product_id' => 28, 'created_at' => now(), 'updated_at' => now()],

            ['img' => '29.webp', 'product_id' => 29, 'created_at' => now(), 'updated_at' => now()],

            ['img' => '30.webp', 'product_id' => 30, 'created_at' => now(), 'updated_at' => now()],
            ['img' => '30.1.webp', 'product_id' => 30, 'created_at' => now(), 'updated_at' => now()],
            ['img' => '30.2.webp', 'product_id' => 30, 'created_at' => now(), 'updated_at' => now()],
            ['img' => '30.3.webp', 'product_id' => 30, 'created_at' => now(), 'updated_at' => now()],


            ['img' => '31.jpg', 'product_id' => 31, 'created_at' => now(), 'updated_at' => now()],
            ['img' => '31.1.jpg', 'product_id' => 31, 'created_at' => now(), 'updated_at' => now()],
            ['img' => '31.2.jpg', 'product_id' => 31, 'created_at' => now(), 'updated_at' => now()],
            ['img' => '31.3.jpg', 'product_id' => 31, 'created_at' => now(), 'updated_at' => now()],

            ['img' => '32.jpg', 'product_id' => 32, 'created_at' => now(), 'updated_at' => now()],
            ['img' => '32.1.jpg', 'product_id' => 32, 'created_at' => now(), 'updated_at' => now()],
            ['img' => '32.2.jpg', 'product_id' => 32, 'created_at' => now(), 'updated_at' => now()],

            ['img' => '33.jpg', 'product_id' => 33, 'created_at' => now(), 'updated_at' => now()],

            ['img' => '34.webp', 'product_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['img' => '34.1.jpg', 'product_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['img' => '34.2.jpg', 'product_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['img' => '34.3.jpg', 'product_id' => 34, 'created_at' => now(), 'updated_at' => now()],

            ['img' => '35.jpg', 'product_id' => 35, 'created_at' => now(), 'updated_at' => now()],
            ['img' => '35.1.jpg', 'product_id' => 35, 'created_at' => now(), 'updated_at' => now()],

            // ['img' => '36.jpg', 'product_id' => 36, 'created_at' => now(), 'updated_at' => now()],
            // ['img' => '36.1.jpg', 'product_id' => 36, 'created_at' => now(), 'updated_at' => now()],
            // ['img' => '36.2.jpg', 'product_id' => 36, 'created_at' => now(), 'updated_at' => now()],
            // ['img' => '36.3.jpg', 'product_id' => 36, 'created_at' => now(), 'updated_at' => now()],
            ['img' => '37.jpg', 'product_id' => 37, 'created_at' => now(), 'updated_at' => now()],

            ['img' => '38.webp', 'product_id' => 38, 'created_at' => now(), 'updated_at' => now()],
            ['img' => '38.1.webp', 'product_id' => 38, 'created_at' => now(), 'updated_at' => now()],
            ['img' => '38.4.webp', 'product_id' => 38, 'created_at' => now(), 'updated_at' => now()],
            ['img' => '38.2.webp', 'product_id' => 38, 'created_at' => now(), 'updated_at' => now()],
            ['img' => '38.3.webp', 'product_id' => 38, 'created_at' => now(), 'updated_at' => now()],

            ['img' => '39.webp', 'product_id' => 39, 'created_at' => now(), 'updated_at' => now()],

            ['img' => '40.jpg', 'product_id' => 40, 'created_at' => now(), 'updated_at' => now()],

            ['img' => '41.jpg', 'product_id' => 41, 'created_at' => now(), 'updated_at' => now()],
            ['img' => '41.1.jpg', 'product_id' => 41, 'created_at' => now(), 'updated_at' => now()],
            ['img' => '41.2.jpg', 'product_id' => 41, 'created_at' => now(), 'updated_at' => now()],
            ['img' => '41.3.jpg', 'product_id' => 41, 'created_at' => now(), 'updated_at' => now()],
            ['img' => '41.4.jpg', 'product_id' => 41, 'created_at' => now(), 'updated_at' => now()],

            ['img' => '42.webp', 'product_id' => 42, 'created_at' => now(), 'updated_at' => now()],
           
            ['img' => '43.jpg', 'product_id' => 43, 'created_at' => now(), 'updated_at' => now()],
            
            ['img' => '44.jpg', 'product_id' => 44, 'created_at' => now(), 'updated_at' => now()],
            
            ['img' => '45.jpg', 'product_id' => 45, 'created_at' => now(), 'updated_at' => now()],
            ['img' => '45.1.jpg', 'product_id' => 45, 'created_at' => now(), 'updated_at' => now()],
            ['img' => '45.2.jpg', 'product_id' => 45, 'created_at' => now(), 'updated_at' => now()],

            ['img' => '46.jpg', 'product_id' => 46, 'created_at' => now(), 'updated_at' => now()],
          
            ['img' => '47.jpg', 'product_id' => 47, 'created_at' => now(), 'updated_at' => now()],
         
            ['img' => '48.jpg', 'product_id' => 48, 'created_at' => now(), 'updated_at' => now()],
           
            ['img' => '49.jpg', 'product_id' => 49, 'created_at' => now(), 'updated_at' => now()],
            ['img' => '49.1.jpg', 'product_id' => 49, 'created_at' => now(), 'updated_at' => now()],
            ['img' => '49.2.jpg', 'product_id' => 49, 'created_at' => now(), 'updated_at' => now()],
            ['img' => '49.3.jpg', 'product_id' => 49, 'created_at' => now(), 'updated_at' => now()],

            ['img' => '50.jpg', 'product_id' => 50, 'created_at' => now(), 'updated_at' => now()],
           
            ['img' => '51.jpg', 'product_id' => 51, 'created_at' => now(), 'updated_at' => now()],
            ['img' => '51.1.jpg', 'product_id' => 51, 'created_at' => now(), 'updated_at' => now()],
            ['img' => '51.2.jpg', 'product_id' => 51, 'created_at' => now(), 'updated_at' => now()],

            ['img' => '52.jpg', 'product_id' => 52, 'created_at' => now(), 'updated_at' => now()],
          
            ['img' => '53.jpg', 'product_id' => 53, 'created_at' => now(), 'updated_at' => now()],
          


        ]);


    }
}
