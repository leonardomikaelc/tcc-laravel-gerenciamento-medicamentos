@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Editar Doação</h2>

    <form action="{{ route('reuse.doacoes.update', $donation->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Data da Doação</label>
            <input type="date" name="donation_date" class="form-control"
                value="{{ $donation->donation_date }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select" required>
                <option value="pendente" {{ $donation->status === 'pendente' ? 'selected' : '' }}>Pendente</option>
                <option value="confirmada" {{ $donation->status === 'confirmada' ? 'selected' : '' }}>Confirmada</option>
                <option value="recusada" {{ $donation->status === 'recusada' ? 'selected' : '' }}>Recusada</option>
            </select>
        </div>

        <button class="btn btn-primary">Salvar Alterações</button>
        <a href="{{ route('reuse.doacoes') }}" class="btn btn-outline-secondary ms-2">Cancelar</a>
    </form>
</div>
@endsection
