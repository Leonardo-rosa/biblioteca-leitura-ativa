
@extends('layouts.app')

@section('title', 'Livros')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1">Livros</h2>
        <p class="text-secondary mb-0">
            Gerencie o acervo da biblioteca.
        </p>
    </div>

    <a href="{{ route('livros.create') }}" class="btn btn-primary">
        + Novo livro
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
        <form method="GET" action="{{ route('livros.index') }}">
            <div class="row g-2">
                <div class="col-md-10">
                    <input
                        type="text"
                        name="busca"
                        class="form-control"
                        placeholder="Pesquisar por título, autor ou gênero..."
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
                        <th>Título</th>
                        <th>Autor</th>
                        <th>Gênero</th>
                        <th>Editora</th>
                        <th>Status</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($livros as $livro)
                        <tr>
                            <td class="fw-semibold">
                                {{ $livro->titulo }}
                            </td>

                            <td>{{ $livro->autor }}</td>

                            <td>{{ $livro->genero }}</td>

                            <td>{{ $livro->editora ?? '-' }}</td>

                            <td>
                                @if($livro->ativo)
                                    <span class="badge bg-success">Ativo</span>
                                @else
                                    <span class="badge bg-secondary">Inativo</span>
                                @endif
                            </td>

                            <td class="text-end">
                                <a
                                    href="{{ route('livros.edit', $livro) }}"
                                    class="btn btn-sm btn-outline-primary"
                                >
                                    Editar
                                </a>

                                <form
                                    action="{{ route('livros.alternar-status', $livro) }}"
                                    method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Deseja alterar o status deste livro?')"
                                >
                                    @csrf

                                    <button
                                        type="submit"
                                        class="btn btn-sm {{ $livro->ativo ? 'btn-outline-danger' : 'btn-outline-success' }}"
                                    >
                                        {{ $livro->ativo ? 'Inativar' : 'Ativar' }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-secondary py-4">
                                Nenhum livro encontrado.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $livros->links() }}
        </div>

    </div>
</div>

@endsection
