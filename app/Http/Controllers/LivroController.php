<?php
namespace App\Http\Controllers;

use App\Models\Livro;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LivroController extends Controller
{
    public function index(Request $request)
    {
        $busca = $request->input('busca');

        $livros = Livro::query()
            ->when($busca, function ($query, $busca) {
                $query->where(function ($q) use ($busca) {
                    $q->where('titulo', 'like', "%{$busca}%")
                        ->orWhere('autor', 'like', "%{$busca}%")
                        ->orWhere('genero', 'like', "%{$busca}%");
                });
            })
            ->orderBy('titulo')
            ->paginate(10)
            ->withQueryString();

        return view('livros.index', compact('livros', 'busca'));
    }

    public function create()
    {
        return view('livros.create');
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'titulo' => ['required', 'string', 'max:255'],
            'autor' => ['required', 'string', 'max:255'],
            'genero' => ['required', 'string', 'max:100'],
            'editora' => ['nullable', 'string', 'max:255'],
            'isbn' => ['nullable', 'string', 'max:20', 'unique:livros,isbn'],
        ], [
            'titulo.required' => 'Informe o título do livro.',
            'autor.required' => 'Informe o autor.',
            'genero.required' => 'Informe o gênero ou categoria.',
            'isbn.unique' => 'Este ISBN já está cadastrado.',
        ]);

        Livro::create($dados);

        return redirect()->route('livros.index')
            ->with('status', 'Livro cadastrado com sucesso!');
    }

    public function edit(Livro $livro)
    {
        return view('livros.edit', compact('livro'));
    }

    public function update(Request $request, Livro $livro)
    {
        $dados = $request->validate([
            'titulo' => ['required', 'string', 'max:255'],
            'autor' => ['required', 'string', 'max:255'],
            'genero' => ['required', 'string', 'max:100'],
            'editora' => ['nullable', 'string', 'max:255'],
            'isbn' => [
                'nullable',
                'string',
                'max:20',
                Rule::unique('livros', 'isbn')->ignore($livro->id),
            ],
        ], [
            'titulo.required' => 'Informe o título do livro.',
            'autor.required' => 'Informe o autor.',
            'genero.required' => 'Informe o gênero ou categoria.',
            'isbn.unique' => 'Este ISBN já está cadastrado em outro livro.',
        ]);

        $livro->update($dados);

        return redirect()->route('livros.index')
            ->with('status', 'Livro atualizado com sucesso!');
    }

    public function alternarStatus(Livro $livro)
    {
        $livro->ativo = !$livro->ativo;
        $livro->save();

        $mensagem = $livro->ativo
            ? 'Livro ativado com sucesso!'
            : 'Livro inativado com sucesso!';

        return back()->with('status', $mensagem);
    }
}
