<?php

namespace Database\Seeders;

use App\Models\Product;
use Faker\Factory as Faker;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, 50) as $index) {
            Product::create([
                'name' => $faker->word,
                'description' => $faker->sentence,
                'price' => $faker->randomFloat(2, 10, 500), // Price between 10 and 500
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

    }
}
