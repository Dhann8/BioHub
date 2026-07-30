<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Taxonomy;
use Illuminate\Support\Str;

class TaxonomySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $classes = [
            'Aves',
            'Reptilia',
            'Amphibia',
            'Pisces',
            'Mamalia',
            'Burung',
            'Reptil',
            'Amfibi',
            'Serangga'
        ];

        foreach ($classes as $className) {
            Taxonomy::firstOrCreate(
                ['class_name' => $className],
                ['slug' => Str::slug($className)]
            );
        }
    }
}
