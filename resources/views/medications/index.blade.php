@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Lista de Medicamentos</h1>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif


    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body d-flex align-items-center gap-3">
                    <div>
                        <span class="badge bg-danger p-2">VENCIDOS</span>
                        <div class="h4 mb-0">{{ $counts['expired'] ?? 0 }}</div>
                    </div>
                    <div class="text-muted">Medicamentos já expirados</div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body d-flex align-items-center gap-3">
                    <div>
                        <span class="badge bg-warning text-dark p-2">VENCENDO</span>
                        <div class="h4 mb-0">{{ $counts['near'] ?? 0 }}</div>
                    </div>
                    <div class="text-muted">Vence em até 90 dias</div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body d-flex align-items-center gap-3">
                    <div>
                        <span class="badge bg-success p-2">OK</span>
                        <div class="h4 mb-0">{{ $counts['ok'] ?? 0 }}</div>
                    </div>
                    <div class="text-muted">Sem alerta</div>
                </div>
            </div>
        </div>
    </div>


    @if ($medications_alerta->isNotEmpty())
    <div class="alert alert-warning shadow-sm rounded p-3 mb-4">
        <h5 class="mb-2">⚠️ Atenção! Medicamentos com vencimento próximo (até 180 dias):</h5>
        <ul class="mb-0 small">
            @foreach ($medications_alerta as $med)
            <li>
                <strong>{{ $med->name }}</strong> — {{ $med->expiration_date ? \Carbon\Carbon::parse($med->expiration_date)->format('d/m/Y') : '—' }}
            </li>
            @endforeach
        </ul>
    </div>
    @endif


    <form action="{{ route('medications.index') }}" method="GET" class="mb-4">
        <div class="row g-2 align-items-center">
            <div class="col-md-4">
                <select name="filter" class="form-control">
                    <option value="">Todas apresentações</option>
                    @foreach($presentations as $val => $label)
                    <option value="{{ $val }}" {{ request('filter') == $val ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="1" id="controlled" name="controlled" {{ request('controlled') == '1' ? 'checked' : '' }}>
                    <label class="form-check-label" for="controlled">Apenas controlados</label>
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="1" id="donation" name="donation" {{ request('donation') == '1' ? 'checked' : '' }}>
                    <label class="form-check-label" for="donation">Apenas doação</label>
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="1" id="expired" name="expired" {{ request('expired') == '1' ? 'checked' : '' }}>
                    <label class="form-check-label" for="expired">Apenas vencidos</label>
                </div>
            </div>

            <div class="col-md-2">
                <button type="submit" class="btn btn-success w-100">Filtrar</button>
            </div>
        </div>
    </form>


    <div class="table-responsive shadow-sm rounded">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-success">
                <tr>
                    <th>Nome</th>
                    <th>Dosagem</th>
                    <th>Vencimento</th>
                    <th>Quantidade</th>
                    <th>Apresentação</th>
                    <th>Lote</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($medications as $med)
                @php
                $rowClass = '';
                if ($med->status === 'expired') {
                $rowClass = 'table-danger';
                } elseif ($med->status === 'near_expiration') {
                $rowClass = 'table-warning';
                } elseif ($med->is_controlled) {
                $rowClass = 'table-info';
                }
                @endphp

                <tr class="{{ $rowClass }}">
                    <td>
                        @if($med->status === 'expired')
                        <span class="fw-bold text-danger">☠️ {{ $med->name }}</span>
                        @else
                        {{ $med->name }}
                        @endif


                        @if($med->is_controlled)
                        <span class="badge bg-dark ms-2">Controlado</span>
                        @endif


                        @if($med->is_donation)
                        <span class="badge bg-success ms-1">Doação</span>
                        @endif
                    </td>

                    <td>{{ $med->dosage }}</td>
                    <td>{{ $med->expiration_date ? \Carbon\Carbon::parse($med->expiration_date)->format('d/m/Y') : '—' }}
                        @if(isset($med->days) && $med->status === 'near_expiration')
                        <small class="text-warning"> (vence em {{ $med->days }} dias)</small>
                        @endif
                    </td>
                    <td>{{ $med->quantity }}</td>
                    <td>{{ $presentations[$med->presentation] ?? ucfirst($med->presentation) }}</td>
                    <td>{{ $med->batch }}</td>

                    <td class="text-center">
                        @if($med->status === 'expired')
                        <span class="text-danger fw-bold"><i class="bi bi-x-circle-fill"></i> VENCIDO</span>
                        @elseif($med->status === 'near_expiration')
                        <span class="text-warning fw-bold"><i class="bi bi-exclamation-circle-fill"></i> VENCENDO</span>
                        @else
                        <span class="text-success fw-bold"><i class="bi bi-check-circle-fill"></i> OK</span>
                        @endif
                    </td>

                    <td class="text-center">
                        <a href="{{ route('medications.edit', $med->id) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('medications.destroy', $med->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir?');">Excluir</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted">Nenhum medicamento encontrado.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4 d-flex gap-2">
        <a href="{{ route('home') }}" class="btn btn-outline-secondary">⬅ Voltar para Home</a>
        <a href="{{ route('medications.create') }}" class="btn btn-success">➕ Adicionar Medicamento</a>
        <a href="{{ route('medications.createDonation') }}" class="btn btn-outline-success">➕ Adicionar (Doação)</a>
        <a href="{{ route('medications.doacao') }}" class="btn btn-outline-primary">📦 Ver disponibilidades (Doação)</a>
    </div>
    </br>
</div>
@endsection