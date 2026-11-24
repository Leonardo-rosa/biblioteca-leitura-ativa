
@extends('layouts.app')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Empréstimos</h2>

        <a href="{{ route('emprestimos.create') }}" class="btn btn-primary">
            Novo empréstimo
        </a>
    </div>

    @if(session('sucesso'))
        <div class="alert alert-success">{{ session('sucesso') }}</div>
    @endif

    @if(session('erro'))
        <div class="alert alert-danger">{{ session('erro') }}</div>
    @endif

    <div class="card">
        <div class="card-body table-responsive">

            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>Livro</th>
                        <th>Exemplar</th>
                        <th>Integrante</th>
                        <th>Empréstimo</th>
                        <th>Previsão</th>
                        <th>Devolução</th>
                        <th>Status</th>
                        <th>Ação</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($emprestimos as $emprestimo)
                        <tr>
                            <td>{{ $emprestimo->exemplar->livro->titulo }}</td>
                            <td>{{ $emprestimo->exemplar->codigo }}</td>
                            <td>{{ $emprestimo->usuario->name }}</td>

                            <td>
                                {{ $emprestimo->data_emprestimo->format('d/m/Y') }}
                            </td>

                            <td>
                                {{ $emprestimo->data_prevista_devolucao->format('d/m/Y') }}
                            </td>

                            <td>
                                {{ $emprestimo->data_devolucao
                                    ? $emprestimo->data_devolucao->format('d/m/Y')
                                    : '-' }}
                            </td>

                            <td>
                                @if($emprestimo->data_devolucao)
                                    <span class="badge bg-success">Devolvido</span>
                                @else
                                    <span class="badge bg-warning text-dark">Em aberto</span>
                                @endif
                            </td>

                            <td>
                                @if(!$emprestimo->data_devolucao)
                                    <form
                                        action="{{ route('emprestimos.devolver', $emprestimo) }}"
                                        method="POST"
                                        onsubmit="return confirm('Confirmar a devolução deste exemplar?')"
                                    >
                                        @csrf

                                        <button class="btn btn-sm btn-success">
                                            Devolver
                                        </button>
                                    </form>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">
                                Nenhum empréstimo cadastrado.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>

</div>
@endsection
