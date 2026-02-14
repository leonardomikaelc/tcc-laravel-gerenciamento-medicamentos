@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1 class="mb-4">Medicamentos Disponíveis para Doação</h1>

    @if($medications->isEmpty())
    <div class="alert alert-info">
        Nenhum medicamento disponível para doação no momento.
    </div>
    @else


    @if(Auth::user()->role === 'admin')
    <a href="{{ route('reuse.doacoes.create') }}" class="btn btn-success mb-3">
        <i class="bi bi-plus-circle"></i> Registrar Doação
    </a>
    @endif

    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Dosagem</th>
                <th>Validade</th>
                <th>Quantidade</th>
                <th>Apresentação</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody>
            @foreach($medications as $m)
            <tr>
                <td>{{ $m->name }}</td>
                <td>{{ $m->dosage }}</td>


                <td>
                    @if($m->expiration_date)
                    {{ \Carbon\Carbon::parse($m->expiration_date)->format('d/m/Y') }}
                    @else
                    -
                    @endif
                </td>

                <td>{{ $m->quantity }}</td>


                <td>
                    @php
                    $pres = [
                    'tablet' => 'Comprimido',
                    'pill' => 'Drágea',
                    'capsule' => 'Cápsula',
                    'drop' => 'Gota',
                    'syrup' => 'Xarope',
                    'ampoule' => 'Ampola'
                    ];
                    @endphp

                    {{ $pres[$m->presentation] ?? $m->presentation }}
                </td>


                <td>
                    @php
                    $today = \Carbon\Carbon::today();
                    $exp = $m->expiration_date ? \Carbon\Carbon::parse($m->expiration_date) : null;
                    $diff = $exp ? $today->diffInDays($exp, false) : null;

                    if ($exp === null) {
                    $status = ['ok', 'Sem data'];
                    } elseif ($diff < 0) {
                        $status=['danger', 'Vencido' ];
                        } elseif ($diff <=90) {
                        $status=['warning', "Vence em $diff dias" ];
                        } else {
                        $status=['success', "Vence em $diff dias" ];
                        }
                        @endphp

                        <span class="badge bg-{{ $status[0] }}">
                        {{ $status[1] }}
                        </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @endif

    <div class="mt-4">
        <a href="{{ route('reuse.index') }}" class="btn btn-outline-primary">Voltar</a>
    </div>
</div>
@endsection