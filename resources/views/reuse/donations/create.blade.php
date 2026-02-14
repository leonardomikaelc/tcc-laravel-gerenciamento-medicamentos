@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Registrar Doação</h2>

    <form action="{{ route('reuse.doacoes.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Medicamento</label>
            <select name="medication_id" class="form-select" required>
                <option value="">Selecione...</option>
                @foreach ($medications as $m)
                    <option value="{{ $m->id }}">{{ $m->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Data da Doação</label>
            <input type="date" name="donation_date" class="form-control" required>
        </div>

        <button class="btn btn-success">Salvar</button>
    </form>

    <a href="{{ route('reuse.doacoes') }}" class="btn btn-outline-primary mt-3">Voltar</a>
</div>
@endsection
