
@extends('layouts.app')

@section('title', 'Minha biblioteca')

@section('content')

<div class="container-fluid py-3">

    {{-- Cabeçalho --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">

        <div>
            <span class="text-primary fw-semibold small text-uppercase">
                Biblioteca Leitura Ativa
            </span>

            <h2 class="fw-bold mt-1 mb-1">
                Minha biblioteca
            </h2>

            <p class="text-secondary mb-0">
                Acompanhe sua jornada e descubra seu próximo livro.
            </p>
        </div>

        <div class="text-secondary mt-3 mt-md-0">
            Olá, <strong>{{ auth()->user()->name }}</strong>
        </div>

    </div>


    {{-- Indicadores --}}
    <div class="mb-3">
        <h5 class="fw-bold mb-1">Minha jornada de leitura</h5>

        <p class="text-secondary small">
            Acompanhe o andamento das suas leituras.
        </p>
    </div>


    <div class="row g-3 mb-4">

        {{-- Livros concluídos --}}
        <div class="col-sm-6 col-xl-4">

            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">

                    <div class="d-flex justify-content-between align-items-center mb-3">

                        <span class="text-secondary small fw-semibold">
                            LIVROS CONCLUÍDOS
                        </span>

                        <span class="badge bg-success-subtle text-success rounded-pill">
                            Finalizados
                        </span>

                    </div>

                    <h2 class="fw-bold mb-1">
                        {{ $livrosLidos }}
                    </h2>

                    <p class="text-secondary small mb-0">
                        Livros que você já terminou.
                    </p>

                </div>
            </div>

        </div>


        {{-- Em andamento --}}
        <div class="col-sm-6 col-xl-4">

            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">

                    <div class="d-flex justify-content-between align-items-center mb-3">

                        <span class="text-secondary small fw-semibold">
                            EM ANDAMENTO
                        </span>

                        <span class="badge bg-primary-subtle text-primary rounded-pill">
                            Lendo
                        </span>

                    </div>

                    <h2 class="fw-bold mb-1">
                        {{ $livrosEmAndamento }}
                    </h2>

                    <p class="text-secondary small mb-0">
                        Livros que você está lendo atualmente.
                    </p>

                </div>
            </div>

        </div>


        {{-- Quero ler --}}
        <div class="col-sm-6 col-xl-4">

            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">

                    <div class="d-flex justify-content-between align-items-center mb-3">

                        <span class="text-secondary small fw-semibold">
                            QUERO LER
                        </span>

                        <span class="badge bg-warning-subtle text-warning rounded-pill">
                            Próximas leituras
                        </span>

                    </div>

                    <h2 class="fw-bold mb-1">
                        {{ $livrosQueroLer }}
                    </h2>

                    <p class="text-secondary small mb-0">
                        Livros que estão na sua lista.
                    </p>

                </div>
            </div>

        </div>

    </div>


    {{-- Área de acesso --}}
    <div class="mb-3">

        <h5 class="fw-bold mb-1">Minha biblioteca</h5>

        <p class="text-secondary small">
            Gerencie suas atividades de leitura.
        </p>

    </div>


    <div class="row g-3">

        <div class="col-md-6">

            <a href="{{ route('leituras.index') }}"
               class="card border-0 shadow-sm h-100 text-decoration-none text-dark">

                <div class="card-body p-4">

                    <div class="mb-3">
                        <span class="badge bg-primary-subtle text-primary p-2">
                            Minhas leituras
                        </span>
                    </div>

                    <h5 class="fw-bold">
                        Gerenciar minhas leituras
                    </h5>

                    <p class="text-secondary small mb-3">
                        Consulte seus livros, atualize o status de leitura
                        e registre suas conclusões.
                    </p>

                    <span class="text-primary fw-semibold small">
                        Acessar minhas leituras →
                    </span>

                </div>

            </a>

        </div>


        <div class="col-md-6">

            <a href="{{ route('leituras.create') }}"
               class="card border-0 shadow-sm h-100 text-decoration-none text-dark">

                <div class="card-body p-4">

                    <div class="mb-3">
                        <span class="badge bg-success-subtle text-success p-2">
                            Nova leitura
                        </span>
                    </div>

                    <h5 class="fw-bold">
                        Adicionar livro à minha lista
                    </h5>

                    <p class="text-secondary small mb-3">
                        Escolha um livro do acervo e adicione à sua
                        lista de leituras.
                    </p>

                    <span class="text-success fw-semibold small">
                        Adicionar livro →
                    </span>

                </div>

            </a>

        </div>

    </div>

</div>

@endsection
