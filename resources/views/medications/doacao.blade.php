@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Medicamentos Disponíveis para Doação</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($medications->isEmpty())
        <div class="alert alert-info">Nenhum medicamento disponível para doação no momento.</div>
    @else
        <div class="table-responsive shadow-sm rounded">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-success">
                    <tr>
                        <th>Nome</th>
                        <th>Dosagem</th>
                        <th>Validade</th>
                        <th>Quantidade</th>
                        <th>Apresentação</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($medications as $med)
                        @php
                            $today = \Carbon\Carbon::now();
                            $validade = $med->expiration_date ? \Carbon\Carbon::parse($med->expiration_date) : null;
                            $days = $validade ? $today->diffInDays($validade, false) : null;
                            $rowClass = '';
                            if ($validade && $days < 0) {
                                $rowClass = 'table-danger';
                            } elseif ($validade && $days <= 90) {
                                $rowClass = 'table-warning';
                            }
                        @endphp

                        <tr class="{{ $rowClass }}">
                            <td>
                                {{ $med->name }}
                                @if($validade && $days < 0)
                                    <span class="badge bg-danger ms-2">VENCIDO</span>
                                @elseif($validade && $days <= 90)
                                    <span class="badge bg-warning text-dark ms-2">VENCE em {{ $days }}d</span>
                                @endif
                            </td>
                            <td>{{ $med->dosage }}</td>
                            <td>{{ $validade ? $validade->format('d/m/Y') : '-' }}</td>
                            <td>{{ $med->quantity }}</td>
                            <td>{{ $presentations[$med->presentation] ?? ucfirst($med->presentation) }}</td>
                            <td class="text-center">
                                <a href="{{ route('medications.edit', $med->id) }}" class="btn btn-warning btn-sm">Editar</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <div class="mt-4 d-flex gap-2">
        <a href="{{ route('medications.create') }}" class="btn btn-success">➕ Cadastrar Medicamento</a>
        <a href="{{ route('medications.index') }}" class="btn btn-outline-secondary">⬅ Voltar para Lista Geral</a>
    </div>
</div>
@endsection
