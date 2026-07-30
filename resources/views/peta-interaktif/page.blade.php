@extends('layout.peta-interaktif')

@push('styles')
    <style>body { overflow: hidden; }</style>
@endpush

@section('content')
    @include('peta-interaktif.map-view')
    @include('peta-interaktif.grid-view')
    <script>
        window.dynamicSpeciesData = {};
        @foreach($faunas as $f)
        window.dynamicSpeciesData["fauna_{{ $f->id }}"] = {
            id: {{ $f->id }},
            name: "{{ $f->local_name }}",
            latin: "{{ $f->scientific_name }}",
            cat: "Fauna · {{ $f->taxonomy->class_name ?? '' }}",
            status: "{{ $f->iucn_status }}",
            statusClass: "bg-status-{{ strtolower($f->iucn_status) }}",
            desc: {!! json_encode(Str::limit($f->description, 200)) !!},
            img: "{{ $f->image_url ?: 'https://storage.googleapis.com/uxpilot-auth.appspot.com/gen_3a21343fd1_225b4e4a886799f4.png' }}"
        };
        @endforeach
        @foreach($herbals as $h)
        window.dynamicSpeciesData["flora_{{ $h->id }}"] = {
            id: {{ $h->id }},
            name: "{{ $h->local_name }}",
            latin: "{{ $h->scientific_name }}",
            cat: "Flora · {{ $h->plant_family ?? 'Herbal' }}",
            status: "LC", // Hardcode for flora if none
            statusClass: "bg-status-lc",
            desc: {!! json_encode(Str::limit($h->description, 200)) !!},
            img: "{{ $h->image_url ?: 'https://storage.googleapis.com/uxpilot-auth.appspot.com/gen_7ae549a4c2_576d1ef06a77f38a.png' }}"
        };
        @endforeach
    </script>
    <script src="{{ asset('js/Peta.js') }}"></script>
@endsection