
@extends('layouts.app')

@section('title', 'Exemplares')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1">Exemplares</h2>
        <p class="text-secondary mb-0">
            Gerencie os exemplares disponíveis no acervo.
        </p>
    </div>

    <a href="{{ route('exemplares.create') }}" class="btn btn-primary">
        + Novo exemplar
    </a>
</div>

@if(session('status'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('status') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('exemplares.index') }}">
            <div class="row g-2">
                <div class="col-md-10">
                    <input
                        type="text"
                        name="busca"
                        class="form-control"
                        placeholder="Pesquisar por código ou título do livro..."
                        value="{{ $busca }}"
                    >
                </div>

                <div class="col-md-2 d-grid">
                    <button type="submit" class="btn btn-outline-primary">
                        Pesquisar
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Livro</th>
                        <th>Autor</th>
                        <th>Status</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($exemplares as $exemplar)
                        <tr>
                            <td class="fw-semibold">
                                {{ $exemplar->codigo }}
                            </td>

                            <td>{{ $exemplar->livro->titulo }}</td>

                            <td>{{ $exemplar->livro->autor }}</td>

                            <td>
                                @if($exemplar->ativo)
                                    <span class="badge bg-success">Ativo</span>
                                @else
                                    <span class="badge bg-secondary">Inativo</span>
                                @endif
                            </td>

                            <td class="text-end">
                                <a
                                    href="{{ route('exemplares.edit', $exemplar) }}"
                                    class="btn btn-sm btn-outline-primary"
                                >
                                    Editar
                                </a>

                                <form
                                    action="{{ route('exemplares.alternar-status', $exemplar) }}"
                                    method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Deseja alterar o status deste exemplar?')"
                                >
                                    @csrf

                                    <button
                                        type="submit"
                                        class="btn btn-sm {{ $exemplar->ativo ? 'btn-outline-danger' : 'btn-outline-success' }}"
                                    >
                                        {{ $exemplar->ativo ? 'Inativar' : 'Ativar' }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-secondary py-4">
                                Nenhum exemplar encontrado.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $exemplares->links() }}
        </div>
    </div>
</div>

@endsection
