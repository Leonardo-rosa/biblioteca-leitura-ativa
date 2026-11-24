
@extends('layouts.app')

@section('title', 'Painel do administrador')

@section('content')

<div class="container-fluid py-3">

    {{-- Cabeçalho --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <div>
            <span class="text-primary fw-semibold small text-uppercase">
                Biblioteca Leitura Ativa
            </span>
            <h2 class="fw-bold mt-1 mb-1">Painel administrativo</h2>
            <p class="text-secondary mb-0">
                Visão geral e gerenciamento da biblioteca.
            </p>
        </div>

        <div class="text-secondary mt-3 mt-md-0">
            Olá, <strong>{{ auth()->user()->name }}</strong>
        </div>
    </div>

    {{-- Indicadores principais --}}
    <div class="mb-3">
        <h5 class="fw-bold mb-1">Visão geral</h5>
        <p class="text-secondary small">
            Indicadores atuais da biblioteca.
        </p>
    </div>

    <div class="row g-3 mb-4">

        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-secondary small fw-semibold">
                            LIVROS ATIVOS
                        </span>
                        <span class="badge bg-primary-subtle text-primary rounded-pill">
                            Acervo
                        </span>
                    </div>

                    <h2 class="fw-bold mb-1">{{ $totalLivros }}</h2>
                    <p class="text-secondary small mb-0">
                        Livros cadastrados e ativos
                    </p>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-secondary small fw-semibold">
                            DISPONÍVEIS
                        </span>
                        <span class="badge bg-success-subtle text-success rounded-pill">
                            Exemplares
                        </span>
                    </div>

                    <h2 class="fw-bold mb-1">{{ $exemplaresDisponiveis }}</h2>
                    <p class="text-secondary small mb-0">
                        Exemplares disponíveis para empréstimo
                    </p>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-secondary small fw-semibold">
                            EM ABERTO
                        </span>
                        <span class="badge bg-warning-subtle text-warning rounded-pill">
                            Empréstimos
                        </span>
                    </div>

                    <h2 class="fw-bold mb-1">{{ $emprestimosAbertos }}</h2>
                    <p class="text-secondary small mb-0">
                        Empréstimos aguardando devolução
                    </p>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-secondary small fw-semibold">
                            CONCLUÍDAS
                        </span>
                        <span class="badge bg-info-subtle text-info rounded-pill">
                            Leituras
                        </span>
                    </div>

                    <h2 class="fw-bold mb-1">{{ $leiturasConcluidas }}</h2>
                    <p class="text-secondary small mb-0">
                        Leituras marcadas como concluídas
                    </p>
                </div>
            </div>
        </div>

    </div>

    {{-- Atividade de leitura --}}
    <div class="row g-3 mb-4">

        <div class="col-lg-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">

                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                        <div>
                            <h5 class="fw-bold mb-1">Atividade de leitura</h5>
                            <p class="text-secondary small mb-0">
                                Registros de leitura realizados nos últimos três meses.
                            </p>
                        </div>

                        <div class="text-primary text-end mt-3 mt-md-0">
                            <h2 class="fw-bold mb-0">
                                {{ $leiturasUltimosTresMeses }}
                            </h2>
                            <small class="text-secondary">Novos registros</small>
                        </div>
                    </div>

                    <hr class="my-3">

                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-primary rounded-pill">
                            Últimos 3 meses
                        </span>
                        <span class="text-secondary small">
                            Considerando a data de cadastro das leituras.
                        </span>
                    </div>

                </div>
            </div>
        </div>

    </div>

    {{-- Gerenciamento --}}
    <div class="mb-3">
        <h5 class="fw-bold mb-1">Gerenciamento</h5>
        <p class="text-secondary small">
            Acesse os módulos para administrar a biblioteca.
        </p>
    </div>

    <div class="row g-3">

        <div class="col-md-6 col-xl-3">
            <a href="{{ route('usuarios.index') }}"
               class="card border-0 shadow-sm h-100 text-decoration-none text-dark">
                <div class="card-body p-4">
                    <div class="mb-3">
                        <span class="badge bg-primary-subtle text-primary p-2">
                            Usuários
                        </span>
                    </div>
                    <h5 class="fw-bold">Gerenciar usuários</h5>
                    <p class="text-secondary small mb-0">
                        Cadastre, edite e gerencie os integrantes da biblioteca.
                    </p>
                </div>
            </a>
        </div>

        <div class="col-md-6 col-xl-3">
            <a href="{{ route('livros.index') }}"
               class="card border-0 shadow-sm h-100 text-decoration-none text-dark">
                <div class="card-body p-4">
                    <div class="mb-3">
                        <span class="badge bg-primary-subtle text-primary p-2">
                            Acervo
                        </span>
                    </div>
                    <h5 class="fw-bold">Gerenciar livros</h5>
                    <p class="text-secondary small mb-0">
                        Cadastre e atualize os livros disponíveis no acervo.
                    </p>
                </div>
            </a>
        </div>

        <div class="col-md-6 col-xl-3">
            <a href="{{ route('exemplares.index') }}"
               class="card border-0 shadow-sm h-100 text-decoration-none text-dark">
                <div class="card-body p-4">
                    <div class="mb-3">
                        <span class="badge bg-success-subtle text-success p-2">
                            Exemplares
                        </span>
                    </div>
                    <h5 class="fw-bold">Gerenciar exemplares</h5>
                    <p class="text-secondary small mb-0">
                        Controle os exemplares físicos cadastrados.
                    </p>
                </div>
            </a>
        </div>

        <div class="col-md-6 col-xl-3">
            <a href="{{ route('emprestimos.index') }}"
               class="card border-0 shadow-sm h-100 text-decoration-none text-dark">
                <div class="card-body p-4">
                    <div class="mb-3">
                        <span class="badge bg-warning-subtle text-warning p-2">
                            Circulação
                        </span>
                    </div>
                    <h5 class="fw-bold">Empréstimos</h5>
                    <p class="text-secondary small mb-0">
                        Registre empréstimos e controle as devoluções.
                    </p>
                </div>
            </a>
        </div>

    </div>

</div>

@endsection
