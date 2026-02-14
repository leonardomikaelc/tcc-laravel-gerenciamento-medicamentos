@extends('layouts.app')

@section('content')
<div class="container">

    <h2 class="mb-4 text-center">Relatório de Doações</h2>

    <form method="GET" class="row g-3 mb-4">

        <div class="col-md-4">
            <select name="status" class="form-select">
                <option value="">Status</option>
                <option value="pendente" {{ request('status') == 'pendente' ? 'selected' : '' }}>Pendente</option>
                <option value="confirmado" {{ request('status') == 'confirmado' ? 'selected' : '' }}>Confirmado</option>
                <option value="recusado" {{ request('status') == 'recusado' ? 'selected' : '' }}>Recusado</option>
            </select>
        </div>

        <div class="col-md-4">
            <select name="medication_id" class="form-select">
                <option value="">Medicamento</option>
                @foreach($medications as $m)
                <option value="{{ $m->id }}" {{ request('medication_id') == $m->id ? 'selected' : '' }}>
                    {{ $m->name }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <input type="date" name="date" class="form-control" value="{{ request('date') }}">
        </div>

        <div class="col-md-1">
            <button class="btn btn-success w-100">Filtrar</button>
        </div>

    </form>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Medicamento</th>
                <th>Data</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody>
            @foreach($donations as $d)
            <tr>
                <td>{{ $d->id }}</td>
                <td>{{ $d->medication->name }}</td>
                <td>{{ \Carbon\Carbon::parse($d->donation_date)->format('d/m/Y') }}</td>
                <td>{{ ucfirst($d->status) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection