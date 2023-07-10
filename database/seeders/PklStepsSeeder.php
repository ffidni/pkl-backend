<?php

namespace Database\Seeders;

use App\Models\PklStep;
use Illuminate\Database\Seeder;

class PklStepsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                1,
                "Seleksi",
                "2023-05-01,2023-05-15",
            ],
            [
                2,
                "Pembekalan",
                "2023-05-15,2023-06-02",
            ],
            [
                3,
                "Penempatan",
                "2023-07-01,2023-07-06",
            ],
            [
                4,
                "Pelaksanaan",
                "2023-07-26,2023-11-01",
            ],
            [
                5,
                "Bimbingan",
                "2023-07-05,2023-11-10",
            ],
            [
                6,
                "Monitoring",
                "2023-07-01,2023-09-01,2023-11-01",
            ],
            [
                7,
                "Sidang",
                "2023-11-01,2023-11-15",
            ],
        ];
        foreach ($data as $val) {
            PklStep::create([
                "order" => $val[0],
                "title" => $val[1],
                "dates" => $val[2],
                "created_at" => now(),
                "updated_at" => now(),
            ]);
        }
    }
}