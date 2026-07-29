<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Taxonomy;
use App\Models\Fauna;
use App\Models\FaunaLocation;
use App\Models\Herbal;
use App\Models\Symptom;

class BiodiversitySeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Taxonomies
        $mamalia = Taxonomy::firstOrCreate(['class_name' => 'Mamalia']);
        $burung  = Taxonomy::firstOrCreate(['class_name' => 'Burung']);
        $reptil  = Taxonomy::firstOrCreate(['class_name' => 'Reptil']);
        $amfibi  = Taxonomy::firstOrCreate(['class_name' => 'Amfibi']);
        $serangga= Taxonomy::firstOrCreate(['class_name' => 'Serangga']);

        // 2. Seed Faunas
        $anoa = Fauna::create([
            'taxonomy_id'     => $mamalia->id,
            'local_name'      => 'Anoa Dataran Rendah',
            'scientific_name' => 'Bubalus depressicornis',
            'iucn_status'     => 'EN',
            'description'     => 'Kerbau kerdil endemik Sulawesi. Memiliki ciri khas tanduk lurus dan hidup di hutan hujan primer yang lebat dan jauh dari manusia.',
            'image_url'       => 'https://images.unsplash.com/photo-1551085254-e96b210db58a?auto=format&fit=crop&w=800&q=80',
        ]);

        $babirusa = Fauna::create([
            'taxonomy_id'     => $mamalia->id,
            'local_name'      => 'Babirusa Sulawesi',
            'scientific_name' => 'Babyrousa celebensis',
            'iucn_status'     => 'VU',
            'description'     => 'Dikenal karena taring atasnya yang tumbuh menembus moncong dan melengkung ke arah mata. Hanya ditemukan di Sulawesi dan pulau sekitarnya.',
            'image_url'       => 'https://images.unsplash.com/photo-1574063413132-355dbfd83e0c?auto=format&fit=crop&w=800&q=80',
        ]);

        $bekantan = Fauna::create([
            'taxonomy_id'     => $mamalia->id,
            'local_name'      => 'Bekantan (Monyet Belanda)',
            'scientific_name' => 'Nasalis larvatus',
            'iucn_status'     => 'EN',
            'description'     => 'Primata dengan ciri hidung besar yang khas. Mereka adalah perenang yang sangat baik dan hidup di area hutan bakau dan tepi sungai.',
            'image_url'       => 'https://images.unsplash.com/photo-1534188753412-3e26d0d618d6?auto=format&fit=crop&w=800&q=80',
        ]);

        $maleo = Fauna::create([
            'taxonomy_id'     => $burung->id,
            'local_name'      => 'Burung Maleo',
            'scientific_name' => 'Macrocephalon maleo',
            'iucn_status'     => 'EN',
            'description'     => 'Burung megapoda yang unik karena tidak mengerami telurnya, melainkan menguburnya di pasir pantai yang hangat atau area geotermal.',
            'image_url'       => 'https://images.unsplash.com/photo-1552728089-57bdde30beb3?auto=format&fit=crop&w=800&q=80',
        ]);

        $harimau = Fauna::create([
            'taxonomy_id'     => $mamalia->id,
            'local_name'      => 'Harimau Sumatra',
            'scientific_name' => 'Panthera tigris sumatrae',
            'iucn_status'     => 'CR',
            'description'     => 'Subspesies harimau terakhir di Indonesia yang masih bertahan di kawasan hutan hujan Pulau Sumatra.',
            'image_url'       => 'https://storage.googleapis.com/uxpilot-auth.appspot.com/gen_31dacdbe99_414190625abc34a1.png',
        ]);

        $komodo = Fauna::create([
            'taxonomy_id'     => $reptil->id,
            'local_name'      => 'Komodo',
            'scientific_name' => 'Varanus komodoensis',
            'iucn_status'     => 'VU',
            'description'     => 'Spesies kadal terbesar di dunia yang merupakan satwa endemik Taman Nasional Komodo, Nusa Tenggara Timur.',
            'image_url'       => 'https://storage.googleapis.com/uxpilot-auth.appspot.com/gen_81981d87e6_9a61353525afd149.png',
        ]);

        // 3. Seed Locations
        FaunaLocation::create([
            'fauna_id'    => $anoa->id,
            'region_name' => 'Sulawesi Tenggara',
            'latitude'    => -4.1449,
            'longitude'   => 122.1746,
        ]);

        FaunaLocation::create([
            'fauna_id'    => $babirusa->id,
            'region_name' => 'Sulawesi Utara',
            'latitude'    => 1.4748,
            'longitude'   => 124.8428,
        ]);

        FaunaLocation::create([
            'fauna_id'    => $bekantan->id,
            'region_name' => 'Kalimantan Selatan',
            'latitude'    => -3.3194,
            'longitude'   => 114.5908,
        ]);

        FaunaLocation::create([
            'fauna_id'    => $maleo->id,
            'region_name' => 'Sulawesi Tengah',
            'latitude'    => -0.8982,
            'longitude'   => 119.8707,
        ]);

        FaunaLocation::create([
            'fauna_id'    => $harimau->id,
            'region_name' => 'Sumatra Barat',
            'latitude'    => -0.7399,
            'longitude'   => 100.8000,
        ]);

        FaunaLocation::create([
            'fauna_id'    => $komodo->id,
            'region_name' => 'Nusa Tenggara Timur',
            'latitude'    => -8.5444,
            'longitude'   => 119.4719,
        ]);

        // 4. Seed Herbals
        Herbal::create([
            'local_name'         => 'Kunyit',
            'scientific_name'    => 'Curcuma longa',
            'description'        => 'Tanaman obat populer dengan kandungan kurkumin sebagai antiinflamasi dan antioksidan alami.',
            'preparation_method' => 'Rebus rimpang kunyit yang diparut dengan air bersih.',
            'dosage_guide'       => 'Minum 1 gelas 2 kali sehari sesudah makan.',
            'safety_warning'     => 'Hindari konsumsi berlebih bagi penderita batu empedu.',
            'evidence_level'     => 'Empirical',
            'image_url'          => 'https://images.unsplash.com/photo-1615485290382-441e4d049cb5?auto=format&fit=crop&w=800&q=80',
        ]);

        Herbal::create([
            'local_name'         => 'Jahe Merah',
            'scientific_name'    => 'Zingiber officinale var. rubrum',
            'description'        => 'Spesies jahe dengan rasa lebih pedas, efektif menghangatkan tubuh dan meredakan masuk angin.',
            'preparation_method' => 'Geprek jahe merah dan seduh dengan air hangat.',
            'dosage_guide'       => '1 gelas per hari.',
            'safety_warning'     => 'Aman dikonsumsi harian dalam batas wajar.',
            'evidence_level'     => 'Clinical_Trial',
            'image_url'          => 'https://images.unsplash.com/photo-1599940824399-b87987ceb72a?auto=format&fit=crop&w=800&q=80',
        ]);
    }
}
