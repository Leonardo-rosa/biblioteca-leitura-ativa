<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function test_a_pagina_inicial_redireciona_para_login(): void
    {
        $response = $this->get('/');

        $response->assertRedirect('/login');
    }
}