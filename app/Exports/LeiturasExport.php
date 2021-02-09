<?php

namespace App\Exports;

use App\Performance;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithProperties;

class LeiturasExport implements FromQuery, WithHeadings, WithProperties
{

    use Exportable;

    public function filtro($filter_leituras)
    {
        $this->filter_leituras = $filter_leituras;
        return $this;
    }    

    /**
    * @return \Illuminate\Support\Collection
    */
    public function query()
    {

        $query = \App\Models\Leitura::query()
            ->join("eventos", "eventos.id", "=", "leituras.evento_id")
            ->orderBy("eventos.id")
            ->orderBy("leituras.id");
        $filter =$this->filter_leituras;

        if(strlen(trim($filter)) > 0){
            $query->orWhere('nome', 'like', '%' . $filter . '%')
                ->orWhere('descricao', 'like', '%' . $filter . '%');
        }         

        return $query
        ->selectRaw("eventos.nome as 'evento', 
            leituras.id,
            leituras.evento_id,
            leituras.nome,
            leituras.descricao,
            leituras.arquivo,
            leituras.ordem");
    }

    public function headings() : array
    {
        return [
            'evento',
            'id',
            'evento_id',
            'nome',
            'descricao',
            'arquivo',
            'ordem'
        ];
    } 

    public function properties(): array
    {
        return [
            'creator'        => 'Atma Interativa',
            'lastModifiedBy' => 'Atma Interativa',
            'title'          => 'Relatório de Leituras',
            'description'    => '',
            'subject'        => '',
            'keywords'       => '',
            'category'       => '',
            'manager'        => '',
            'company'        => 'Powered by ATMA INTERATIVA',
        ];
    }    

}
