<?php

namespace App\Http\Controllers;

use App\Models\Emprestimo;
use App\Models\Exemplar;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmprestimoController extends Controller
{
    public function index()
    {
        $emprestimos = Emprestimo::with([
            'exemplar.livro',
            'usuario'
        ])->latest()->get();

        return view('emprestimos.index', compact('emprestimos'));
    }

    public function create()
    {
        $exemplares = Exemplar::with('livro')
            ->where('ativo', true)
            ->whereHas('livro', function ($query) {
                $query->where('ativo', true);
            })
            ->whereDoesntHave('emprestimos', function ($query) {
                $query->whereNull('data_devolucao');
            })
            ->get();

        $usuarios = User::where('ativo', true)
            ->where('perfil', 'integrante')
            ->orderBy('name')
            ->get();

        return view('emprestimos.create', compact(
            'exemplares',
            'usuarios'
        ));
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'exemplar_id' => ['required', 'exists:exemplars,id'],
            'user_id' => ['required', 'exists:users,id'],
            'data_prevista_devolucao' => ['required', 'date', 'after_or_equal:today'],
        ]);

        DB::transaction(function () use ($dados) {

            $exemplar = Exemplar::whereKey($dados['exemplar_id'])
                ->lockForUpdate()
                ->firstOrFail();

            if (!$exemplar->ativo || !$exemplar->livro->ativo) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'exemplar_id' => 'Este exemplar ou livro está inativo.',
                ]);
            }

            $emprestimoAberto = Emprestimo::where(
                'exemplar_id',
                $exemplar->id
            )->whereNull('data_devolucao')->exists();

            if ($emprestimoAberto) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'exemplar_id' => 'Este exemplar já possui um empréstimo em aberto.',
                ]);
            }

            $usuario = User::whereKey($dados['user_id'])
                ->where('ativo', true)
                ->where('perfil', 'integrante')
                ->first();

            if (!$usuario) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'user_id' => 'Selecione um integrante ativo.',
                ]);
            }

            Emprestimo::create([
                'exemplar_id' => $exemplar->id,
                'user_id' => $usuario->id,
                'data_emprestimo' => now()->toDateString(),
                'data_prevista_devolucao' => $dados['data_prevista_devolucao'],
            ]);
        });

        return redirect()
            ->route('emprestimos.index')
            ->with('sucesso', 'Empréstimo registrado com sucesso!');
    }

    public function devolver(Emprestimo $emprestimo)
    {
        if ($emprestimo->data_devolucao) {
            return back()->with('erro', 'Este empréstimo já foi devolvido.');
        }

        $emprestimo->update([
            'data_devolucao' => now()->toDateString(),
        ]);

        return redirect()
            ->route('emprestimos.index')
            ->with('sucesso', 'Devolução registrada com sucesso!');
    }
}
