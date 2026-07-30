<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Herbal;
use App\Models\Symptom;
use App\Models\HerbalActiveCompound;
use App\Models\HerbalInteraction;

class HerbalSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Gejala (Symptoms)
        $gejalaDemam = Symptom::firstOrCreate(['symptom_name' => 'Demam']);
        $gejalaBatuk = Symptom::firstOrCreate(['symptom_name' => 'Batuk & Flu']);
        $gejalaPencernaan = Symptom::firstOrCreate(['symptom_name' => 'Pencernaan']);
        $gejalaNyeri = Symptom::firstOrCreate(['symptom_name' => 'Nyeri Sendi']);
        $gejalaHipertensi = Symptom::firstOrCreate(['symptom_name' => 'Hipertensi']);
        $gejalaKulit = Symptom::firstOrCreate(['symptom_name' => 'Gatal/Kulit']);

        // 2. Buat Herbal (Kunyit)
        $kunyit = Herbal::create([
            'local_name' => 'Kunyit',
            'scientific_name' => 'Curcuma longa',
            'plant_family' => 'Zingiberaceae',
            'origin_region' => 'Asia Tenggara',
            'description' => 'Kunyit adalah tanaman rempah-rempah dan obat asli dari wilayah Asia Tenggara. Tanaman ini merupakan salah satu komponen utama dalam ramuan Jamu tradisional Indonesia karena kandungan kurkuminnya yang kaya akan manfaat kesehatan.',
            'morphology_description' => 'Batang semu, tinggi 40-100 cm. Rimpang berwarna oranye cerah dengan aroma khas.',
            'plant_parts' => ['Rimpang', 'Daun'],
            'cultivation_zone' => 'Dataran rendah hingga 1600 mdpl. Curah hujan 2000-4000 mm/tahun.',
            'preparation_method' => 'Rebus 2 rimpang kunyit (parut) dengan 500ml air, tambahkan asam jawa dan gula merah secukupnya.',
            'dosage_guide' => 'Bubuk: 1.5 - 3 gram per hari. Rimpang segar: 5 - 10 gram per hari. Sangat aman untuk konsumsi harian.',
            'safety_warning' => 'Konsumsi sebagai bumbu masakan aman, namun suplemen kunyit dosis tinggi tidak disarankan bagi ibu hamil.',
            'evidence_level' => 'Clinical_Trial',
            'image_url' => 'https://images.unsplash.com/photo-1615485500704-8e990f9900f7?auto=format&fit=crop&w=800&q=80',
            'map_image_url' => 'https://images.unsplash.com/photo-1524661135-423995f22d0b?auto=format&fit=crop&w=800&q=80'
        ]);

        $kunyit->symptoms()->attach([$gejalaPencernaan->id, $gejalaNyeri->id]);
        
        HerbalActiveCompound::create(['herbal_id' => $kunyit->id, 'compound_name' => 'Kurkuminoid', 'pharmacological_effect' => 'Anti-inflamasi alami yang sangat kuat.']);
        HerbalActiveCompound::create(['herbal_id' => $kunyit->id, 'compound_name' => 'Desmetoksikurkumin', 'pharmacological_effect' => 'Antioksidan tinggi penetralisir radikal bebas.']);
        HerbalInteraction::create(['herbal_id' => $kunyit->id, 'title' => 'Interaksi Obat Pengencer Darah', 'severity' => 'Sedang', 'description' => 'Kunyit dapat mengencerkan darah. Hindari dosis besar bersama Warfarin atau Aspirin.']);

        // 3. Buat Herbal (Jahe Merah)
        $jahe = Herbal::create([
            'local_name' => 'Jahe Merah',
            'scientific_name' => 'Zingiber officinale var. Rubrum',
            'plant_family' => 'Zingiberaceae',
            'origin_region' => 'Indonesia',
            'description' => 'Jahe merah adalah varietas jahe dengan rimpang berwarna kemerahan. Jahe ini memiliki rasa yang lebih pedas dan kandungan minyak atsiri yang lebih tinggi dibandingkan jahe biasa.',
            'morphology_description' => 'Rimpang berwarna merah muda hingga merah bata, ruas rimpang lebih kecil.',
            'plant_parts' => ['Rimpang'],
            'cultivation_zone' => 'Iklim tropis dengan kelembapan tinggi, di bawah 1000 mdpl.',
            'preparation_method' => 'Memarkan 1-2 ruas jahe merah, seduh dengan air panas, tambahkan madu.',
            'dosage_guide' => '1-2 ruas (5-10 gram) per hari.',
            'safety_warning' => 'Aman dikonsumsi. Dapat menyebabkan sensasi panas di perut jika berlebihan.',
            'evidence_level' => 'Empirical',
            'image_url' => 'https://images.unsplash.com/photo-1615485290382-441e4d049cb5?auto=format&fit=crop&w=800&q=80',
        ]);

        $jahe->symptoms()->attach([$gejalaDemam->id, $gejalaBatuk->id, $gejalaNyeri->id]);
        
        HerbalActiveCompound::create(['herbal_id' => $jahe->id, 'compound_name' => 'Gingerol', 'pharmacological_effect' => 'Penghangat tubuh dan pereda mual.']);
        HerbalActiveCompound::create(['herbal_id' => $jahe->id, 'compound_name' => 'Shogaol', 'pharmacological_effect' => 'Anti-inflamasi dan pereda nyeri sendi.']);

        // 4. Buat Herbal (Sambiloto)
        $sambiloto = Herbal::create([
            'local_name' => 'Sambiloto',
            'scientific_name' => 'Andrographis paniculata',
            'plant_family' => 'Acanthaceae',
            'origin_region' => 'Asia Selatan dan Tenggara',
            'description' => 'Sambiloto adalah tumbuhan berkhasiat obat yang dikenal karena rasanya yang sangat pahit. Tanaman ini banyak digunakan untuk menurunkan demam dan meningkatkan kekebalan tubuh.',
            'morphology_description' => 'Tumbuh tegak, tinggi hingga 90 cm, daun berbentuk lanset, bunga putih ungu.',
            'plant_parts' => ['Daun', 'Batang'],
            'cultivation_zone' => 'Ketinggian 1-700 mdpl. Tumbuh liar di tempat terbuka.',
            'preparation_method' => 'Rebus 10-15 helai daun segar dengan 3 gelas air hingga tersisa 1 gelas.',
            'dosage_guide' => 'Dewasa: 1 gelas per hari. Anak-anak disesuaikan. Perhatikan dosis maksimal.',
            'safety_warning' => 'Konsumsi berlebih dapat menyebabkan mual. Hindari untuk wanita hamil.',
            'evidence_level' => 'Clinical_Trial',
            'image_url' => 'https://images.unsplash.com/photo-1515586000433-45406d8e6662?auto=format&fit=crop&w=800&q=80',
        ]);
        
        $sambiloto->symptoms()->attach([$gejalaDemam->id, $gejalaHipertensi->id]);
        HerbalActiveCompound::create(['herbal_id' => $sambiloto->id, 'compound_name' => 'Andrografolida', 'pharmacological_effect' => 'Imunostimulan dan antipiretik (penurun panas).']);

        // 5. Buat Herbal (Serai Wangi)
        $serai = Herbal::create([
            'local_name' => 'Serai Wangi',
            'scientific_name' => 'Cymbopogon nardus',
            'plant_family' => 'Poaceae',
            'origin_region' => 'Asia Tropis',
            'description' => 'Serai wangi adalah tanaman rumput-rumputan yang menghasilkan minyak atsiri (citronella oil). Sangat baik untuk meredakan kembung dan dapat berfungsi sebagai penolak nyamuk alami.',
            'morphology_description' => 'Berumpun besar, daun panjang melengkung, akar serabut kuat.',
            'plant_parts' => ['Batang', 'Daun'],
            'cultivation_zone' => 'Tumbuh subur di daerah tropis dengan banyak sinar matahari.',
            'preparation_method' => 'Memarkan 2 batang serai, rebus dengan 2 gelas air. Bisa juga ditambahkan pada teh.',
            'dosage_guide' => 'Sangat aman digunakan sebagai minuman harian atau teh.',
            'safety_warning' => 'Sangat aman.',
            'evidence_level' => 'Empirical',
            'image_url' => 'https://images.unsplash.com/photo-1598144247392-5b927d3b246a?auto=format&fit=crop&w=800&q=80',
        ]);
        $serai->symptoms()->attach([$gejalaPencernaan->id]);
        HerbalActiveCompound::create(['herbal_id' => $serai->id, 'compound_name' => 'Sitronela', 'pharmacological_effect' => 'Menghangatkan pencernaan dan meredakan spasme.']);
        
        // 6. Buat Herbal (Mengkudu)
        $mengkudu = Herbal::create([
            'local_name' => 'Mengkudu',
            'scientific_name' => 'Morinda citrifolia',
            'plant_family' => 'Rubiaceae',
            'origin_region' => 'Asia Tenggara',
            'description' => 'Mengkudu merupakan tanaman tropis dengan buah khas berbintil. Meskipun memiliki aroma menyengat, buah ini sangat berkhasiat untuk menurunkan tekanan darah dan gula darah.',
            'morphology_description' => 'Pohon kecil, buah berbentuk bulat telur, permukaan berbenjol-benjol.',
            'plant_parts' => ['Buah', 'Daun'],
            'cultivation_zone' => 'Dataran rendah hingga 1500 mdpl.',
            'preparation_method' => 'Jus 1-2 buah mengkudu matang, saring airnya. Tambahkan madu untuk menutupi aromanya.',
            'dosage_guide' => 'Maksimal 50-100 ml jus murni per hari.',
            'safety_warning' => 'Hindari konsumsi berlebih bagi penderita masalah ginjal karena tinggi kalium.',
            'evidence_level' => 'Clinical_Trial',
            'image_url' => 'https://storage.googleapis.com/uxpilot-auth.appspot.com/gen_d6c5be637a_b834564485960f62.png',
        ]);
        $mengkudu->symptoms()->attach([$gejalaHipertensi->id, $gejalaKulit->id]);
        HerbalActiveCompound::create(['herbal_id' => $mengkudu->id, 'compound_name' => 'Scopoletin', 'pharmacological_effect' => 'Vasodilator yang membantu menurunkan tekanan darah.']);
    }
}
