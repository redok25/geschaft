<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CustomerSeeder extends Seeder
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
                'name' => $faker->name,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        Customer::insert($data);
    }
}
