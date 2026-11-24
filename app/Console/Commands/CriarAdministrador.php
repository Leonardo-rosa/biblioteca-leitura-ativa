<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CriarAdministrador extends Command
{
    protected $signature = 'app:criar-administrador';

    protected $description = 'Cadastra o primeiro administrador da biblioteca';

    public function handle(): int
    {
        if (User::where('perfil', 'administrador')->exists()) {
            $this->error('Já existe um administrador cadastrado.');
            return self::FAILURE;
        }

        $nome = $this->ask('Nome do administrador');
        $email = trim($this->ask('E-mail do administrador'));

        if (empty($nome) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->error('Informe um nome e um e-mail válido.');
            return self::FAILURE;
        }

        if (User::where('email', $email)->exists()) {
            $this->error('Este e-mail já está cadastrado.');
            return self::FAILURE;
        }

        $senha = $this->secret('Digite a senha');
        $confirmacao = $this->secret('Confirme a senha');

        if (empty($senha) || $senha !== $confirmacao) {
            $this->error('As senhas estão vazias ou não correspondem.');
            return self::FAILURE;
        }

        if (strlen($senha) < 8) {
            $this->error('A senha precisa ter pelo menos 8 caracteres.');
            return self::FAILURE;
        }

        User::create([
            'name' => $nome,
            'email' => $email,
            'password' => $senha,
            'perfil' => 'administrador',
            'ativo' => true,
        ]);

        $this->newLine();
        $this->info('Administrador cadastrado com sucesso!');
        $this->line('E-mail: ' . $email);

        return self::SUCCESS;
    }
}
