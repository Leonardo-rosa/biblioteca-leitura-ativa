<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'Informe seu e-mail.',
            'email.email' => 'Informe um endereço de e-mail válido.',
            'password.required' => 'Informe sua senha.',
        ]);

        $chave = Str::lower($request->input('email'))
            . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($chave, 5)) {
            throw ValidationException::withMessages([
                'email' => 'Muitas tentativas de acesso. Aguarde um minuto.',
            ]);
        }

        $credenciais = $request->only('email', 'password');
        $credenciais['ativo'] = true;

        if (!Auth::attempt($credenciais, $request->boolean('remember'))) {
            RateLimiter::hit($chave, 60);

            throw ValidationException::withMessages([
                'email' => 'E-mail ou senha inválidos, ou usuário inativo.',
            ]);
        }

        RateLimiter::clear($chave);

        $request->session()->regenerate();

        return redirect()->intended(route('painel'));
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('status', 'Você saiu do sistema com segurança.');
    }
}
