@extends('layouts.app')

@section('content')
<div class="container py-4">

    <div class="mb-4">
        <a href="{{ route('usuarios.index') }}" class="text-decoration-none">
            ← Voltar para usuários
        </a>
        <h2 class="fw-bold mt-3">Novo integrante</h2>
        <p class="text-muted">Cadastre um novo integrante da biblioteca.</p>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">

            <form action="{{ route('usuarios.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Nome completo</label>
                    <input type="text" name="name"
                           value="{{ old('name') }}"
                           class="form-control @error('name') is-invalid @enderror"
                           required>

                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">E-mail</label>
                    <input type="email" name="email"
                           value="{{ old('email') }}"
                           class="form-control @error('email') is-invalid @enderror"
                           required>

                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Perfil</label>
                    <select name="perfil" class="form-select" required>
                        <option value="integrante" {{ old('perfil', 'integrante') === 'integrante' ? 'selected' : '' }}>
                            Integrante
                        </option>
                        <option value="administrador" {{ old('perfil') === 'administrador' ? 'selected' : '' }}>
                            Administrador
                        </option>
                    </select>
                    @error('perfil')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Senha</label>
                    <input type="password" name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           required minlength="8">

                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label">Confirmar senha</label>
                    <input type="password" name="password_confirmation"
                           class="form-control" required minlength="8">
                </div>

                <button type="submit" class="btn btn-primary">
                    Cadastrar integrante
                </button>

                <a href="{{ route('usuarios.index') }}" class="btn btn-light">
                    Cancelar
                </a>

            </form>

        </div>
    </div>
</div>
@endsection
