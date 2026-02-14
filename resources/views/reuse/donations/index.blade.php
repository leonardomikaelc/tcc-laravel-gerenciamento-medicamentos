@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Doações Registradas</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(Auth::user()->role === 'admin')
        <a href="{{ route('reuse.doacoes.create') }}" class="btn btn-success mb-3">
            <i class="bi bi-plus-circle"></i> Registrar Doação
        </a>
    @endif

    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Medicamento</th>
                <th>Data</th>
                <th>Status</th>
                @if(Auth::user()->role === 'admin')
                    <th>Ações</th>
                @endif
            </tr>
        </thead>

        <tbody>
            @foreach($donations as $d)
                <tr>
                    <td>{{ $d->id }}</td>
                    <td>{{ $d->medication->name }}</td>
                    <td>{{ \Carbon\Carbon::parse($d->donation_date)->format('d/m/Y') }}</td>
                    <td>
                        <span class="badge bg-{{ 
                            $d->status === 'confirmada' ? 'success' :
                            ($d->status === 'recusada' ? 'danger' : 'secondary')
                        }}">
                            {{ ucfirst($d->status) }}
                        </span>
                    </td>

                    @if(Auth::user()->role === 'admin')
                        <td>
                            <a href="{{ route('reuse.doacoes.edit', $d->id) }}" class="btn btn-sm btn-primary">Editar</a>

                            <form action="{{ route('reuse.doacoes.destroy', $d->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Excluir doação?')">Excluir</button>
                            </form>
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('reuse.index') }}" class="btn btn-outline-primary mt-3">Voltar</a>
</div>
@endsection
