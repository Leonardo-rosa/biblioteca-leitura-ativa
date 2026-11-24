
@extends('layouts.app')

@section('content')
<div class="container py-4">

    <h2 class="mb-4">Novo empréstimo</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $erro)
                <div>{{ $erro }}</div>
            @endforeach
        </div>
    @endif

    @if($exemplares->isEmpty())
        <div class="alert alert-warning">
            Não existem exemplares disponíveis para empréstimo.
        </div>
    @else

        <div class="card">
            <div class="card-body">

                <form action="{{ route('emprestimos.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Exemplar disponível</label>

                        <select name="exemplar_id" class="form-select" required>
                            <option value="">Selecione um exemplar</option>

                            @foreach($exemplares as $exemplar)
                                <option
                                    value="{{ $exemplar->id }}"
                                    {{ old('exemplar_id') == $exemplar->id ? 'selected' : '' }}
                                >
                                    {{ $exemplar->livro->titulo }}
                                    — Código: {{ $exemplar->codigo }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Integrante</label>

                        <select name="user_id" class="form-select" required>
                            <option value="">Selecione um integrante</option>

                            @foreach($usuarios as $usuario)
                                <option
                                    value="{{ $usuario->id }}"
                                    {{ old('user_id') == $usuario->id ? 'selected' : '' }}
                                >
                                    {{ $usuario->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Data prevista para devolução</label>

                        <input
                            type="date"
                            name="data_prevista_devolucao"
                            class="form-control"
                            min="{{ date('Y-m-d') }}"
                            value="{{ old('data_prevista_devolucao') }}"
                            required
                        >
                    </div>

                    <button type="submit" class="btn btn-primary">
                        Registrar empréstimo
                    </button>

                    <a href="{{ route('emprestimos.index') }}" class="btn btn-secondary">
                        Voltar
                    </a>

                </form>

            </div>
        </div>

    @endif

</div>
@endsection
