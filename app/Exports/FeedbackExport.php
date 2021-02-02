<?php

namespace App\Exports;

use App\Performance;
use App\Models\Feedback;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithProperties;

class FeedbackExport implements FromQuery, WithHeadings, WithProperties
{

    use Exportable;

    public function filtro($empresa_id, $plano_id, $curso_id, $user_id)
    {
        $this->empresa_id = $empresa_id;
        $this->plano_id = $plano_id;
        $this->curso_id = $curso_id;
        $this->user_id = $user_id;
        
        return $this;
    }    

    /**
    * @return \Illuminate\Support\Collection
    */
    public function query()
    {

        $feedbacks = Feedback::sortable()
            ->join("users", "users.id", "=", "feedbacks.user_id")
            ->join("cursos", "cursos.id", "=", "feedbacks.curso_id")
            ->join("respostas", "respostas.id", "=", "feedbacks.resposta_id")
            ->join("perguntas", "perguntas.id", "=", "feedbacks.pergunta_id")
            ->join("questionarios", "questionarios.id", "=", "perguntas.questionario_id")
            ->leftJoin("planos_has_cursos", "planos_has_cursos.curso_id", "=", "cursos.id")
            ->leftJoin("planos", "planos.id", "=", "planos_has_cursos.plano_id")
            ->leftJoin("planos_has_empresas", "planos_has_empresas.plano_id", "=", "planos.id")
            ->leftJoin("empresas", "empresas.id", "=", "planos_has_empresas.empresa_id")
            ->orderBy("users.name", "asc")
            ->orderBy("questionarios.nome", "asc")
            ->orderBy("perguntas.ordem", "asc")
            ->selectRaw("DISTINCT cursos.nome as 'curso', users.name AS 'aluno', users.cpf, users.email, questionarios.nome AS 'questionario', CONCAT(perguntas.ordem, ' - ', perguntas.pergunta) AS pergunta, CONCAT(respostas.ordem, ' - ', respostas.resposta) AS 'resposta', perguntas.questionario_id, perguntas.ordem, respostas.pergunta_id, respostas.ordem")
            ;

        if(intval($this->empresa_id) > 0) $feedbacks->where("empresas.id", "=", $this->empresa_id);
        if(intval($this->plano_id) > 0) $feedbacks->where("planos.id", "=", $this->plano_id);
        if(intval($this->curso_id) > 0) $feedbacks->where("cursos.id", "=", $this->curso_id);
        if(intval($this->user_id) > 0) $feedbacks->where("users.id", "=", $this->user_id);            

        return $feedbacks;
    }

    public function headings() : array
    {

        return [
            'Curso',
            'Aluno',
            'CPF',
            'email',
            'Questionario',
            'Pergunta',
            'Resposta do aluno',
            'questionario_id',
            'Ordem pergunta',
            'pergunta_id',
            'Ordem resposta',

        ];
    } 

    public function properties(): array
    {
        return [
            'creator'        => 'LMS Aldeia Consultoria',
            'lastModifiedBy' => 'LMS Aldeia Consultoria',
            'title'          => 'Relatório de Matrículas',
            'description'    => '',
            'subject'        => '',
            'keywords'       => '',
            'category'       => '',
            'manager'        => '',
            'company'        => 'Powered by ATMA INTERATIVA',
        ];
    }    

}
