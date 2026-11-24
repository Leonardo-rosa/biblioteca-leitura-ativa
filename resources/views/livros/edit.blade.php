
@extends('layouts.app')

@section('title', 'Editar livro')

@section('content')

<div class="mb-4">
    <h2 class="fw-bold">Editar livro</h2>
    <p class="text-secondary">
        Atualize as informações do livro cadastrado.
    </p>
</div>

<div class="card">
    <div class="card-body p-4">

        <form action="{{ route('livros.update', $livro) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row g-3">

                <div class="col-md-8">
                    <label class="form-label">Título *</label>
                    <input
                        type="text"
                        name="titulo"
                        class="form-control @error('titulo') is-invalid @enderror"
                        value="{{ old('titulo', $livro->titulo) }}"
                        required
                    >
                    @error('titulo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">ISBN</label>
                    <input
                        type="text"
                        name="isbn"
                        class="form-control @error('isbn') is-invalid @enderror"
                        value="{{ old('isbn', $livro->isbn) }}"
                    >
                    @error('isbn')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Autor *</label>
                    <input
                        type="text"
                        name="autor"
                        class="form-control @error('autor') is-invalid @enderror"
                        value="{{ old('autor', $livro->autor) }}"
                        required
                    >
                    @error('autor')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Gênero *</label>
                    <input
                        type="text"
                        name="genero"
                        class="form-control @error('genero') is-invalid @enderror"
                        value="{{ old('genero', $livro->genero) }}"
                        required
                    >
                    @error('genero')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Editora</label>
                    <input
                        type="text"
                        name="editora"
                        class="form-control"
                        value="{{ old('editora', $livro->editora) }}"
                    >
                </div>

            </div>

            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    Salvar alterações
                </button>

                <a href="{{ route('livros.index') }}" class="btn btn-outline-secondary">
                    Cancelar
                </a>
            </div>

        </form>

    </div>
</div>

@endsection
