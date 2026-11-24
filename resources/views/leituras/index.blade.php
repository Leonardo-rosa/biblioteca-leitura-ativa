
@extends('layouts.app')

@section('title', 'Minhas leituras')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold">Minhas leituras</h2>
        <p class="text-secondary mb-0">Acompanhe seu histórico de leitura.</p>
    </div>

    <a href="{{ route('leituras.create') }}" class="btn btn-primary">
        + Nova leitura
    </a>
</div>

@if(session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
@endif

<div class="card">
    <div class="card-body table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>Livro</th>
                    <th>Status</th>
                    <th>Início</th>
                    <th>Conclusão</th>
                    <th>Atualizar</th>
                </tr>
            </thead>

            <tbody>
                @forelse($leituras as $leitura)
                    <tr>
                        <td>
                            <strong>{{ $leitura->livro->titulo }}</strong>
                            <br>
                            <small class="text-secondary">
                                {{ $leitura->livro->autor }}
                            </small>
                        </td>

                        <td>
                            @switch($leitura->status)
                                @case('quero_ler')
                                    <span class="badge bg-secondary">Quero ler</span>
                                    @break
                                @case('lendo')
                                    <span class="badge bg-primary">Lendo</span>
                                    @break
                                @case('lido')
                                    <span class="badge bg-success">Lido</span>
                                    @break
                                @case('abandonado')
                                    <span class="badge bg-danger">Abandonado</span>
                                    @break
                            @endswitch
                        </td>

                        <td>
                            {{ $leitura->data_inicio?->format('d/m/Y') ?? '-' }}
                        </td>

                        <td>
                            {{ $leitura->data_conclusao?->format('d/m/Y') ?? '-' }}
                        </td>

                        <td>
                            <form
                                action="{{ route('leituras.update', $leitura) }}"
                                method="POST"
                                class="d-flex flex-column gap-2"
                            >
                                @csrf
                                @method('PUT')

                                <select name="status" class="form-select form-select-sm">
                                    <option value="quero_ler" @selected($leitura->status === 'quero_ler')>Quero ler</option>
                                    <option value="lendo" @selected($leitura->status === 'lendo')>Lendo</option>
                                    <option value="lido" @selected($leitura->status === 'lido')>Lido</option>
                                    <option value="abandonado" @selected($leitura->status === 'abandonado')>Abandonado</option>
                                </select>

                                <input
                                    type="date"
                                    name="data_inicio"
                                    class="form-control form-control-sm"
                                    value="{{ $leitura->data_inicio?->format('Y-m-d') }}"
                                >

                                <input
                                    type="date"
                                    name="data_conclusao"
                                    class="form-control form-control-sm"
                                    value="{{ $leitura->data_conclusao?->format('Y-m-d') }}"
                                    placeholder="Conclusão"
                                >

                                <button type="submit" class="btn btn-sm btn-primary">
                                    Salvar
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-secondary py-4">
                            Você ainda não cadastrou leituras.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
