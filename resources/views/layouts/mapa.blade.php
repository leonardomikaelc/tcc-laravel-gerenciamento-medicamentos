@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-3 text-center">Pontos de Coleta</h2>
    <p class="text-center">Confira os pontos de coleta de medicamentos disponíveis na sua cidade.</p>

    <div class="ratio ratio-16x9">
        <iframe 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3656.0912057370067!2d-46.65657298502127!3d-23.597066584663837!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94ce59c6e4b43f4d%3A0x60c32d2d8e4a7d!2sFarm%C3%A1cia!5e0!3m2!1spt-BR!2sbr!4v1661817376000!5m2!1spt-BR!2sbr" 
            width="600" 
            height="450" 
            style="border:0;" 
            allowfullscreen="" 
            loading="lazy">
        </iframe>
    </div>

    <div class="mt-3 text-center">
        <a href="{{ route('reuse.index') }}" class="btn btn-voltar">
            <i class="bi bi-arrow-left"></i> Voltar
        </a>
    </div>
</div>
@endsection
