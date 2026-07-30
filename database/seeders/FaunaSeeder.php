<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Fauna;
use App\Models\Taxonomy;

class FaunaSeeder extends Seeder
{
    public function run(): void
    {
        $mamalia = Taxonomy::where('class_name', 'Mamalia')->first()->id;
        $reptil = Taxonomy::where('class_name', 'Reptilia')->first()->id;
        $aves = Taxonomy::where('class_name', 'Aves')->first()->id;

        Fauna::create([
            'taxonomy_id' => $mamalia,
            'local_name' => 'Orangutan Sumatra',
            'scientific_name' => 'Pongo abelii',
            'iucn_status' => 'CR',
            'size' => 'Besar',
            'physical_features' => ['Bulu Kemerahan', 'Lengan Panjang', 'Primata'],
            'primary_habitat' => 'Hutan Sumatra',
            'description' => 'Orangutan Sumatra adalah primata yang hanya ditemukan di pulau Sumatra, Indonesia. Mereka hidup di hutan tropis dan kini terancam kritis akibat deforestasi dan perburuan liar. Populasi tersisa diperkirakan hanya 13.846 individu di alam liar.',
            'image_url' => 'https://storage.googleapis.com/uxpilot-auth.appspot.com/gen_f191a65feb_5ec75308631152c0.png',
        ]);

        Fauna::create([
            'taxonomy_id' => $mamalia,
            'local_name' => 'Harimau Sumatra',
            'scientific_name' => 'Panthera tigris sumatrae',
            'iucn_status' => 'CR',
            'size' => 'Besar',
            'physical_features' => ['Belang Hitam', 'Karnivora', 'Kucing Besar'],
            'primary_habitat' => 'Hutan Tropis Sumatra',
            'description' => 'Harimau Sumatra adalah satu-satunya subspesies harimau yang masih bertahan hidup di Indonesia, dengan populasi kurang dari 400 ekor. Mereka memiliki warna kulit paling gelap dan ukuran tubuh terkecil dari semua subspesies harimau.',
            'image_url' => 'https://storage.googleapis.com/uxpilot-auth.appspot.com/gen_31dacdbe99_414190625abc34a1.png',
        ]);

        Fauna::create([
            'taxonomy_id' => $reptil,
            'local_name' => 'Komodo',
            'scientific_name' => 'Varanus komodoensis',
            'iucn_status' => 'VU',
            'size' => 'Besar',
            'physical_features' => ['Kadal Raksasa', 'Lidah Bercabang', 'Bisa Beracun'],
            'primary_habitat' => 'Taman Nasional Komodo',
            'description' => 'Komodo adalah spesies kadal terbesar di dunia yang hidup di pulau Komodo, Rinca, Flores, dan Gili Motang. Mereka merupakan predator puncak di habitatnya dan dapat tumbuh hingga mencapai panjang 3 meter.',
            'image_url' => 'https://storage.googleapis.com/uxpilot-auth.appspot.com/gen_81981d87e6_9a61353525afd149.png',
        ]);

        Fauna::create([
            'taxonomy_id' => $aves,
            'local_name' => 'Cendrawasih Kuning Besar',
            'scientific_name' => 'Paradisaea apoda',
            'iucn_status' => 'LC',
            'size' => 'Sedang',
            'physical_features' => ['Bulu Indah', 'Ekor Panjang', 'Warna Cerah'],
            'primary_habitat' => 'Hutan Hujan Papua',
            'description' => 'Dikenal sebagai "Bird of Paradise", Cendrawasih Kuning Besar merupakan burung endemik Papua. Burung jantan memiliki bulu-bulu hiasan yang sangat indah berwarna kuning dan putih.',
            'image_url' => 'https://storage.googleapis.com/uxpilot-auth.appspot.com/gen_c4beef68e2_ce876c5a5310a821.png',
        ]);
    }
}
