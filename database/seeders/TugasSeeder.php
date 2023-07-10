<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Tugas;

class TugasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $prioritas = ["rendah", "menengah", "tinggi"];

        for ($i = 1; $i <= 10; $i++) {
            for ($j = 0; $j < 3; $j++) {
                Tugas::create([
                    "users_id" => $i,
                    'nama_tugas' => $faker->sentence(rand(2, 5), true),
                    'prioritas' => $prioritas[$faker->numberBetween(0, 1)],
                    "deadline" => "2023-07-01 00:00:00",
                    "created_at" => now(),
                    "updated_at" => now(),
                ]);
            }

        }

    }
}