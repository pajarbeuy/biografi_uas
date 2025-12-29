<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MathematicsBranchesSeeder extends Seeder
{
    /**
     * Run the database seeder for 7 main branches of mathematics.
     */
    public function run(): void
    {
        $branches = [
            [
                'name' => 'Aljabar',
                'description' => 'Cabang matematika yang mempelajari struktur, hubungan, dan kuantitas abstrak menggunakan simbol dan aturan untuk memanipulasi simbol-simbol tersebut.',
            ],
            [
                'name' => 'Geometri',
                'description' => 'Cabang matematika yang mempelajari sifat-sifat ruang, bentuk, ukuran, dan posisi relatif figur.',
            ],
            [
                'name' => 'Kalkulus',
                'description' => 'Cabang matematika yang mempelajari perubahan kontinu, meliputi diferensial dan integral.',
            ],
            [
                'name' => 'Statistika',
                'description' => 'Cabang matematika yang berhubungan dengan pengumpulan, analisis, interpretasi, presentasi, dan organisasi data.',
            ],
            [
                'name' => 'Teori Bilangan',
                'description' => 'Cabang matematika yang mempelajari sifat-sifat bilangan bulat dan bilangan-bilangan terkait.',
            ],
            [
                'name' => 'Analisis',
                'description' => 'Cabang matematika yang mempelajari limit, kontinuitas, diferensiasi, integrasi, dan deret tak hingga.',
            ],
            [
                'name' => 'Matematika Diskrit',
                'description' => 'Cabang matematika yang mempelajari struktur matematika yang pada dasarnya diskrit (tidak kontinu), seperti graf, logika, dan kombinatorika.',
            ],
        ];

        foreach ($branches as $branch) {
            Category::firstOrCreate(
                ['name' => $branch['name']],
                $branch
            );
        }
    }
}
