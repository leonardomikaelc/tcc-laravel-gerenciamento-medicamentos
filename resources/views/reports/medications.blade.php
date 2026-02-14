@extends('layouts.app')

@section('content')
<div class="container">

    <h2 class="mb-4 text-center">Relatório de Medicamentos</h2>

    <form method="GET" class="row g-3 mb-4">

        <div class="col-md-3">
            <input type="text" name="name" class="form-control" placeholder="Nome do medicamento" value="{{ request('name') }}">
        </div>

        <div class="col-md-3">
            <select name="presentation" class="form-select">
                <option value="">Apresentação</option>
                @foreach($presentations as $p)
                <option value="{{ $p }}" {{ request('presentation') == $p ? 'selected' : '' }}>
                    {{ ucfirst($p) }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2">
            <input type="date" name="date_start" class="form-control" value="{{ request('date_start') }}">
        </div>

        <div class="col-md-2">
            <input type="date" name="date_end" class="form-control" value="{{ request('date_end') }}">
        </div>

        <div class="col-md-2">
            <button class="btn btn-success w-100">Filtrar</button>
        </div>

    </form>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Dosagem</th>
                <th>Validade</th>
                <th>Quantidade</th>
                <th>Apresentação</th>
            </tr>
        </thead>

        <tbody>
            @foreach($medications as $m)
            <tr>
                <td>{{ $m->name }}</td>
                <td>{{ $m->dosage }}</td>
                <td>{{ \Carbon\Carbon::parse($m->expiration_date)->format('d/m/Y') }}</td>
                <td>{{ $m->quantity }}</td>
                <td>{{ $m->presentation }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection