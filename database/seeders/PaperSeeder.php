<?php
namespace Database\Seeders;

use App\Models\Paper;
use Illuminate\Database\Seeder;

class PaperSeeder extends Seeder
{
    public function run(): void
    {
        Paper::create([
            'title' => 'Efficacy of Curcuma longa L. in Modulating Pro-inflammatory Cytokines',
            'authors' => 'Dr. S. Hartono, Prof. L. Wijaya, et al.',
            'abstract' => 'A randomized controlled trial demonstrating significant downregulation of TNF-a and IL-6...',
            'type' => 'Clinical Trial',
            'category' => 'Botany',
            'publication_year' => 2024,
            'journal_name' => 'Journal of Ethnopharmacology',
            'compounds' => ['Curcumin', 'Flavonoid', 'Turmerone'],
            'views' => 2400,
            'citations' => 142,
        ]);

        Paper::create([
            'title' => 'Neuroprotective Effects of Centella asiatica on Cognitive Models',
            'authors' => 'Prof. R. Santoso, Dr. M. Pratama',
            'abstract' => 'In vivo assessment of triterpenoid-enriched fractions showing improved spatial memory retention...',
            'type' => 'In Vitro',
            'category' => 'Pharmacology',
            'publication_year' => 2024,
            'journal_name' => 'Phytomedicine Journal',
            'compounds' => ['Asiaticoside', 'Madecassoside'],
            'views' => 1800,
            'citations' => 89,
        ]);
    }
}