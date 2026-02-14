@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">

<style>
    #map {
        width: 100%;
        height: 500px;
        border-radius: 10px;
        border: 2px solid #1b4332;
    }

    .btn-outline-primary {
        border-radius: 8px;
        padding: 8px 18px;
        font-weight: 500;
    }
</style>
@endpush

@section('content')
<div class="container mt-4">

    <h2 class="text-center mb-3">Pontos de Coleta de Medicamentos</h2>
    <p class="text-center text-muted">
        Locais disponíveis para descarte e doação de medicamentos.
    </p>

    <div id="map"></div>

    <div class="mt-4 text-center">
        <a href="{{ route('reuse.index') }}" class="btn btn-outline-primary">
            <i class="bi bi-arrow-left"></i> Voltar
        </a>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var map = L.map('map').setView([-28.3001, -54.2667], 14);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);

        var pontosColeta = [{
                nome: "Farmácia São João - Centro",
                coords: [-28.2995, -54.2642],
                descricao: "Ponto de coleta parceiro para descarte de medicamentos."
            },
            {
                nome: "Unimed Missões - Hospital",
                coords: [-28.3038, -54.2705],
                descricao: "Coleta exclusivamente de medicamentos vencidos."
            },
            {
                nome: "Posto de Saúde Sepé",
                coords: [-28.2924, -54.2681],
                descricao: "Aceita doações e medicamentos em bom estado."
            }
        ];

        pontosColeta.forEach(function(ponto) {
            L.marker(ponto.coords)
                .addTo(map)
                .bindPopup("<b>" + ponto.nome + "</b><br>" + ponto.descricao);
        });
    });
</script>
@endpush