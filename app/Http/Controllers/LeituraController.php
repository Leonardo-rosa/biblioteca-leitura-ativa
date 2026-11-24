<?php

namespace App\Http\Controllers;

use App\Models\Leitura;
use App\Models\Livro;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LeituraController extends Controller
{
    public function index()
    {
        $leituras = Leitura::with('livro')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('leituras.index', compact('leituras'));
    }

    public function create()
    {
        $livros = Livro::where('ativo', true)
            ->orderBy('titulo')
            ->get();

        return view('leituras.create', compact('livros'));
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'livro_id' => [
                'required',
                'exists:livros,id',
                Rule::unique('leituras', 'livro_id')
                    ->where('user_id', auth()->id()),
            ],
            'status' => [
                'required',
                Rule::in(['quero_ler', 'lendo', 'lido', 'abandonado']),
            ],
            'data_inicio' => ['nullable', 'date'],
            'data_conclusao' => ['nullable', 'date', 'after_or_equal:data_inicio'],
        ], [
            'livro_id.unique' => 'Você já possui uma leitura cadastrada para este livro.',
        ]);

        if ($dados['status'] === 'lido' && empty($dados['data_conclusao'])) {
            return back()
                ->withErrors(['data_conclusao' => 'Informe a data de conclusão.'])
                ->withInput();
        }

        $dados['user_id'] = auth()->id();

        Leitura::create($dados);

        return redirect()->route('leituras.index')
            ->with('status', 'Leitura cadastrada com sucesso!');
    }

    public function update(Request $request, Leitura $leitura)
    {
        abort_unless($leitura->user_id === auth()->id(), 403);

        $dados = $request->validate([
            'status' => [
                'required',
                Rule::in(['quero_ler', 'lendo', 'lido', 'abandonado']),
            ],
            'data_inicio' => ['nullable', 'date'],
            'data_conclusao' => ['nullable', 'date', 'after_or_equal:data_inicio'],
        ]);

        if ($dados['status'] === 'lido' && empty($dados['data_conclusao'])) {
            return back()
                ->withErrors(['data_conclusao' => 'Informe a data de conclusão.'])
                ->withInput();
        }

        $leitura->update($dados);

        return redirect()->route('leituras.index')
            ->with('status', 'Leitura atualizada com sucesso!');
    }
}
