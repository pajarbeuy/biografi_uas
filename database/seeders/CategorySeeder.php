<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'name' => 'Pahlawan Nasional',
                'slug' => 'pahlawan-nasional',
                'description' => 'Tokoh-tokoh yang berjasa dalam kemerdekaan Indonesia'
            ],
            [
                'name' => 'Ilmuwan',
                'slug' => 'ilmuwan',
                'description' => 'Para ilmuwan dan peneliti terkenal'
            ],
            [
                'name' => 'Sastrawan',
                'slug' => 'sastrawan',
                'description' => 'Penulis dan sastrawan berbakat'
            ],
            [
                'name' => 'Seni & Budaya',
                'slug' => 'seni-budaya',
                'description' => 'Seniman dan tokoh budaya'
            ],
            [
                'name' => 'Olahraga',
                'slug' => 'olahraga',
                'description' => 'Atlet dan tokoh olahraga'
            ],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}
