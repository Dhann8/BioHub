@extends('layout.peta-interaktif')

@push('styles')
    <style>body { overflow: hidden; }</style>
@endpush

@section('content')
    @include('peta-interaktif.map-view')
    @include('peta-interaktif.grid-view')

    @php
        $speciesDataPayload = [];

        // 1. Process Faunas
        foreach($faunas as $idx => $f) {
            $hasDbLocations = $f->locations && $f->locations->count() > 0;

            if ($hasDbLocations) {
                // If fauna has multiple locations in DB, map each location
                foreach($f->locations as $lIdx => $loc) {
                    $lat = (float) $loc->latitude;
                    $lng = (float) $loc->longitude;
                    $locName = strtolower($loc->region_name);
                    $region = "Semua Wilayah";

                    if (str_contains($locName, 'sumatra')) $region = "Sumatra";
                    elseif (str_contains($locName, 'jawa')) $region = "Jawa";
                    elseif (str_contains($locName, 'kalimantan')) $region = "Kalimantan";
                    elseif (str_contains($locName, 'sulawesi')) $region = "Sulawesi";
                    elseif (str_contains($locName, 'papua')) $region = "Papua";
                    elseif (str_contains($locName, 'bali') || str_contains($locName, 'nusa tenggara') || str_contains($locName, 'komodo') || str_contains($locName, 'flores')) $region = "Nusa Tenggara & Bali";
                    elseif (str_contains($locName, 'maluku')) $region = "Maluku";
                    else $region = $loc->region_name ?: "Indonesia";

                    $key = $f->locations->count() > 1 ? "fauna_{$f->id}_loc_{$loc->id}" : "fauna_{$f->id}";

                    $speciesDataPayload[$key] = [
                        'id'          => $f->id,
                        'key'         => $key,
                        'parentKey'   => "fauna_{$f->id}",
                        'type'        => 'fauna',
                        'name'        => $f->local_name . ($f->locations->count() > 1 ? " ({$loc->region_name})" : ""),
                        'baseName'    => $f->local_name,
                        'latin'       => $f->scientific_name,
                        'cat'         => 'Fauna · ' . ($f->taxonomy->class_name ?? 'Vertebrata'),
                        'taxonomy'    => $f->taxonomy->class_name ?? 'Mamalia',
                        'status'      => strtoupper($f->iucn_status ?: 'LC'),
                        'statusClass' => 'bg-status-' . strtolower($f->iucn_status ?: 'lc'),
                        'desc'        => $f->description ?: 'Spesies satwa dilindungi nusantara dengan keanekaragaman genetik yang tinggi.',
                        'img'         => $f->image_url ?: 'https://storage.googleapis.com/uxpilot-auth.appspot.com/gen_3a21343fd1_225b4e4a886799f4.png',
                        'detailUrl'   => route('detail-spesies', $f->id),
                        'lat'         => $lat,
                        'lng'         => $lng,
                        'region'      => $region,
                        'locationName'=> $loc->region_name,
                        'stat1_label' => 'Titik Sebaran',
                        'stat1_val'   => Str::limit($loc->region_name, 22),
                        'stat2_label' => 'Tren Populasi',
                        'stat2_val'   => $f->population_trend ?: ($f->iucn_status == 'CR' || $f->iucn_status == 'EN' ? 'Menurun' : 'Stabil')
                    ];
                }
            } else {
                // Fallback smart geographic coordinates based on known species & habitat
                $lat = -2.5;
                $lng = 118.0;
                $region = "Semua Wilayah";
                $n = strtolower($f->local_name . ' ' . $f->primary_habitat);

                if (str_contains($n, 'orangutan sumatra') || str_contains($n, 'leuser')) {
                    $lat = 3.5852; $lng = 97.4338; $region = "Sumatra";
                } elseif (str_contains($n, 'harimau sumatra') || str_contains($n, 'kerinci')) {
                    $lat = -2.4206; $lng = 101.4883; $region = "Sumatra";
                } elseif (str_contains($n, 'gajah sumatra') || str_contains($n, 'way kambas')) {
                    $lat = -5.0200; $lng = 105.7500; $region = "Sumatra";
                } elseif (str_contains($n, 'komodo') || str_contains($n, 'rinca') || str_contains($n, 'flores')) {
                    $lat = -8.5833; $lng = 119.4833; $region = "Nusa Tenggara & Bali";
                } elseif (str_contains($n, 'cendrawasih') || str_contains($n, 'papua') || str_contains($n, 'arfak')) {
                    $lat = -0.8753; $lng = 134.0620; $region = "Papua";
                } elseif (str_contains($n, 'badak jawa') || str_contains($n, 'ujung kulon')) {
                    $lat = -6.7500; $lng = 105.3333; $region = "Jawa";
                } elseif (str_contains($n, 'jalak bali') || str_contains($n, 'bali')) {
                    $lat = -8.1400; $lng = 114.4500; $region = "Nusa Tenggara & Bali";
                } elseif (str_contains($n, 'bekantan') || str_contains($n, 'orangutan kalimantan') || str_contains($n, 'tanjung puting')) {
                    $lat = -2.9000; $lng = 111.9000; $region = "Kalimantan";
                } elseif (str_contains($n, 'anoa') || str_contains($n, 'babirusa') || str_contains($n, 'maleo') || str_contains($n, 'sulawesi')) {
                    $lat = -1.3300; $lng = 120.1500; $region = "Sulawesi";
                } elseif (str_contains($n, 'bidadari') || str_contains($n, 'maluku') || str_contains($n, 'halmahera')) {
                    $lat = 0.8500; $lng = 127.8500; $region = "Maluku";
                } else {
                    $islandCoords = [
                        ['lat' => 0.5897, 'lng' => 101.3431, 'reg' => 'Sumatra'],
                        ['lat' => -7.1500, 'lng' => 109.5000, 'reg' => 'Jawa'],
                        ['lat' => -0.5000, 'lng' => 114.0000, 'reg' => 'Kalimantan'],
                        ['lat' => -2.0000, 'lng' => 121.5000, 'reg' => 'Sulawesi'],
                        ['lat' => -3.5000, 'lng' => 137.5000, 'reg' => 'Papua'],
                    ];
                    $pick = $islandCoords[$idx % count($islandCoords)];
                    $lat = $pick['lat'] + (rand(-10, 10) / 100);
                    $lng = $pick['lng'] + (rand(-10, 10) / 100);
                    $region = $pick['reg'];
                }

                $key = "fauna_{$f->id}";
                $speciesDataPayload[$key] = [
                    'id'          => $f->id,
                    'key'         => $key,
                    'parentKey'   => $key,
                    'type'        => 'fauna',
                    'name'        => $f->local_name,
                    'baseName'    => $f->local_name,
                    'latin'       => $f->scientific_name,
                    'cat'         => 'Fauna · ' . ($f->taxonomy->class_name ?? 'Vertebrata'),
                    'taxonomy'    => $f->taxonomy->class_name ?? 'Mamalia',
                    'status'      => strtoupper($f->iucn_status ?: 'LC'),
                    'statusClass' => 'bg-status-' . strtolower($f->iucn_status ?: 'lc'),
                    'desc'        => $f->description ?: 'Spesies satwa dilindungi nusantara dengan keanekaragaman genetik yang tinggi.',
                    'img'         => $f->image_url ?: 'https://storage.googleapis.com/uxpilot-auth.appspot.com/gen_3a21343fd1_225b4e4a886799f4.png',
                    'detailUrl'   => route('detail-spesies', $f->id),
                    'lat'         => $lat,
                    'lng'         => $lng,
                    'region'      => $region,
                    'locationName'=> $f->primary_habitat ?: $region,
                    'stat1_label' => 'Habitat / Sebaran',
                    'stat1_val'   => Str::limit($f->primary_habitat ?: $region, 22),
                    'stat2_label' => 'Tren Populasi',
                    'stat2_val'   => $f->population_trend ?: ($f->iucn_status == 'CR' || $f->iucn_status == 'EN' ? 'Menurun' : 'Stabil')
                ];
            }
        }

        // 2. Process Herbals / Flora
        $floraCoords = [
            'kunyit'       => ['lat' => -7.7956, 'lng' => 110.3695, 'reg' => 'Jawa', 'loc' => 'DI Yogyakarta'],
            'jahe merah'   => ['lat' => -6.9277, 'lng' => 106.9300, 'reg' => 'Jawa', 'loc' => 'Sukabumi, Jawa Barat'],
            'sambiloto'    => ['lat' => -7.9797, 'lng' => 112.6304, 'reg' => 'Jawa', 'loc' => 'Malang, Jawa Timur'],
            'serai wangi'  => ['lat' => 2.3833,  'lng' => 99.0667,  'reg' => 'Sumatra', 'loc' => 'Toba, Sumatra Utara'],
            'mengkudu'     => ['lat' => -8.6500, 'lng' => 116.3249, 'reg' => 'Nusa Tenggara & Bali', 'loc' => 'Lombok, NTB'],
            'kayu manis'   => ['lat' => -0.9500, 'lng' => 100.3500, 'reg' => 'Sumatra', 'loc' => 'Bukittinggi, Sumatra Barat'],
            'sarang semut' => ['lat' => -4.2699, 'lng' => 138.0804, 'reg' => 'Papua', 'loc' => 'Pegunungan Jayawijaya, Papua'],
            'pasak bumi'   => ['lat' => -0.0263, 'lng' => 109.3425, 'reg' => 'Kalimantan', 'loc' => 'Pontianak, Kalimantan Barat'],
            'pala'         => ['lat' => -3.6954, 'lng' => 128.1814, 'reg' => 'Maluku', 'loc' => 'Kepulauan Banda, Maluku'],
            'cengkeh'      => ['lat' => 0.7893,  'lng' => 127.3610, 'reg' => 'Maluku', 'loc' => 'Ternate, Maluku Utara'],
        ];

        foreach($herbals as $idx => $h) {
            $nameKey = strtolower($h->local_name);
            $lat = -6.2000;
            $lng = 106.8166;
            $region = "Jawa";
            $locName = "Jawa";

            $matched = false;
            foreach ($floraCoords as $key => $coord) {
                if (str_contains($nameKey, $key)) {
                    $lat = $coord['lat'];
                    $lng = $coord['lng'];
                    $region = $coord['reg'];
                    $locName = $coord['loc'] ?? $coord['reg'];
                    $matched = true;
                    break;
                }
            }

            if (!$matched) {
                $originLower = strtolower($h->origin_region . ' ' . $h->cultivation_zone);
                if (str_contains($originLower, 'sumatra')) { $lat = 0.8 + ($idx * 0.4); $lng = 100.5; $region = 'Sumatra'; $locName = 'Sumatra'; }
                elseif (str_contains($originLower, 'kalimantan')) { $lat = -1.2 + ($idx * 0.3); $lng = 113.8; $region = 'Kalimantan'; $locName = 'Kalimantan'; }
                elseif (str_contains($originLower, 'sulawesi')) { $lat = -2.1 + ($idx * 0.4); $lng = 120.8; $region = 'Sulawesi'; $locName = 'Sulawesi'; }
                elseif (str_contains($originLower, 'papua')) { $lat = -3.8 + ($idx * 0.3); $lng = 137.0; $region = 'Papua'; $locName = 'Papua'; }
                elseif (str_contains($originLower, 'maluku')) { $lat = -3.2 + ($idx * 0.4); $lng = 128.5; $region = 'Maluku'; $locName = 'Maluku'; }
                else {
                    $jawaOffsets = [
                        ['lat' => -6.90, 'lng' => 107.60, 'loc' => 'Bandung, Jawa Barat'],
                        ['lat' => -7.42, 'lng' => 109.23, 'loc' => 'Banyumas, Jawa Tengah'],
                        ['lat' => -7.78, 'lng' => 110.37, 'loc' => 'Yogyakarta'],
                        ['lat' => -7.25, 'lng' => 112.75, 'loc' => 'Surabaya, Jawa Timur'],
                    ];
                    $chosen = $jawaOffsets[$idx % count($jawaOffsets)];
                    $lat = $chosen['lat'];
                    $lng = $chosen['lng'];
                    $region = 'Jawa';
                    $locName = $chosen['loc'];
                }
            }

            $partsStr = is_array($h->plant_parts) ? implode(', ', $h->plant_parts) : ($h->plant_parts ?: 'Daun, Rimpang');
            $evidenceStr = $h->evidence_level == 'Clinical_Trial' ? 'Uji Klinis' : 'Empiris';
            $activeList = $h->activeCompounds->pluck('compound_name')->join(', ');

            $key = "flora_{$h->id}";
            $speciesDataPayload[$key] = [
                'id'          => $h->id,
                'key'         => $key,
                'parentKey'   => $key,
                'type'        => 'flora',
                'name'        => $h->local_name,
                'baseName'    => $h->local_name,
                'latin'       => $h->scientific_name,
                'cat'         => 'Flora · ' . ($h->plant_family ?: 'Herbal'),
                'taxonomy'    => 'Flora Herbal',
                'status'      => 'LC',
                'statusClass' => 'bg-status-lc',
                'desc'        => $h->description ?: 'Tanaman obat tradisional Indonesia dengan senyawa fitofarmaka berkhasiat.',
                'img'         => $h->image_url ?: 'https://storage.googleapis.com/uxpilot-auth.appspot.com/gen_7ae549a4c2_576d1ef06a77f38a.png',
                'detailUrl'   => route('detail-herbal', $h->id),
                'lat'         => $lat,
                'lng'         => $lng,
                'region'      => $region,
                'locationName'=> $locName,
                'stat1_label' => 'Bagian Digunakan',
                'stat1_val'   => Str::limit($partsStr, 22),
                'stat2_label' => 'Senyawa & Khasiat',
                'stat2_val'   => Str::limit($activeList ?: $evidenceStr, 24)
            ];
        }
    @endphp

    <script>
        window.dynamicSpeciesData = {!! json_encode($speciesDataPayload, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) !!};
        window.dynamicTaxonomies = {!! json_encode($taxonomies->pluck('class_name')->toArray(), JSON_UNESCAPED_UNICODE) !!};
    </script>
    <script src="{{ asset('js/Peta.js') }}"></script>
@endsection