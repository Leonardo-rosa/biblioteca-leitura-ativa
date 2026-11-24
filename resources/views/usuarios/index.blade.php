@extends('layouts.app')

@section('content')
<div class="container py-4">

    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <h2 class="fw-bold mb-1">Usuários</h2>
            <p class="text-muted mb-0">Gerencie os integrantes da biblioteca.</p>
        </div>

        <a href="{{ route('usuarios.create') }}" class="btn btn-primary">
            + Novo integrante
        </a>
    </div>

    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    @if(session('erro'))
        <div class="alert alert-danger">{{ session('erro') }}</div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-3">Nome</th>
                            <th>E-mail</th>
                            <th>Perfil</th>
                            <th>Status</th>
                            <th class="text-end px-3">Ações</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($usuarios as $usuario)
                            <tr>
                                <td class="px-3 fw-semibold">
                                    {{ $usuario->name }}
                                </td>

                                <td>{{ $usuario->email }}</td>

                                <td>
                                    {{ $usuario->perfil === 'administrador' ? 'Administrador' : 'Integrante' }}
                                </td>

                                <td>
                                    @if($usuario->ativo)
                                        <span class="badge text-bg-success">Ativo</span>
                                    @else
                                        <span class="badge text-bg-secondary">Inativo</span>
                                    @endif
                                </td>

                                <td class="text-end px-3">
                                    <div class="d-inline-flex gap-2">
                                        <a href="{{ route('usuarios.edit', $usuario) }}"
                                           class="btn btn-sm btn-outline-primary">
                                            Editar
                                        </a>

                                        @if(auth()->id() !== $usuario->id)
                                            <form action="{{ route('usuarios.alternar-status', $usuario) }}"
                                                  method="POST">
                                                @csrf

                                                <button type="submit"
                                                        class="btn btn-sm {{ $usuario->ativo ? 'btn-outline-danger' : 'btn-outline-success' }}"
                                                        onclick="return confirm('Deseja realmente alterar o status deste usuário?')">
                                                    {{ $usuario->ativo ? 'Inativar' : 'Ativar' }}
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    Nenhum usuário cadastrado.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-3">
        {{ $usuarios->links() }}
    </div>

</div>
@endsection
