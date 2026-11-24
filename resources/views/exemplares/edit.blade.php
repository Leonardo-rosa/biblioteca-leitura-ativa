
@extends('layouts.app')

@section('title', 'Editar exemplar')

@section('content')

<div class="mb-4">
    <h2 class="fw-bold">Editar exemplar</h2>
    <p class="text-secondary">
        Atualize o livro vinculado ou o código do exemplar.
    </p>
</div>

<div class="card">
    <div class="card-body p-4">

        <form action="{{ route('exemplares.update', $exemplar) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row g-3">
                <div class="col-md-8">
                    <label class="form-label">Livro *</label>

                    <select
                        name="livro_id"
                        class="form-select @error('livro_id') is-invalid @enderror"
                        required
                    >
                        @foreach($livros as $livro)
                            <option
                                value="{{ $livro->id }}"
                                @selected(old('livro_id', $exemplar->livro_id) == $livro->id)
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
                        value="{{ old('codigo', $exemplar->codigo) }}"
                        required
                    >

                    @error('codigo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    Salvar alterações
                </button>

                <a href="{{ route('exemplares.index') }}" class="btn btn-outline-secondary">
                    Cancelar
                </a>
            </div>

        </form>

    </div>
</div>

@endsection
