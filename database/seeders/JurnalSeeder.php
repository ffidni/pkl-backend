<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Jurnal;

class JurnalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i = 1; $i <= 10; $i++) {
            for ($j = 0; $j < 2; $j++) {
                Jurnal::create([
                    "users_id" => $i,
                    "date" => now(),
                    'title' => $faker->sentence(rand(2, 2), true),
                    "desc" => $faker->sentence(rand(2, 4), true),
                    "content" => $faker->paragraph(),
                    "created_at" => now(),
                    "updated_at" => now(),
                ]);
            }

        }
    }
}