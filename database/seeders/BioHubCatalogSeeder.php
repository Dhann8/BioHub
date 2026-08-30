<?php

namespace Database\Seeders;

use App\Models\Fauna;
use App\Models\FaunaConservationProgram;
use App\Models\FaunaEcologicalInfo;
use App\Models\FaunaGallery;
use App\Models\FaunaLocation;
use App\Models\FaunaPhysicalCharacteristic;
use App\Models\FaunaThreat;
use App\Models\Herbal;
use App\Models\HerbalActiveCompound;
use App\Models\HerbalGallery;
use App\Models\HerbalInteraction;
use App\Models\Symptom;
use App\Models\Taxonomy;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BioHubCatalogSeeder extends Seeder
{
    public function run(): void
    {
        $taxonomies = $this->seedTaxonomies();
        $this->seedFaunas($taxonomies);
        $this->seedHerbals();
    }

    private function seedTaxonomies(): array
    {
        $definitions = [
            ['class_name' => 'Mamalia', 'kingdom' => 'Animalia', 'phylum' => 'Chordata', 'order' => 'Carnivora', 'family' => 'Felidae'],
            ['class_name' => 'Aves', 'kingdom' => 'Animalia', 'phylum' => 'Chordata', 'order' => 'Accipitriformes', 'family' => 'Accipitridae'],
            ['class_name' => 'Reptilia', 'kingdom' => 'Animalia', 'phylum' => 'Chordata', 'order' => 'Testudines', 'family' => 'Cheloniidae'],
        ];

        $taxonomies = [];
        foreach ($definitions as $definition) {
            $taxonomies[$definition['class_name']] = Taxonomy::updateOrCreate(
                ['slug' => Str::slug($definition['class_name'])],
                $definition
            );
        }

        return $taxonomies;
    }

    private function seedFaunas(array $taxonomies): void
    {
        $faunas = [
            [
                'taxonomy' => 'Mamalia', 'local_name' => 'Harimau Sumatera', 'scientific_name' => 'Panthera tigris sumatrae',
                'iucn_status' => 'CR', 'size' => 'Besar', 'physical_features' => ['Bermotif loreng', 'Bintik/Garis', 'Nokturnal'],
                'primary_habitat' => 'Hutan hujan Sumatera', 'description' => 'Subspesies harimau yang hanya ditemukan di Pulau Sumatera dan berperan penting menjaga keseimbangan ekosistem.',
                'image_url' => 'https://images.unsplash.com/photo-1561731216-c3a4d99437d5?auto=format&fit=crop&w=1200&q=80',
                'lifespan' => '15-20 Tahun', 'offspring_count' => '2-4 Anak', 'gestation_period' => '93-112 Hari', 'social_pattern' => 'Soliter',
                'iucn_code' => 'CR', 'iucn_description' => 'Menghadapi tekanan tinggi akibat kehilangan habitat dan perburuan ilegal.',
                'legal_status' => 'Dilindungi berdasarkan peraturan konservasi Indonesia.', 'population_trend' => 'Menurun',
                'location' => ['region_name' => 'Taman Nasional Gunung Leuser', 'latitude' => 3.5500, 'longitude' => 97.3500],
                'physical' => ['size_and_weight' => 'Jantan 100-140 kg; betina 75-110 kg.', 'distinctive_features' => 'Ukuran tubuh lebih kecil dan janggut lebih panjang dibandingkan subspesies lainnya.'],
                'ecology' => ['habitat_description' => 'Hutan dataran rendah, rawa gambut, dan hutan pegunungan.', 'diet_and_behavior' => 'Memangsa rusa, babi hutan, dan satwa berukuran sedang; aktif berburu saat senja dan malam.', 'quote' => 'Penjaga keseimbangan hutan Sumatera.'],
                'threats' => [['title' => 'Kehilangan Habitat', 'description' => 'Alih fungsi hutan memecah wilayah jelajah dan mengurangi ketersediaan mangsa.'], ['title' => 'Perburuan Ilegal', 'description' => 'Perdagangan bagian tubuh menjadi ancaman langsung bagi populasinya.']],
                'programs' => ['Patroli anti-perburuan dan pemantauan koridor satwa bersama masyarakat sekitar kawasan konservasi.'],
            ],
            [
                'taxonomy' => 'Aves', 'local_name' => 'Elang Jawa', 'scientific_name' => 'Nisaetus bartelsi', 'iucn_status' => 'EN', 'size' => 'Besar',
                'physical_features' => ['Jambul tegak', 'Sayap', 'Penglihatan tajam'], 'primary_habitat' => 'Hutan pegunungan Jawa',
                'description' => 'Burung pemangsa endemik Pulau Jawa yang menjadi salah satu ikon satwa nasional Indonesia.',
                'image_url' => 'https://images.unsplash.com/photo-1611689342806-0863700ce1e4?auto=format&fit=crop&w=1200&q=80',
                'lifespan' => '15 Tahun', 'offspring_count' => '1 Telur', 'gestation_period' => '47-48 Hari', 'social_pattern' => 'Berpasangan', 'iucn_code' => 'EN',
                'iucn_description' => 'Populasinya terfragmentasi dan terus tertekan oleh kerusakan hutan.', 'legal_status' => 'Dilindungi di seluruh wilayah Indonesia.', 'population_trend' => 'Menurun',
                'location' => ['region_name' => 'Taman Nasional Gunung Halimun Salak', 'latitude' => -6.7500, 'longitude' => 106.5500],
                'physical' => ['size_and_weight' => 'Panjang tubuh sekitar 60 cm; berat 1,2-1,5 kg.', 'distinctive_features' => 'Jambul panjang berwarna cokelat gelap dengan dada bergaris.'],
                'ecology' => ['habitat_description' => 'Kanopi hutan primer dan sekunder pada daerah berbukit hingga pegunungan.', 'diet_and_behavior' => 'Memangsa burung, mamalia kecil, dan reptil dari tempat bertengger.', 'quote' => 'Simbol kesehatan hutan pegunungan Jawa.'],
                'threats' => [['title' => 'Deforestasi', 'description' => 'Pembukaan hutan menghilangkan pohon sarang dan wilayah berburu.']],
                'programs' => ['Konservasi habitat dan pelepasliaran hasil rehabilitasi dengan pemantauan populasi.'],
            ],
            [
                'taxonomy' => 'Reptilia', 'local_name' => 'Penyu Hijau', 'scientific_name' => 'Chelonia mydas', 'iucn_status' => 'EN', 'size' => 'Besar',
                'physical_features' => ['Sisik/Cangkang', 'Sirip depan panjang', 'Herbivor dewasa'], 'primary_habitat' => 'Laut tropis dan pesisir',
                'description' => 'Penyu laut yang bermigrasi jauh dan menggunakan pantai berpasir Indonesia untuk bertelur.',
                'image_url' => 'https://images.unsplash.com/photo-1518467166778-b88f373ffec7?auto=format&fit=crop&w=1200&q=80',
                'lifespan' => '60-70 Tahun', 'offspring_count' => '100-200 Telur', 'gestation_period' => '45-70 Hari', 'social_pattern' => 'Migrasi', 'iucn_code' => 'EN',
                'iucn_description' => 'Menghadapi ancaman tangkapan sampingan, sampah laut, dan kerusakan pantai peneluran.', 'legal_status' => 'Dilindungi berdasarkan regulasi konservasi satwa laut.', 'population_trend' => 'Menurun',
                'location' => ['region_name' => 'Taman Nasional Meru Betiri', 'latitude' => -8.5000, 'longitude' => 113.7000],
                'physical' => ['size_and_weight' => 'Panjang karapas 80-120 cm; berat dapat mencapai 180 kg.', 'distinctive_features' => 'Karapas berwarna hijau zaitun hingga cokelat dengan kepala kecil.'],
                'ecology' => ['habitat_description' => 'Padang lamun, terumbu karang, dan pantai berpasir untuk bertelur.', 'diet_and_behavior' => 'Dewasa memakan lamun dan alga; bermigrasi antara lokasi makan dan peneluran.', 'quote' => 'Penghubung ekosistem laut dan pesisir.'],
                'threats' => [['title' => 'Sampah Laut', 'description' => 'Plastik dapat tertelan atau menjerat penyu di laut.'], ['title' => 'Perdagangan Telur', 'description' => 'Pengambilan telur mengurangi keberhasilan regenerasi populasi.']],
                'programs' => ['Perlindungan pantai peneluran, relokasi sarang rentan, dan edukasi masyarakat pesisir.'],
            ],
            [
                'taxonomy' => 'Mamalia', 'local_name' => 'Orangutan Kalimantan', 'scientific_name' => 'Pongo pygmaeus', 'iucn_status' => 'CR', 'size' => 'Besar',
                'physical_features' => ['Rambut kemerahan', 'Lengan panjang', 'Ekor Panjang'], 'primary_habitat' => 'Hutan hujan Kalimantan',
                'description' => 'Kera besar arboreal yang menghabiskan sebagian besar hidupnya di kanopi hutan Kalimantan.',
                'image_url' => 'https://images.unsplash.com/photo-1540573133985-87b6da6d54a9?auto=format&fit=crop&w=1200&q=80',
                'location' => ['region_name' => 'Taman Nasional Tanjung Puting', 'latitude' => -2.7500, 'longitude' => 111.7500],
                'physical' => ['size_and_weight' => 'Jantan dewasa dapat mencapai 90 kg.', 'distinctive_features' => 'Rambut panjang berwarna jingga dan lengan yang sangat panjang.'],
                'ecology' => ['habitat_description' => 'Hutan rawa gambut dan hutan dataran rendah.', 'diet_and_behavior' => 'Memakan buah, daun, kulit kayu, dan serangga; membuat sarang baru setiap malam.', 'quote' => 'Penjaga regenerasi hutan Kalimantan.'],
                'threats' => [['title' => 'Kehilangan Habitat', 'description' => 'Kebakaran dan alih fungsi hutan mengurangi kanopi tempat hidupnya.']],
                'programs' => ['Rehabilitasi orangutan, restorasi hutan, dan perlindungan koridor satwa.'],
            ],
            [
                'taxonomy' => 'Reptilia', 'local_name' => 'Komodo', 'scientific_name' => 'Varanus komodoensis', 'iucn_status' => 'EN', 'size' => 'Besar',
                'physical_features' => ['Sisik/Cangkang', 'Ekor Panjang', 'Lidah bercabang'], 'primary_habitat' => 'Sabana dan hutan musim Nusa Tenggara',
                'description' => 'Kadal terbesar di dunia yang merupakan satwa endemik kepulauan Nusa Tenggara.',
                'image_url' => 'https://images.unsplash.com/photo-1535338454770-8be927b5a00b?auto=format&fit=crop&w=1200&q=80',
                'location' => ['region_name' => 'Taman Nasional Komodo', 'latitude' => -8.5500, 'longitude' => 119.4800],
                'physical' => ['size_and_weight' => 'Panjang dapat mencapai 3 meter dengan berat lebih dari 70 kg.', 'distinctive_features' => 'Cakar kuat, ekor panjang, dan gigitan berbisa.'],
                'ecology' => ['habitat_description' => 'Sabana terbuka, hutan musim, dan pesisir berbatu.', 'diet_and_behavior' => 'Predator oportunis yang memangsa rusa, babi hutan, dan bangkai.', 'quote' => 'Warisan purba dari kepulauan Indonesia.'],
                'threats' => [['title' => 'Perubahan Iklim', 'description' => 'Kenaikan muka laut dan perubahan mangsa mengancam habitat pulau.']],
                'programs' => ['Pemantauan populasi, pengawasan kawasan, dan pengaturan kunjungan wisata.'],
            ],
            [
                'taxonomy' => 'Mamalia', 'local_name' => 'Badak Jawa', 'scientific_name' => 'Rhinoceros sondaicus', 'iucn_status' => 'CR', 'size' => 'Besar',
                'physical_features' => ['Tanduk/Cula', 'Kulit berlipat', 'Tubuh kokoh'], 'primary_habitat' => 'Hutan hujan dataran rendah Jawa',
                'description' => 'Salah satu mamalia paling langka di dunia yang kini bertahan di kawasan Ujung Kulon.',
                'image_url' => 'https://images.unsplash.com/photo-1557050543-4d5f4e07ef46?auto=format&fit=crop&w=1200&q=80',
                'location' => ['region_name' => 'Taman Nasional Ujung Kulon', 'latitude' => -6.7500, 'longitude' => 105.3500],
                'physical' => ['size_and_weight' => 'Berat sekitar 900-2.300 kg.', 'distinctive_features' => 'Lipatan kulit menyerupai baju zirah dan cula kecil pada jantan.'],
                'ecology' => ['habitat_description' => 'Hutan tropis lebat, rawa, dan padang rumput di sekitar pesisir.', 'diet_and_behavior' => 'Herbivor yang memakan daun, ranting, dan buah; hidup soliter.', 'quote' => 'Simbol terakhir hutan Jawa yang lestari.'],
                'threats' => [['title' => 'Populasi Terbatas', 'description' => 'Seluruh populasi terkonsentrasi pada satu kawasan sehingga rentan terhadap bencana.']],
                'programs' => ['Patroli habitat, kamera jebak, dan pemantauan kelahiran badak di Ujung Kulon.'],
            ],
            [
                'taxonomy' => 'Aves', 'local_name' => 'Cenderawasih Kuning-kecil', 'scientific_name' => 'Paradisaea minor', 'iucn_status' => 'LC', 'size' => 'Sedang',
                'physical_features' => ['Bulu ekor hias', 'Warna cerah', 'Paruh melengkung'], 'primary_habitat' => 'Hutan Papua',
                'description' => 'Burung khas Papua dengan bulu hias yang digunakan jantan untuk menarik perhatian betina.',
                'image_url' => 'https://images.unsplash.com/photo-1552728089-57bdde30beb3?auto=format&fit=crop&w=1200&q=80',
                'location' => ['region_name' => 'Pegunungan Arfak', 'latitude' => -1.1000, 'longitude' => 133.9000],
                'physical' => ['size_and_weight' => 'Panjang tubuh sekitar 32 cm, belum termasuk bulu hias.', 'distinctive_features' => 'Bulu kuning memanjang pada sisi tubuh jantan.'],
                'ecology' => ['habitat_description' => 'Kanopi hutan dataran rendah hingga perbukitan.', 'diet_and_behavior' => 'Memakan buah dan serangga; jantan melakukan pertunjukan kawin di tempat khusus.', 'quote' => 'Keindahan Papua yang hidup di dalam hutan.'],
                'threats' => [['title' => 'Perdagangan Satwa', 'description' => 'Perburuan untuk bulu hias dapat mengurangi populasi lokal.']],
                'programs' => ['Perlindungan habitat dan edukasi masyarakat mengenai larangan perdagangan satwa liar.'],
            ],
            [
                'taxonomy' => 'Mamalia', 'local_name' => 'Bekantan', 'scientific_name' => 'Nasalis larvatus', 'iucn_status' => 'EN', 'size' => 'Sedang',
                'physical_features' => ['Hidung panjang', 'Perut buncit', 'Bulu cokelat kemerahan'], 'primary_habitat' => 'Hutan mangrove Kalimantan',
                'description' => 'Primata endemik Kalimantan yang mudah dikenali dari hidung panjang dan kemampuannya berenang.',
                'image_url' => 'https://images.unsplash.com/photo-1516934024742-b461fba47600?auto=format&fit=crop&w=1200&q=80',
                'location' => ['region_name' => 'Taman Nasional Sebangau', 'latitude' => -2.3500, 'longitude' => 113.8500],
                'physical' => ['size_and_weight' => 'Jantan dapat memiliki berat hingga 24 kg.', 'distinctive_features' => 'Hidung jantan dewasa besar dan menggantung ke bawah.'],
                'ecology' => ['habitat_description' => 'Mangrove, rawa gambut, dan tepian sungai.', 'diet_and_behavior' => 'Memakan daun, buah, dan biji; hidup dalam kelompok sosial.', 'quote' => 'Penanda penting kesehatan ekosistem rawa.'],
                'threats' => [['title' => 'Kerusakan Mangrove', 'description' => 'Konversi pesisir menghilangkan sumber pakan dan tempat berlindung.']],
                'programs' => ['Restorasi mangrove dan perlindungan koridor sungai untuk kelompok bekantan.'],
            ],
            [
                'taxonomy' => 'Mamalia', 'local_name' => 'Anoa Pegunungan', 'scientific_name' => 'Bubalus quarlesi', 'iucn_status' => 'EN', 'size' => 'Sedang',
                'physical_features' => ['Tanduk/Cula', 'Bulu cokelat', 'Ekor pendek'], 'primary_habitat' => 'Hutan pegunungan Sulawesi',
                'description' => 'Bovidae endemik Sulawesi yang hidup di hutan pegunungan dan aktif mencari makan pada pagi serta sore hari.',
                'image_url' => 'https://images.unsplash.com/photo-1553284965-83fd3e82fa5a?auto=format&fit=crop&w=1200&q=80',
                'location' => ['region_name' => 'Taman Nasional Lore Lindu', 'latitude' => -1.5000, 'longitude' => 120.2000],
                'physical' => ['size_and_weight' => 'Tinggi bahu sekitar 70 cm dengan berat 150-300 kg.', 'distinctive_features' => 'Tubuh kecil dan tanduk pendek yang tumbuh ke belakang.'],
                'ecology' => ['habitat_description' => 'Hutan lembap pada ketinggian hingga 2.000 meter.', 'diet_and_behavior' => 'Memakan rerumputan, daun, dan tunas; umumnya soliter.', 'quote' => 'Penjaga keunikan ekosistem Sulawesi.'],
                'threats' => [['title' => 'Perburuan', 'description' => 'Perburuan untuk daging dan tekanan habitat mengancam populasinya.']],
                'programs' => ['Perlindungan hutan pegunungan dan pemantauan populasi anoa melalui kamera jebak.'],
            ],
            [
                'taxonomy' => 'Aves', 'local_name' => 'Jalak Bali', 'scientific_name' => 'Leucopsar rothschildi', 'iucn_status' => 'CR', 'size' => 'Sedang',
                'physical_features' => ['Sayap', 'Jambul putih', 'Lingkar mata biru'], 'primary_habitat' => 'Hutan musim Bali',
                'description' => 'Burung endemik Bali dengan bulu putih bersih dan ujung sayap hitam yang menjadi ikon konservasi Indonesia.',
                'image_url' => 'https://images.unsplash.com/photo-1444464666168-49d633b86797?auto=format&fit=crop&w=1200&q=80',
                'location' => ['region_name' => 'Taman Nasional Bali Barat', 'latitude' => -8.1500, 'longitude' => 114.5000],
                'physical' => ['size_and_weight' => 'Panjang tubuh sekitar 25 cm.', 'distinctive_features' => 'Bulu putih, jambul tegak, dan kulit biru di sekitar mata.'],
                'ecology' => ['habitat_description' => 'Hutan musim, savana, dan semak pesisir Bali Barat.', 'diet_and_behavior' => 'Memakan buah dan serangga; hidup berpasangan atau dalam kelompok kecil.', 'quote' => 'Kebanggaan alam Pulau Dewata.'],
                'threats' => [['title' => 'Perdagangan Ilegal', 'description' => 'Penangkapan untuk dipelihara menjadi ancaman utama bagi spesies ini.']],
                'programs' => ['Penangkaran, pelepasliaran, dan patroli perlindungan habitat Jalak Bali.'],
            ],
        ];

        foreach ($faunas as $data) {
            $related = ['taxonomy', 'location', 'physical', 'ecology', 'threats', 'programs'];
            $attributes = array_diff_key($data, array_flip($related));
            $attributes['taxonomy_id'] = $taxonomies[$data['taxonomy']]->id;
            $fauna = Fauna::updateOrCreate(['scientific_name' => $data['scientific_name']], $attributes);
            FaunaLocation::updateOrCreate(['fauna_id' => $fauna->id, 'region_name' => $data['location']['region_name']], $data['location']);
            FaunaPhysicalCharacteristic::updateOrCreate(['fauna_id' => $fauna->id], $data['physical']);
            FaunaEcologicalInfo::updateOrCreate(['fauna_id' => $fauna->id], $data['ecology']);
            foreach ($data['threats'] as $threat) FaunaThreat::updateOrCreate(['fauna_id' => $fauna->id, 'title' => $threat['title']], $threat);
            foreach ($data['programs'] as $program) FaunaConservationProgram::firstOrCreate(['fauna_id' => $fauna->id, 'title_or_description' => $program]);
            FaunaGallery::firstOrCreate(['fauna_id' => $fauna->id, 'image_url' => $data['image_url']], ['caption' => $data['local_name']]);
        }
    }

    private function seedHerbals(): void
    {
        $symptoms = [];
        foreach (['Batuk' => 'fa-solid fa-head-side-cough', 'Demam' => 'fa-solid fa-temperature-half', 'Masuk angin' => 'fa-solid fa-wind', 'Gangguan pencernaan' => 'fa-solid fa-stomach', 'Peradangan ringan' => 'fa-solid fa-fire'] as $name => $icon) {
            $symptoms[$name] = Symptom::updateOrCreate(['symptom_name' => $name], ['icon_svg' => $icon]);
        }

        $herbals = [
            ['local_name' => 'Kunyit', 'scientific_name' => 'Curcuma longa L.', 'plant_family' => 'Zingiberaceae', 'origin_region' => 'Asia Tenggara', 'description' => 'Tanaman rimpang yang banyak digunakan dalam jamu dan masakan Nusantara.', 'morphology_description' => 'Herba berumpun dengan rimpang jingga dan daun memanjang.', 'plant_parts' => ['Rimpang'], 'cultivation_zone' => 'Dataran rendah hingga sedang', 'preparation_method' => 'Rebus irisan rimpang atau gunakan sebagai bumbu dan jamu.', 'dosage_guide' => 'Gunakan secukupnya sebagai pangan; untuk penggunaan rutin konsultasikan dengan tenaga kesehatan.', 'safety_warning' => 'Hindari dosis tinggi bila memiliki gangguan empedu atau sedang mengonsumsi pengencer darah.', 'evidence_level' => 'Clinical_Trial', 'image_url' => 'https://images.unsplash.com/photo-1615485500704-8e990f9900f7?auto=format&fit=crop&w=1200&q=80', 'symptoms' => ['Peradangan ringan', 'Gangguan pencernaan'], 'compounds' => [['compound_name' => 'Kurkumin', 'pharmacological_effect' => 'Memiliki aktivitas antioksidan dan antiinflamasi.']], 'interactions' => [['title' => 'Pengencer darah', 'description' => 'Dapat meningkatkan risiko perdarahan pada sebagian pengguna.', 'severity' => 'Perhatian']]],
            ['local_name' => 'Pegagan', 'scientific_name' => 'Centella asiatica (L.) Urb.', 'plant_family' => 'Apiaceae', 'origin_region' => 'Asia tropis', 'description' => 'Herba menjalar yang secara tradisional dimanfaatkan untuk perawatan kulit dan kebugaran.', 'morphology_description' => 'Daun berbentuk ginjal dengan tangkai panjang dan batang menjalar.', 'plant_parts' => ['Daun', 'Batang'], 'cultivation_zone' => 'Dataran rendah dan lembap', 'preparation_method' => 'Cuci daun, seduh sebagai teh, atau olah menjadi lalapan.', 'dosage_guide' => 'Konsumsi sebagai pangan dalam jumlah wajar.', 'safety_warning' => 'Hentikan penggunaan bila muncul reaksi alergi dan konsultasikan untuk penggunaan ekstrak.', 'evidence_level' => 'Clinical_Trial', 'image_url' => 'https://images.unsplash.com/photo-1515586000433-45406d8e6662?auto=format&fit=crop&w=1200&q=80', 'symptoms' => ['Peradangan ringan'], 'compounds' => [['compound_name' => 'Asiaticoside', 'pharmacological_effect' => 'Mendukung proses pembentukan kolagen pada penelitian praklinis.']], 'interactions' => []],
            ['local_name' => 'Jahe', 'scientific_name' => 'Zingiber officinale Roscoe', 'plant_family' => 'Zingiberaceae', 'origin_region' => 'Asia tropis', 'description' => 'Rimpang aromatik yang umum digunakan untuk minuman hangat dan masakan.', 'morphology_description' => 'Herba tegak dengan rimpang bercabang dan aroma khas.', 'plant_parts' => ['Rimpang'], 'cultivation_zone' => 'Dataran rendah hingga tinggi', 'preparation_method' => 'Memarkan rimpang lalu seduh atau rebus dengan air.', 'dosage_guide' => 'Sajikan sebagai minuman pangan dalam jumlah wajar.', 'safety_warning' => 'Dosis tinggi dapat menyebabkan rasa tidak nyaman pada lambung.', 'evidence_level' => 'Empirical', 'image_url' => 'https://images.unsplash.com/photo-1615485290382-441e4d049cb5?auto=format&fit=crop&w=1200&q=80', 'symptoms' => ['Batuk', 'Masuk angin', 'Gangguan pencernaan'], 'compounds' => [['compound_name' => 'Gingerol', 'pharmacological_effect' => 'Memberikan aroma pedas dan aktivitas antioksidan.']], 'interactions' => []],
            ['local_name' => 'Temulawak', 'scientific_name' => 'Curcuma xanthorrhiza Roxb.', 'plant_family' => 'Zingiberaceae', 'origin_region' => 'Jawa dan Bali', 'description' => 'Tanaman rimpang asli Indonesia yang digunakan dalam jamu tradisional.', 'morphology_description' => 'Herba berdaun lebar dengan rimpang berwarna kuning jingga dan aroma kuat.', 'plant_parts' => ['Rimpang'], 'cultivation_zone' => 'Dataran rendah hingga sedang', 'preparation_method' => 'Iris dan rebus rimpang, lalu saring sebelum diminum.', 'dosage_guide' => 'Konsumsi sebagai minuman tradisional dalam jumlah wajar.', 'safety_warning' => 'Konsultasikan penggunaan ekstrak bila memiliki gangguan hati atau empedu.', 'evidence_level' => 'Empirical', 'image_url' => 'https://images.unsplash.com/photo-1615485500834-bc10199bc727?auto=format&fit=crop&w=1200&q=80', 'symptoms' => ['Gangguan pencernaan', 'Peradangan ringan'], 'compounds' => [['compound_name' => 'Xanthorrhizol', 'pharmacological_effect' => 'Senyawa khas temulawak yang banyak diteliti untuk aktivitas antioksidan.']], 'interactions' => []],
            ['local_name' => 'Sambiloto', 'scientific_name' => 'Andrographis paniculata (Burm.f.) Nees', 'plant_family' => 'Acanthaceae', 'origin_region' => 'Asia Selatan dan Tenggara', 'description' => 'Herba pahit yang telah lama digunakan sebagai bagian dari ramuan tradisional Nusantara.', 'morphology_description' => 'Tanaman tegak dengan daun lonjong dan bunga kecil berwarna putih.', 'plant_parts' => ['Daun', 'Batang'], 'cultivation_zone' => 'Dataran rendah hingga sedang', 'preparation_method' => 'Seduh daun kering atau gunakan sediaan herbal terstandar.', 'dosage_guide' => 'Ikuti petunjuk pada produk dan jangan melebihi dosis yang dianjurkan.', 'safety_warning' => 'Tidak dianjurkan untuk ibu hamil; dapat berinteraksi dengan obat tertentu.', 'evidence_level' => 'Clinical_Trial', 'image_url' => 'https://images.unsplash.com/photo-1530968464165-7a1861cbaf9f?auto=format&fit=crop&w=1200&q=80', 'symptoms' => ['Demam', 'Batuk'], 'compounds' => [['compound_name' => 'Andrographolide', 'pharmacological_effect' => 'Diteliti karena aktivitas antiinflamasi dan imunomodulator.']], 'interactions' => [['title' => 'Obat imunosupresan', 'description' => 'Berpotensi memengaruhi kerja obat yang menekan sistem imun.', 'severity' => 'Perhatian']]],
            ['local_name' => 'Daun Sirih', 'scientific_name' => 'Piper betle L.', 'plant_family' => 'Piperaceae', 'origin_region' => 'Asia Tenggara', 'description' => 'Tanaman merambat beraroma khas yang digunakan dalam berbagai tradisi pengobatan dan budaya Indonesia.', 'morphology_description' => 'Merambat dengan daun berbentuk jantung, mengilap, dan beraroma tajam.', 'plant_parts' => ['Daun'], 'cultivation_zone' => 'Dataran rendah yang hangat dan lembap', 'preparation_method' => 'Cuci daun lalu rebus untuk pemakaian luar sesuai kebutuhan.', 'dosage_guide' => 'Gunakan sebagai bahan tradisional dalam jumlah wajar dan higienis.', 'safety_warning' => 'Hentikan penggunaan bila terjadi iritasi atau reaksi alergi.', 'evidence_level' => 'Empirical', 'image_url' => 'https://images.unsplash.com/photo-1515586000433-45406d8e6662?auto=format&fit=crop&w=1200&q=80', 'symptoms' => ['Peradangan ringan'], 'compounds' => [['compound_name' => 'Eugenol', 'pharmacological_effect' => 'Komponen aromatik dengan aktivitas antimikroba pada penelitian laboratorium.']], 'interactions' => []],
            ['local_name' => 'Lidah Buaya', 'scientific_name' => 'Aloe vera (L.) Burm.f.', 'plant_family' => 'Asphodelaceae', 'origin_region' => 'Afrika Utara dan tropis', 'description' => 'Tanaman sukulen yang banyak dibudidayakan untuk perawatan kulit dan bahan pangan.', 'morphology_description' => 'Daun tebal berdaging dengan tepi bergerigi dan gel bening di bagian dalam.', 'plant_parts' => ['Daun', 'Gel'], 'cultivation_zone' => 'Dataran rendah dan kering', 'preparation_method' => 'Ambil gel bagian dalam setelah membersihkan getah kuning kulit daun.', 'dosage_guide' => 'Untuk pemakaian luar gunakan gel yang bersih; konsumsi hanya produk yang telah diproses dengan benar.', 'safety_warning' => 'Getah lateks dapat menyebabkan diare dan tidak dianjurkan untuk ibu hamil.', 'evidence_level' => 'Clinical_Trial', 'image_url' => 'https://images.unsplash.com/photo-1596547609652-9cf5d8d106b1?auto=format&fit=crop&w=1200&q=80', 'symptoms' => ['Peradangan ringan'], 'compounds' => [['compound_name' => 'Aloin', 'pharmacological_effect' => 'Senyawa pada lateks daun yang perlu dihilangkan untuk penggunaan pangan.']], 'interactions' => [['title' => 'Obat pencahar', 'description' => 'Lateks lidah buaya dapat memperkuat efek pencahar.', 'severity' => 'Sedang']]],
            ['local_name' => 'Meniran', 'scientific_name' => 'Phyllanthus niruri L.', 'plant_family' => 'Phyllanthaceae', 'origin_region' => 'Asia tropis', 'description' => 'Herba kecil yang tumbuh liar dan dikenal dalam ramuan tradisional Indonesia.', 'morphology_description' => 'Batang kecil tegak dengan daun majemuk dan buah mungil di bawah tangkai daun.', 'plant_parts' => ['Daun', 'Batang'], 'cultivation_zone' => 'Dataran rendah hingga sedang', 'preparation_method' => 'Keringkan dan seduh sebagai teh herbal sesuai petunjuk ahli.', 'dosage_guide' => 'Gunakan sediaan terstandar dan jangan menggantikan pengobatan dokter.', 'safety_warning' => 'Perlu kehati-hatian pada pengguna obat diabetes atau obat tekanan darah.', 'evidence_level' => 'Empirical', 'image_url' => 'https://images.unsplash.com/photo-1497250681960-ef046c08a56e?auto=format&fit=crop&w=1200&q=80', 'symptoms' => ['Demam', 'Gangguan pencernaan'], 'compounds' => [['compound_name' => 'Filantin', 'pharmacological_effect' => 'Lignan yang menjadi salah satu senyawa penanda meniran.']], 'interactions' => []],
            ['local_name' => 'Kencur', 'scientific_name' => 'Kaempferia galanga L.', 'plant_family' => 'Zingiberaceae', 'origin_region' => 'Asia Tenggara', 'description' => 'Rimpang aromatik yang sering digunakan dalam jamu beras kencur dan masakan tradisional.', 'morphology_description' => 'Herba pendek dengan daun dekat permukaan tanah dan rimpang beraroma tajam.', 'plant_parts' => ['Rimpang'], 'cultivation_zone' => 'Dataran rendah dan sedang', 'preparation_method' => 'Cuci, memarkan, lalu seduh atau rebus bersama bahan jamu.', 'dosage_guide' => 'Konsumsi sebagai minuman tradisional dalam jumlah wajar.', 'safety_warning' => 'Hentikan penggunaan bila muncul iritasi atau keluhan lambung.', 'evidence_level' => 'Empirical', 'image_url' => 'https://images.unsplash.com/photo-1615485290382-441e4d049cb5?auto=format&fit=crop&w=1200&q=80', 'symptoms' => ['Batuk', 'Masuk angin'], 'compounds' => [['compound_name' => 'Ethyl cinnamate', 'pharmacological_effect' => 'Senyawa aromatik yang menjadi salah satu komponen minyak atsiri kencur.']], 'interactions' => []],
            ['local_name' => 'Serai', 'scientific_name' => 'Cymbopogon citratus (DC.) Stapf', 'plant_family' => 'Poaceae', 'origin_region' => 'Asia Selatan dan Tenggara', 'description' => 'Rumput aromatik yang digunakan sebagai bumbu masak dan minuman tradisional.', 'morphology_description' => 'Tumbuh berumpun dengan batang semu putih dan daun panjang beraroma lemon.', 'plant_parts' => ['Batang', 'Daun'], 'cultivation_zone' => 'Dataran rendah hingga tinggi', 'preparation_method' => 'Memarkan batang lalu rebus atau gunakan sebagai bumbu masakan.', 'dosage_guide' => 'Gunakan sebagai bahan pangan dalam jumlah wajar.', 'safety_warning' => 'Minyak atsiri pekat dapat menyebabkan iritasi; jangan digunakan berlebihan.', 'evidence_level' => 'Empirical', 'image_url' => 'https://images.unsplash.com/photo-1601050690597-df0568f70950?auto=format&fit=crop&w=1200&q=80', 'symptoms' => ['Masuk angin', 'Gangguan pencernaan'], 'compounds' => [['compound_name' => 'Citral', 'pharmacological_effect' => 'Komponen minyak atsiri yang memberikan aroma lemon khas serai.']], 'interactions' => []],
        ];

        foreach ($herbals as $data) {
            $related = ['symptoms', 'compounds', 'interactions'];
            $symptomNames = $data['symptoms']; $compounds = $data['compounds']; $interactions = $data['interactions'];
            $herbal = Herbal::updateOrCreate(['scientific_name' => $data['scientific_name']], array_diff_key($data, array_flip($related)));
            foreach ($symptomNames as $symptomName) $herbal->symptoms()->syncWithoutDetaching([$symptoms[$symptomName]->id => ['plant_part_used' => $data['plant_parts'][0]]]);
            foreach ($compounds as $compound) HerbalActiveCompound::updateOrCreate(['herbal_id' => $herbal->id, 'compound_name' => $compound['compound_name']], $compound);
            foreach ($interactions as $interaction) HerbalInteraction::updateOrCreate(['herbal_id' => $herbal->id, 'title' => $interaction['title']], $interaction);
            HerbalGallery::firstOrCreate(['herbal_id' => $herbal->id, 'image_url' => $data['image_url']], ['caption' => $data['local_name']]);
        }
    }
}
