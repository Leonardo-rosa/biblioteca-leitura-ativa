<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerificarPerfil
{
    public function handle(
        Request $request,
        Closure $next,
        string ...$perfis
    ): Response {
        $usuario = $request->user();

        if (!$usuario || !$usuario->ativo) {
            abort(403, 'Você não tem permissão para acessar esta página.');
        }

        if (!in_array($usuario->perfil, $perfis, true)) {
            abort(403, 'Você não tem permissão para acessar esta página.');
        }

        return $next($request);
    }
}
