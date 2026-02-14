@extends('layouts.app')

@section('content')
<div class="container my-5">

    <h1 class="mb-4 text-center">Reaproveitamento</h1>
    <p class="text-center mb-4">
        Escolha uma das opções abaixo para visualizar medicamentos disponíveis, registrar doações ou localizar pontos de coleta.
    </p>

    <div class="row g-4">


        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="bi bi-gift fs-1 text-success"></i>
                    <h5 class="mt-3">Doações</h5>
                    <p>Registros de medicamentos doados.</p>
                    <a href="{{ route('reuse.doacoes') }}" class="btn btn-success w-100">
                        Ver Doações
                    </a>
                </div>
            </div>
        </div>


        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="bi bi-capsule fs-1 text-primary"></i>
                    <h5 class="mt-3">Medicamentos</h5>
                    <p>Medicamentos disponíveis para doação.</p>
                    <a href="{{ route('reuse.medications') }}" class="btn btn-primary w-100">
                        Ver Medicamentos
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="bi bi-geo-alt fs-1 text-danger"></i>
                    <h5 class="mt-3">Pontos de Coleta</h5>
                    <p>Locais para descarte seguro.</p>
                    <a href="{{ route('pontos.coleta') }}" class="btn btn-danger w-100">
                        Ver Pontos
                    </a>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection