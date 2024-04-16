<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $data = [];

        for ($i = 0; $i < 100; $i++) {
            $data[] = [
                'name' => $faker->words(2, true),
                'price' => $faker->randomFloat(2, 1000, 100000), // Adjust the range as needed
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        Product::insert($data);
    }
}
