
@extends('layouts.app')

@section('title', 'Cadastrar exemplar')

@section('content')

<div class="mb-4">
    <h2 class="fw-bold">Cadastrar exemplar</h2>
    <p class="text-secondary">
        Vincule um exemplar a um livro do acervo.
    </p>
</div>

<div class="card">
    <div class="card-body p-4">

        @if($livros->isEmpty())
            <div class="alert alert-warning">
                Não existem livros ativos cadastrados.
                Cadastre ou ative um livro antes de adicionar exemplares.
            </div>

            <a href="{{ route('livros.index') }}" class="btn btn-outline-primary">
                Ir para livros
            </a>
        @else
            <form action="{{ route('exemplares.store') }}" method="POST">
                @csrf

                <div class="row g-3">
                    <div class="col-md-8">
                        <label class="form-label">Livro *</label>

                        <select
                            name="livro_id"
                            class="form-select @error('livro_id') is-invalid @enderror"
                            required
                        >
                            <option value="">Selecione um livro</option>

                            @foreach($livros as $livro)
                                <option
                                    value="{{ $livro->id }}"
                                    @selected(old('livro_id') == $livro->id)
                                >
                                    {{ $livro->titulo }} - {{ $livro->autor }}
                                </option>
                            @endforeach
                        </select>

                        @error('livro_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Código do exemplar *</label>

                        <input
                            type="text"
                            name="codigo"
                            class="form-control @error('codigo') is-invalid @enderror"
                            value="{{ old('codigo') }}"
                            placeholder="Ex.: LIV-001"
                            required
                        >

                        @error('codigo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        Salvar exemplar
                    </button>

                    <a href="{{ route('exemplares.index') }}" class="btn btn-outline-secondary">
                        Cancelar
                    </a>
                </div>
            </form>
        @endif

    </div>
</div>

@endsection
