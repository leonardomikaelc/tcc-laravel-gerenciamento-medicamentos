@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1 class="text-center mb-4">Descarte Correto de Medicamentos</h1>

    <p class="lead text-center">
        O descarte adequado de medicamentos é fundamental para proteger a saúde e o meio ambiente.
        Siga as orientações abaixo para garantir um descarte seguro.
    </p>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title">Passo 1: Identifique os Medicamentos Vencidos</h5>
                    <p class="card-text">
                        Verifique a data de validade dos seus medicamentos.
                        Aqueles que estão vencidos ou não são mais necessários devem ser descartados.
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title">Passo 2: Não Descarte no Lixo Comum</h5>
                    <p class="card-text">
                        Nunca jogue medicamentos no lixo comum ou na pia,
                        pois isso pode contaminar o solo e a água.
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title">Passo 3: Procure um Ponto de Coleta</h5>
                    <p class="card-text">
                        Leve seus medicamentos a pontos de coleta autorizados,
                        como farmácias ou unidades de saúde, que possuem programas de descarte seguro.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <h2 class="text-center mt-5 mb-4">Por que é Importante Descartar Corretamente?</h2>
    <p class="text-center">
        O descarte inadequado de medicamentos pode causar riscos à saúde pública e ao meio ambiente.
        Seguir as diretrizes de descarte ajuda a:
    </p>

    <ul class="list-group mb-5 shadow-sm">
        <li class="list-group-item">🌱 Proteger o meio ambiente</li>
        <li class="list-group-item">💧 Reduzir o risco de contaminação da água</li>
        <li class="list-group-item">👶 Prevenir o acesso de crianças e animais a medicamentos perigosos</li>
    </ul>

    <div class="text-center">
        <a href="{{ route('home') }}" class="btn btn-success">⬅ Voltar para a Página Inicial</a>
    </div>
</div>
@endsection