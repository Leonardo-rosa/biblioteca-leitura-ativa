# Biblioteca Leitura Ativa

Sistema web de gerenciamento de biblioteca desenvolvido em Laravel, com foco no controle de livros, exemplares, leitores, leituras e empréstimos.

## Sobre o projeto

A Biblioteca Leitura Ativa foi desenvolvida para facilitar a administração de um acervo bibliográfico, permitindo acompanhar a disponibilidade dos exemplares, organizar registros de leitura e controlar empréstimos e devoluções.

O sistema possui controle de acesso por perfil, com funcionalidades específicas para administradores e integrantes.

## Tecnologias utilizadas

- **PHP 8.2+**
- **Laravel 12**
- **MySQL / MariaDB**
- **Bootstrap 5**
- **Blade**
- **Composer**

## Funcionalidades

### Administração

- Dashboard administrativo com indicadores.
- Cadastro, edição e inativação de usuários.
- Controle de perfis: administrador e integrante.
- Cadastro, edição e inativação de livros.
- Cadastro e gerenciamento de exemplares.
- Controle de empréstimos e devoluções.
- Consulta de exemplares disponíveis.

### Integrantes

- Dashboard individual.
- Consulta e gerenciamento dos próprios registros de leitura.
- Registro de livros que deseja ler.
- Acompanhamento de leituras em andamento.
- Registro de livros concluídos.
- Registro de leituras abandonadas.
- Histórico individual de leitura.

### Controle de acervo

- Um livro pode possuir vários exemplares.
- Cada exemplar possui identificação própria.
- Controle de disponibilidade.
- Histórico de empréstimos.
- Prevenção de empréstimos simultâneos do mesmo exemplar.

## Requisitos

- PHP 8.2 ou superior.
- Composer.
- MySQL ou MariaDB.
- Extensões PHP: PDO, PDO MySQL, OpenSSL, Mbstring, Tokenizer, XML, Ctype, Fileinfo e cURL.

## Instalação local

Clone o repositório:

```bash
git clone https://github.com/Leonardo-rosa/biblioteca-leitura-ativa.git
```

Entre na pasta:

```bash
cd biblioteca-leitura-ativa
```

Instale as dependências:

```bash
composer install
```

Crie o arquivo de ambiente:

```bash
cp .env.example .env
```

Gere a chave da aplicação:

```bash
php artisan key:generate
```

Configure no arquivo `.env` os dados de conexão com o banco de dados:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=biblioteca_leitura_ativa
DB_USERNAME=root
DB_PASSWORD=
```

Execute as migrations:

```bash
php artisan migrate
```

Crie o primeiro administrador:

```bash
php artisan app:criar-administrador
```

Inicie o servidor local:

```bash
php artisan serve
```

Acesse:

```text
http://127.0.0.1:8000
```

## Testes

Execute os testes automatizados:

```bash
php artisan test
```

## Segurança

- O arquivo `.env` não deve ser versionado.
- Não compartilhe senhas ou credenciais de produção.
- Utilize `APP_DEBUG=false` em produção.
- Mantenha as dependências atualizadas.
- Utilize HTTPS no ambiente de produção.

## Ambiente de produção

O projeto foi preparado e publicado em hospedagem compartilhada KingHost, utilizando PHP 8.2.

## Estrutura principal

```text
app/
├── Console/
├── Http/
│   ├── Controllers/
│   └── Middleware/
└── Models/

database/
└── migrations/

resources/
└── views/

routes/
└── web.php

tests/
```

## Status do projeto

**MVP funcional**, com autenticação, gerenciamento de usuários, livros, exemplares, leituras e empréstimos.

## Autor

**Leonardo Rosa da Silva**

Desenvolvimento de software — PHP / Laravel

GitHub: [Leonardo-rosa](https://github.com/Leonardo-rosa)
