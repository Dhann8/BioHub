@extends('layout.base')

@section('content')
    @include('peta-interaktif.map-view')
    @include('peta-interaktif.grid-view')
    <script src="{{ asset('js/Map.js') }}"></script>
@endsection