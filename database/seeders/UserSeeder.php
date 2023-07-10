<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $tipe_user = ["admin", "user"];

        for ($i = 1; $i <= 10; $i++) {

            User::create([
                'nama_lengkap' => $faker->name,
                'email' => $faker->email,
                'nis' => str_pad($faker->randomNumber(6), 6, '0', STR_PAD_LEFT),
                'password' => $faker->password,
                'tipe_user' => $tipe_user[$faker->numberBetween(0, 1)],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}