<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Evento;
use Illuminate\Http\Request;
use Exception;

use Illuminate\Support\Facades\Storage;
use JsValidator;
use Carbon\Carbon;
use App\Exports\EventosExport;

class EventosController extends Controller
{

    use \App\Traits\HandleSqlError;

    private $rules = [
        'nome' => 'required|string|min:1|max:255',
        'descricao' => 'max:1000|required',
        'data_inicio' => 'required|date_format:d/m/Y|nullable',
        'data_fim' => 'required|date_format:d/m/Y|nullable',
        'link' => 'string|min:1|nullable',
        'imagem' => 'file|mimes:pdf|nullable',
        'is_active' => 'boolean|nullable', 
    ];

    /**
     * Display a listing of the eventos.
     *
     * @return Illuminate\View\View
     */
    public function index(Request $request)
    {

        $eventos = Evento::sortable()->orderBy('id', 'desc');

        $filter_eventos = $request->query('filter_eventos');
        if (!empty($filter)) {
            $eventos = $eventos->where('eventos.nome', 'like', '%'.$filter_eventos.'%');
        }

        $eventos = $eventos->paginate(10, ["*"], 'page_eventos');

        return view('eventos.index', compact('eventos', 'filter_eventos'));
    }

    /**
     * Show the form for creating a new evento.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {
        $evento = new Evento();
        return view('eventos.edit', compact('evento'))->with([
            'validator' => JsValidator::make($this->rules),
        ]);

    }

    /**
     * Store a new evento in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        try {
            $this->validate($request, $this->rules);
            
            $requestData = $request->all();

            //Tratamento do arquivo
            if(!empty($request->file('imagem'))){
                $requestData["imagem"] = $request->file('imagem')->store('eventos');
            }
            
            $evento = Evento::create($requestData);

            if(isset($requestData["save-continue"])){
                return redirect()->route('eventos.evento.edit', ["evento" => $evento->id])->with('success_message', 'Evento criado com sucesso.');
            } 

            //return redirect()->route('eventos.evento.index')->with('success_message', 'Evento criado com sucesso.');
        } catch (Exception $exception) {
            if(env('APP_DEBUG')) throw $exception;
            return back()->withInput()->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }

    /**
     * Display the specified evento.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show($id)
    {
        $evento = Evento::findOrFail($id);

        return view('eventos.show', compact('evento'));
    }

    /**
     * Show the form for editing the specified evento.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function edit($id)
    {
        $evento = Evento::findOrFail($id);
        $leituras = \App\Models\Leitura::where("evento_id", "=", $id)->orderBy("id", "desc")->paginate(10, ["*"], 'page_leituras');
        
        return view('eventos.edit', compact('evento', 'leituras'))->with([
            'validator' => JsValidator::make($this->rules),
        ]);
    }

    /**
     * Update the specified evento in the storage.
     *
     * @param int $id
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        try {
            
            $data = $this->getData($request);
            
            $evento = Evento::findOrFail($id);
            
            if(isset($data["imagem"])){
                $caminho = $request->file('imagem')->store('eventos');
                $data["imagem"] = $caminho;
            }else{
                $data["imagem"] = $evento->imagem;
            }            

            $evento->update($data);

            if(isset($requestData["save-continue"])){
                return redirect()->route('eventos.evento.edit', ["evento" => $evento->id])->with('success_message', 'Evento criado com sucesso.');
            }             

            return redirect()->route('eventos.evento.index')->with('success_message', 'Evento was successfully updated.');
        } catch (Exception $exception) {
            if(env('APP_DEBUG')) throw $exception;
            return back()->withInput()->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }        
    }

    /**
     * Remove the specified evento from the storage.
     *
     * @param int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id, Request $request)
    {
        try {
            $requestData = $request->all();
            $evento = Evento::findOrFail($id);
            Storage::delete($evento->imagem);
            $evento->delete();

            return redirect()->route('eventos.evento.index', ['page_eventos' => isset($requestData["page_eventos"]) ? intval($requestData["page_eventos"]) : 1])->with('success_message', 'Evento excluído com sucesso.');
        }catch(\Illuminate\Database\QueryException $e) {
            $mensagem = $this->formatSqlError($e->getPrevious()->getErrorCode(), $e->getMessage());
            return redirect()->route('eventos.evento.index', ['page_eventos' => isset($requestData["page_eventos"]) ? intval($requestData["page_eventos"]) : 1])->with('error', sprintf('Não foi possível excluir o registro. <br />%s', $mensagem));
        } catch (Exception $exception) {
            if(env('APP_DEBUG')) throw $exception;
            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }

    
    /**
     * Get the request's data from the request.
     *
     * @param Illuminate\Http\Request\Request $request 
     * @return array
     */
    protected function getData(Request $request)
    {
        $data = $request->validate($this->rules);
        $data['is_active'] = $request->has('is_active');
        return $data;
    }

    public function download($id){
        $evento = Evento::findOrFail($id);
        return Storage::download($evento->imagem, ($evento->nome . "." . pathinfo($evento->imagem, PATHINFO_EXTENSION)));
    }    

    public function exportar(Request $request) 
    {
        $requestData = $request->all();
        $fileName = sprintf("Eventos %s.xlsx", date("d-m-Y"));
        return (new EventosExport)->filtro($requestData["filter_eventos"])->download($fileName);
    }    

}
