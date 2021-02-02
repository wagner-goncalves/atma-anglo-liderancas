<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '/materiais/aulas', '/materiais/modulos',
        '/matriculas/planos', '/matriculas/cursos', 
        '/respostas/questionarios', '/respostas/perguntas', 
        '/feedbacks/alunos',
    ];
}
