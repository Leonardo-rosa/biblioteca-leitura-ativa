
@extends('layouts.app')

@section('title', 'Nova leitura')

@section('content')

<div class="mb-4">
    <h2 class="fw-bold">Nova leitura</h2>
    <p class="text-secondary">Adicione um livro à sua lista de leituras.</p>
</div>

<div class="card">
    <div class="card-body p-4">

        @if($livros->isEmpty())
            <div class="alert alert-warning">
                Não existem livros ativos disponíveis no acervo.
            </div>

            <a href="{{ route('painel') }}" class="btn btn-secondary">
                Voltar
            </a>
        @else
            <form action="{{ route('leituras.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Livro *</label>

                    <select name="livro_id" class="form-select" required>
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
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Status *</label>

                    <select name="status" class="form-select" required>
                        <option value="quero_ler" @selected(old('status', 'quero_ler') === 'quero_ler')>Quero ler</option>
                        <option value="lendo" @selected(old('status') === 'lendo')>Lendo</option>
                        <option value="lido" @selected(old('status') === 'lido')>Lido</option>
                        <option value="abandonado" @selected(old('status') === 'abandonado')>Abandonado</option>
                    </select>

                    @error('status')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Data de início</label>
                        <input
                            type="date"
                            name="data_inicio"
                            class="form-control"
                            value="{{ old('data_inicio') }}"
                        >
                        @error('data_inicio')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Data de conclusão</label>
                        <input
                            type="date"
                            name="data_conclusao"
                            class="form-control"
                            value="{{ old('data_conclusao') }}"
                        >
                        @error('data_conclusao')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        Salvar leitura
                    </button>

                    <a href="{{ route('leituras.index') }}" class="btn btn-outline-secondary">
                        Cancelar
                    </a>
                </div>
            </form>
        @endif

    </div>
</div>

@endsection
