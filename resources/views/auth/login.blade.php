@extends('layouts.app')

@section('title', 'Acesso ao sistema')

@section('content')
<div class="row justify-content-center align-items-center" style="min-height: 75vh;">
    <div class="col-12 col-sm-10 col-md-7 col-lg-5 col-xl-4">

        <div class="text-center mb-4">
            <h2 class="fw-bold">Biblioteca Leitura Ativa</h2>
            <p class="text-secondary">
                Acesse sua conta para continuar.
            </p>
        </div>

        <div class="card">
            <div class="card-body p-4 p-md-5">

                <h4 class="mb-4">Entrar no sistema</h4>

                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login.autenticar') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">
                            E-mail
                        </label>

                        <input
                            type="email"
                            name="email"
                            id="email"
                            class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email') }}"
                            placeholder="seu@email.com"
                            autocomplete="username"
                            required
                            autofocus
                        >
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">
                            Senha
                        </label>

                        <input
                            type="password"
                            name="password"
                            id="password"
                            class="form-control"
                            placeholder="Digite sua senha"
                            autocomplete="current-password"
                            required
                        >
                    </div>

                    <div class="form-check mb-4">
                        <input
                            type="checkbox"
                            name="remember"
                            id="remember"
                            class="form-check-input"
                            value="1"
                        >

                        <label for="remember" class="form-check-label">
                            Manter conectado
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2">
                        Entrar
                    </button>
                </form>

            </div>
        </div>

        <p class="text-center text-secondary small mt-4">
            O acesso é disponibilizado pelo administrador da biblioteca.
        </p>

    </div>
</div>
@endsection
