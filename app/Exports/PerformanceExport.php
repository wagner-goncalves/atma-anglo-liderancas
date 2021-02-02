<?php

namespace App\Exports;

use App\Performance;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithProperties;

class PerformanceExport implements FromQuery, WithHeadings, WithProperties
{

    use Exportable;

    public function filtro($empresa_id, $plano_id, $curso_id, $chave)
    {
        $this->empresa_id = $empresa_id;
        $this->plano_id = $plano_id;
        $this->curso_id = $curso_id;
        $this->chave = $chave;
        
        return $this;
    }    

    /**
    * @return \Illuminate\Support\Collection
    */
    public function query()
    {

        $query = \App\Models\Performance::query();
        $filter = $this->chave;
        if(intval($this->empresa_id) > 0) $query->where("empresa_id", "=", $this->empresa_id);
        if(intval($this->plano_id) > 0) $query->where("plano_id", "=", $this->plano_id);
        if(intval($this->curso_id) > 0) $query->where("curso_id", "=", $this->curso_id);

        $user = auth()->user();

        if($user->hasRole('Admin')){

        }elseif($user->hasRole('Gestor')){
            $query->where("empresa_id", "=", $user->empresa_id);
        }      
        
        if(intval($this->chave) != ""){
            $query->where(function ($query) use ($filter) {
                $query->orWhere('CPF', '=', $filter)
                    ->orWhere('E-mail', 'like', '%' . $filter . '%');
            });
        } 

        return $query->orderBy("Aluno")->select("*");
    }

    public function headings() : array
    {
        return [
            'Aluno',
            'E-mail',
            'CPF',
            'Telefone',
            'Empresa',
            'Plano',
            'Curso',
            'Aulas do curso',
            'Aulas assistidas',
            'Posts realizados',
            'Feedback realizado',
            'Certificado emitido',
            'Data limite curso',
            'Data conclusão',  
            'user_id',
            'empresa_id',
            'plano_id',
            'curso_id'
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
