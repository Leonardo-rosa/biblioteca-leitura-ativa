<?php

namespace App\Http\Controllers;

use App\Models\Exemplar;
use App\Models\Livro;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ExemplarController extends Controller
{
    public function index(Request $request)
    {
        $busca = $request->input('busca');

        $exemplares = Exemplar::with('livro')
            ->when($busca, function ($query, $busca) {
                $query->where('codigo', 'like', "%{$busca}%")
                    ->orWhereHas('livro', function ($q) use ($busca) {
                        $q->where('titulo', 'like', "%{$busca}%");
                    });
            })
            ->orderBy('codigo')
            ->paginate(10)
            ->withQueryString();

        return view('exemplares.index', compact('exemplares', 'busca'));
    }

    public function create()
    {
        $livros = Livro::where('ativo', true)
            ->orderBy('titulo')
            ->get();

        return view('exemplares.create', compact('livros'));
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'livro_id' => [
                'required',
                'exists:livros,id',
            ],
            'codigo' => [
                'required',
                'string',
                'max:50',
                'unique:exemplars,codigo',
            ],
        ], [
            'livro_id.required' => 'Selecione um livro.',
            'livro_id.exists' => 'O livro selecionado não existe.',
            'codigo.required' => 'Informe o código do exemplar.',
            'codigo.unique' => 'Este código já está cadastrado.',
        ]);

        Exemplar::create($dados);

        return redirect()->route('exemplares.index')
            ->with('status', 'Exemplar cadastrado com sucesso!');
    }

    public function edit(Exemplar $exemplar)
    {
        $livros = Livro::where('ativo', true)
            ->orWhere('id', $exemplar->livro_id)
            ->orderBy('titulo')
            ->get();

        return view('exemplares.edit', compact('exemplar', 'livros'));
    }

    public function update(Request $request, Exemplar $exemplar)
    {
        $dados = $request->validate([
            'livro_id' => [
                'required',
                'exists:livros,id',
            ],
            'codigo' => [
                'required',
                'string',
                'max:50',
                Rule::unique('exemplars', 'codigo')->ignore($exemplar->id),
            ],
        ], [
            'livro_id.required' => 'Selecione um livro.',
            'livro_id.exists' => 'O livro selecionado não existe.',
            'codigo.required' => 'Informe o código do exemplar.',
            'codigo.unique' => 'Este código já está cadastrado em outro exemplar.',
        ]);

        $exemplar->update($dados);

        return redirect()->route('exemplares.index')
            ->with('status', 'Exemplar atualizado com sucesso!');
    }

    public function alternarStatus(Exemplar $exemplar)
    {
        $exemplar->ativo = !$exemplar->ativo;
        $exemplar->save();

        $mensagem = $exemplar->ativo
            ? 'Exemplar ativado com sucesso!'
            : 'Exemplar inativado com sucesso!';

        return back()->with('status', $mensagem);
    }
}
