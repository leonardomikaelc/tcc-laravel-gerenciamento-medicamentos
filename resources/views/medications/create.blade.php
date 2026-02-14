@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Adicionar Medicamento</h1>

    @php $isDonation = $isDonation ?? false; @endphp

    <form action="{{ route('medications.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Nome do Medicamento</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label for="dosage" class="form-label">Dosagem</label>
            <input type="text" class="form-control" id="dosage" name="dosage" value="{{ old('dosage') }}" required>
        </div>

        <div class="mb-3">
            <label for="batch" class="form-label">Lote</label>
            <input type="text" class="form-control" id="batch" name="batch" value="{{ old('batch') }}">
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="expiration_date" class="form-label">Data de Vencimento</label>
                <input type="date" class="form-control" id="expiration_date" name="expiration_date" value="{{ old('expiration_date') }}">
            </div>

            <div class="col-md-6 mb-3">
                <label for="quantity" class="form-label">Quantidade</label>
                <input type="number" class="form-control" id="quantity" name="quantity" value="{{ old('quantity', 1) }}" min="0" required>
            </div>
        </div>

        <div class="mb-3">
            <label for="presentation" class="form-label">Apresentação</label>
            <select class="form-control" id="presentation" name="presentation" required>
                <option value="">Selecione</option>
                @foreach($presentations as $val => $label)
                    <option value="{{ $val }}" {{ old('presentation') == $val ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" value="1" id="controlled" name="controlled" {{ old('controlled') ? 'checked' : '' }}>
            <label class="form-check-label" for="controlled">
                Medicamento controlado / alta vigilância
            </label>
        </div>

        <div class="form-check mb-4">
            <input class="form-check-input" type="checkbox" value="1" id="available_for_donation" name="available_for_donation"
                {{ old('available_for_donation', $isDonation ? 1 : 0) ? 'checked' : '' }}>
            <label class="form-check-label" for="available_for_donation">
                Disponível para Doação
            </label>
        </div>

        <button type="submit" class="btn btn-success">Adicionar Medicamento</button>
        <a href="{{ route('medications.index') }}" class="btn btn-secondary">Voltar</a>
    </form>
</div>
@endsection
