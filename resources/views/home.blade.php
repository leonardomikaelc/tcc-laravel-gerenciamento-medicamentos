@extends('layouts.app')

@section('content')
<div class="container text-center">
    <h1 class="mb-4">Bem-vindo ao <span class="text-success">MediLife</span></h1>
    <p class="mb-5">Escolha uma das opções abaixo para navegar pelo sistema:</p>

    <div class="row justify-content-center">


        @if(Auth::user()->role === 'admin')

        <div class="col-md-5 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body d-flex flex-column justify-content-between">
                    <h4 class="card-title text-success">Gerenciamento de Medicamentos</h4>
                    <p class="card-text">Adicione, edite e acompanhe seus medicamentos de forma simples e organizada.</p>
                    <a href="{{ route('medications.index') }}" class="btn btn-success mt-auto">Acessar</a>
                </div>
            </div>
        </div>
        @endif


        <div class="col-md-5 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body d-flex flex-column justify-content-between">
                    <h4 class="card-title text-success">Descarte Correto de Medicamentos</h4>
                    <p class="card-text">Aprenda como descartar medicamentos vencidos ou em desuso sem prejudicar o meio ambiente.</p>
                    <a href="{{ route('informative') }}" class="btn btn-outline-success mt-auto">Saiba Mais</a>
                </div>
            </div>
        </div>


        <div class="col-md-5 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body d-flex flex-column justify-content-between">
                    <h4 class="card-title text-success">Reaproveitamento / Doação</h4>
                    <p class="card-text">Visualize medicamentos disponíveis para doação e encontre pontos de coleta próximos.</p>
                    <a href="{{ route('reuse.index') }}" class="btn btn-success mt-auto">Acessar</a>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection