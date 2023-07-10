<?php

namespace Database\Seeders;

use App\Models\TempatPklSuggestion;
use Illuminate\Database\Seeder;

class TempatPklSuggestions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ["Neosantara", -7.321052395701244, 108.2174651221713],
            ["Brave Animation", -7.332144548256583, 108.20162273538676],
            ["CV Utama Jaya",
            ],
            ["Rumah Kaos Indonesia", -7.3246330638617865, 108.2070341725031],
            ["Gamelab", -7.322381005862279, 110.50570734070492],
            ["Kominfo Kota Tasimalaya", -7.312071648091677, 108.1992952415688],
            ["Kominfo Kab Tasimalaya", -7.360820675712611, 108.11387863688567],
            ["Klik Media", -7.333419644737538, 108.21903149423986],
            ["Prilude", -7.275251037433763, 108.18902408530901],
            ["Preneur.co.id",
            ],
            ["Milenianews", -6.249017576894164, 106.8670446909647],
            ["Cikara Studio", -7.303537846328149, 108.19744861163542],
            ["Berdikari Abadi",
            ],
            ["Sahabat Properti Syariah", -7.3170220744485555, 108.2191203582378],
            ["Pemerintahan Kota Tasikmalaya", -7.307085815678084, 108.19534137601522],
            ["Universitas Siliwangi", -7.349931166968399, 108.22274605672396],
            ["Institut Nahdlatul Ulama", -7.3240881134340565, 108.2122808264866],
            ["Universitas Mayasari Bakti", -7.375714293207705, 108.23350339027907],
            ["Kelurahan Yudanegara", -7.330837081073013, 108.217118177527],
            ["MTS Nahdlatul Ulama Tasikmalaya", -7.324025960591911, 108.21227453039289],
            ["Kelurahan Nagarasari", -7.308736827262004, 108.21660464500154],
            ["DPRD Kota Tasikmalaya", -7.303094556700622, 108.20485677694454],
            ["Sekretariat Kwartir Cabang Gerakan Pramuka Kota Tasikmalaya",
            ],
            ["Dinas PPKBP3A", -7.372231933902994, 108.2140815868697],
            ["UMKM Oxa",
            ],
            ["Sae Corporation", -7.320121324767931, 108.23648485154241],
            ["Kantor Pos Kawalu", -7.3833594551713375, 108.20876384857615],
        ];
        foreach ($data as $tempat) {
            if (count($tempat) == 1) {
                TempatPklSuggestion::create(
                    ["nama_tempat" => $tempat[0]],
                );
            } else {
                TempatPklSuggestion::create(
                    ["nama_tempat" => $tempat[0], "latitude" => $tempat[1], "longitude" => $tempat[2]],
                );
            }

        }
    }
}