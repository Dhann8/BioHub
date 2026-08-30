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

        $additionalPapers = [
            ['title' => 'Antioxidant Activity of Syzygium polyanthum Leaf Extract', 'authors' => 'A. Nugroho, R. Lestari, M. Yusuf', 'abstract' => 'Penelitian laboratorium mengenai aktivitas antioksidan ekstrak daun salam pada beberapa konsentrasi.', 'type' => 'In Vitro', 'category' => 'Pharmacology', 'publication_year' => 2023, 'journal_name' => 'Indonesian Journal of Natural Products', 'compounds' => ['Flavonoid', 'Tannin'], 'views' => 1650, 'citations' => 76],
            ['title' => 'Ethnobotanical Knowledge of Medicinal Plants in West Java', 'authors' => 'D. Permata, S. Hidayat, F. Rahman', 'abstract' => 'Pemetaan pengetahuan masyarakat mengenai pemanfaatan tanaman obat di wilayah Jawa Barat.', 'type' => 'Review', 'category' => 'Ethnobotany', 'publication_year' => 2022, 'journal_name' => 'Journal of Indonesian Ethnobotany', 'compounds' => ['Alkaloid', 'Terpenoid'], 'views' => 2100, 'citations' => 115],
            ['title' => 'Clinical Evaluation of Zingiber officinale for Nausea Relief', 'authors' => 'L. Wijaya, T. Sari, B. Santoso', 'abstract' => 'Uji klinis terkontrol mengenai penggunaan jahe untuk membantu mengurangi keluhan mual ringan.', 'type' => 'Clinical Trial', 'category' => 'Clinical Research', 'publication_year' => 2024, 'journal_name' => 'Nusantara Clinical Herbal Journal', 'compounds' => ['Gingerol', 'Shogaol'], 'views' => 3200, 'citations' => 134],
            ['title' => 'Habitat Connectivity for Panthera tigris sumatrae', 'authors' => 'H. Prakoso, N. Amelia, Y. Kurniawan', 'abstract' => 'Analisis koridor habitat untuk mendukung pergerakan dan konservasi harimau Sumatera.', 'type' => 'Review', 'category' => 'Conservation', 'publication_year' => 2021, 'journal_name' => 'Biodiversity Conservation Review', 'compounds' => [], 'views' => 2750, 'citations' => 158],
            ['title' => 'Curcumin and Inflammatory Biomarkers: A Systematic Review', 'authors' => 'R. Maharani, E. Putra, A. Fadillah', 'abstract' => 'Tinjauan sistematis terhadap hubungan kurkumin dan perubahan biomarker inflamasi.', 'type' => 'Review', 'category' => 'Pharmacology', 'publication_year' => 2023, 'journal_name' => 'Southeast Asian Pharmacology', 'compounds' => ['Curcumin', 'Demethoxycurcumin'], 'views' => 4100, 'citations' => 201],
            ['title' => 'In Vitro Antimicrobial Potential of Piper betle', 'authors' => 'M. Ardiansyah, P. Wulandari', 'abstract' => 'Evaluasi awal potensi antimikroba ekstrak daun sirih terhadap mikroorganisme uji.', 'type' => 'In Vitro', 'category' => 'Botany', 'publication_year' => 2022, 'journal_name' => 'Tropical Plant Science', 'compounds' => ['Eugenol', 'Chavicol'], 'views' => 1320, 'citations' => 61],
            ['title' => 'Population Monitoring of Varanus komodoensis Using Camera Traps', 'authors' => 'I. Setiawan, K. Laksana, R. Dewi', 'abstract' => 'Pemantauan populasi Komodo menggunakan kamera jebak dan analisis okupansi habitat.', 'type' => 'Field Study', 'category' => 'Conservation', 'publication_year' => 2025, 'journal_name' => 'Indonesian Wildlife Research', 'compounds' => [], 'views' => 1890, 'citations' => 94],
            ['title' => 'Phytochemical Profile of Aloe vera Gel from Local Cultivars', 'authors' => 'C. Larasati, W. Hartono', 'abstract' => 'Karakterisasi fitokimia gel lidah buaya dari beberapa varietas budidaya lokal.', 'type' => 'In Vitro', 'category' => 'Botany', 'publication_year' => 2020, 'journal_name' => 'Journal of Herbal Technology', 'compounds' => ['Aloin', 'Acemannan'], 'views' => 980, 'citations' => 43],
            ['title' => 'Community-Based Conservation of Leucopsar rothschildi', 'authors' => 'A. Kusuma, G. Wibowo, S. Anjani', 'abstract' => 'Evaluasi program konservasi berbasis masyarakat untuk mendukung pelepasliaran Jalak Bali.', 'type' => 'Field Study', 'category' => 'Conservation', 'publication_year' => 2024, 'journal_name' => 'Asian Avian Conservation', 'compounds' => [], 'views' => 2280, 'citations' => 87],
            ['title' => 'Safety Review of Traditional Jamu Preparations in Indonesia', 'authors' => 'F. Maulana, D. Kartika, R. Pertiwi', 'abstract' => 'Tinjauan keamanan bahan dan praktik pengolahan jamu yang umum digunakan masyarakat Indonesia.', 'type' => 'Review', 'category' => 'Public Health', 'publication_year' => 2025, 'journal_name' => 'Public Health and Herbal Medicine', 'compounds' => ['Polyphenol', 'Saponin'], 'views' => 3540, 'citations' => 129],
        ];

        foreach ($additionalPapers as $paper) {
            Paper::updateOrCreate(['title' => $paper['title']], $paper);
        }
    }
}
