<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UsuarioController extends Controller
{
    /**
     * Lista os usuários cadastrados.
     */
    public function index()
    {
        $usuarios = User::orderBy('name')
            ->paginate(10);

        return view('usuarios.index', compact('usuarios'));
    }

    /**
     * Exibe o formulário de cadastro.
     */
    public function create()
    {
        return view('usuarios.create');
    }

    /**
     * Cadastra um novo usuário.
     */
    public function store(Request $request)
    {
        $dados = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
            ],
            'perfil' => [
                'required',
                Rule::in(['integrante', 'administrador']),
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],
        ], [
            'name.required' => 'Informe o nome do usuário.',
            'email.required' => 'Informe o e-mail.',
            'email.email' => 'Informe um e-mail válido.',
            'email.unique' => 'Este e-mail já está cadastrado.',
            'perfil.required' => 'Selecione o perfil do usuário.',
            'perfil.in' => 'O perfil selecionado é inválido.',
            'password.required' => 'Informe uma senha.',
            'password.min' => 'A senha precisa ter pelo menos 8 caracteres.',
            'password.confirmed' => 'A confirmação da senha não corresponde.',
        ]);

        User::create([
            'name' => $dados['name'],
            'email' => $dados['email'],
            'password' => $dados['password'],
            'perfil' => $dados['perfil'],
            'ativo' => true,
        ]);

        return redirect()
            ->route('usuarios.index')
            ->with('status', 'Usuário cadastrado com sucesso!');
    }

    /**
     * Exibe o formulário de edição.
     */
    public function edit(User $usuario)
    {
        return view('usuarios.edit', compact('usuario'));
    }

    /**
     * Atualiza os dados do usuário.
     */
    public function update(Request $request, User $usuario)
    {
        $dados = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($usuario->id),
            ],
            'perfil' => [
                'required',
                Rule::in(['integrante', 'administrador']),
            ],
            'password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
            ],
        ], [
            'name.required' => 'Informe o nome do usuário.',
            'email.required' => 'Informe o e-mail.',
            'email.email' => 'Informe um e-mail válido.',
            'email.unique' => 'Este e-mail já está cadastrado.',
            'perfil.required' => 'Selecione o perfil do usuário.',
            'perfil.in' => 'O perfil selecionado é inválido.',
            'password.min' => 'A senha precisa ter pelo menos 8 caracteres.',
            'password.confirmed' => 'A confirmação da senha não corresponde.',
        ]);

        // Impede que o administrador altere o próprio perfil.
        if (
            auth()->id() === $usuario->id &&
            $usuario->perfil !== $dados['perfil']
        ) {
            return back()
                ->withInput()
                ->with('erro', 'Você não pode alterar seu próprio perfil.');
        }

        // Impede a remoção do último administrador ativo.
        if (
            $usuario->ativo &&
            $usuario->perfil === 'administrador' &&
            $dados['perfil'] === 'integrante'
        ) {
            $administradoresAtivos = User::where(
                'perfil',
                'administrador'
            )
                ->where('ativo', true)
                ->count();

            if ($administradoresAtivos <= 1) {
                return back()
                    ->withInput()
                    ->with(
                        'erro',
                        'É necessário manter pelo menos um administrador ativo.'
                    );
            }
        }

        $usuario->name = $dados['name'];
        $usuario->email = $dados['email'];
        $usuario->perfil = $dados['perfil'];

        // Só altera a senha se um novo valor for informado.
        if (!empty($dados['password'])) {
            $usuario->password = $dados['password'];
        }

        $usuario->save();

        return redirect()
            ->route('usuarios.index')
            ->with('status', 'Usuário atualizado com sucesso!');
    }

    /**
     * Ativa ou inativa um usuário.
     */
    public function alternarStatus(User $usuario)
    {
        $administrador = auth()->user();

        // Impede que o administrador inative a própria conta.
        if ($usuario->id === $administrador->id) {
            return back()->with(
                'erro',
                'Você não pode inativar sua própria conta.'
            );
        }

        // Impede inativar o último administrador ativo.
        if (
            $usuario->ativo &&
            $usuario->perfil === 'administrador'
        ) {
            $administradoresAtivos = User::where(
                'perfil',
                'administrador'
            )
                ->where('ativo', true)
                ->count();

            if ($administradoresAtivos <= 1) {
                return back()->with(
                    'erro',
                    'Não é possível inativar o último administrador ativo.'
                );
            }
        }

        $usuario->ativo = !$usuario->ativo;
        $usuario->save();

        $mensagem = $usuario->ativo
            ? 'Usuário ativado com sucesso!'
            : 'Usuário inativado com sucesso!';

        return back()->with('status', $mensagem);
    }
}
