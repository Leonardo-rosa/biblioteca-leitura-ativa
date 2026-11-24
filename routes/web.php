
<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\LivroController;
use App\Http\Controllers\ExemplarController;
use App\Http\Controllers\LeituraController;
use App\Http\Controllers\EmprestimoController;

use App\Models\Livro;
use App\Models\Exemplar;
use App\Models\Emprestimo;
use App\Models\Leitura;


Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('painel')
        : redirect()->route('login');
});


// Autenticação
Route::middleware('guest')->group(function () {

    Route::get('/login', [LoginController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [LoginController::class, 'login'])
        ->middleware('throttle:10,1')
        ->name('login.autenticar');

});


Route::middleware('auth')->group(function () {

    // Painel principal
    Route::get('/painel', function () {

        $usuario = auth()->user();

        if ($usuario->isAdministrador()) {
            return redirect()->route('painel.administrador');
        }

        return redirect()->route('painel.integrante');

    })->name('painel');


    // Leituras pessoais
    Route::resource('leituras', LeituraController::class)
        ->only(['index', 'create', 'store', 'update']);


    // Dashboard do administrador
    Route::get('/painel/administrador', function () {

        $totalLivros = Livro::where('ativo', true)->count();

        $exemplaresDisponiveis = Exemplar::where('ativo', true)
            ->whereHas('livro', function ($query) {
                $query->where('ativo', true);
            })
            ->whereDoesntHave('emprestimos', function ($query) {
                $query->whereNull('data_devolucao');
            })
            ->count();

        $emprestimosAbertos = Emprestimo::whereNull('data_devolucao')
            ->count();

        $leiturasConcluidas = Leitura::where('status', 'lido')
            ->count();

        $leiturasUltimosTresMeses = Leitura::where(
            'created_at',
            '>=',
            now()->subMonths(3)
        )->count();

        return view('dashboard.administrador', compact(
            'totalLivros',
            'exemplaresDisponiveis',
            'emprestimosAbertos',
            'leiturasConcluidas',
            'leiturasUltimosTresMeses'
        ));

    })
        ->middleware('perfil:administrador')
        ->name('painel.administrador');


    // Dashboard do integrante
    Route::get('/painel/integrante', function () {

        $usuarioId = auth()->id();

        $livrosLidos = Leitura::where('user_id', $usuarioId)
            ->where('status', 'lido')
            ->count();

        $livrosEmAndamento = Leitura::where('user_id', $usuarioId)
            ->where('status', 'lendo')
            ->count();

        $livrosQueroLer = Leitura::where('user_id', $usuarioId)
            ->where('status', 'quero_ler')
            ->count();

        return view('dashboard.integrante', compact(
            'livrosLidos',
            'livrosEmAndamento',
            'livrosQueroLer'
        ));

    })
        ->middleware('perfil:integrante')
        ->name('painel.integrante');


    // Rotas exclusivas do administrador
    Route::middleware('perfil:administrador')->group(function () {

        // Empréstimos
        Route::get('/emprestimos', [EmprestimoController::class, 'index'])
            ->name('emprestimos.index');

        Route::get('/emprestimos/create', [EmprestimoController::class, 'create'])
            ->name('emprestimos.create');

        Route::post('/emprestimos', [EmprestimoController::class, 'store'])
            ->name('emprestimos.store');

        Route::post('/emprestimos/{emprestimo}/devolver', [EmprestimoController::class, 'devolver'])
            ->name('emprestimos.devolver');


        // Usuários
        Route::resource('usuarios', UsuarioController::class)
            ->except(['show', 'destroy']);

        Route::post(
            '/usuarios/{usuario}/alternar-status',
            [UsuarioController::class, 'alternarStatus']
        )->name('usuarios.alternar-status');


        // Livros
        Route::resource('livros', LivroController::class)
            ->except(['show', 'destroy']);

        Route::post(
            '/livros/{livro}/alternar-status',
            [LivroController::class, 'alternarStatus']
        )->name('livros.alternar-status');


        // Exemplares
        Route::resource('exemplares', ExemplarController::class)
            ->parameters(['exemplares' => 'exemplar'])
            ->except(['show', 'destroy']);

        Route::post(
            '/exemplares/{exemplar}/alternar-status',
            [ExemplarController::class, 'alternarStatus']
        )->name('exemplares.alternar-status');

    });


    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])
        ->name('logout');

});
