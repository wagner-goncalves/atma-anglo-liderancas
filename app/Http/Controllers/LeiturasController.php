<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Evento;
use App\Models\Leitura;
use Illuminate\Http\Request;
use Exception;
use JsValidator;
use App\Exports\LeiturasExport;

class LeiturasController extends Controller
{

    private $rules = [
        'evento_id' => 'required',
        'nome' => 'string|min:1|max:255|required',
        'descricao' => 'string|min:1|max:1000|nullable',
        'arquivo' => ['file','required'],
        'ordem' => 'numeric|required', 
    ];

    /**
     * Display a listing of the leituras.
     *
     * @return Illuminate\View\View
     */
    public function index(Request $request)
    {
        $leituras = Leitura::sortable()->orderBy('id', 'desc');

        $evento_id = $request->query('evento_id');
        $filter_leituras = $request->query('filter_leituras');

        if (!empty($filter_leituras)) {
            $leituras->where('leituras.nome', 'like', '%'.$filter_leituras.'%');
        }

        $leituras = $leituras->paginate(10);

        if(intval($evento_id) > 0) return view('leituras.grid', compact('evento_id', 'leituras', 'filter_leituras'));
        else return view('leituras.index', compact('leituras', 'filter_leituras'));
    }

    /**
     * Show the form for creating a new leitura.
     *
     * @return Illuminate\View\View
     */
    public function create(Request $request)
    {
        $leitura = new Leitura();

        //Mestre
        $evento_id = $request->query('evento_id');
        $evento = null;
        $eventos = [];

        if(intval($evento_id) > 0) $evento = Evento::findOrFail($evento_id);
        else $eventos = Evento::orderBy('nome', 'asc')->get();

        return view('leituras.edit', compact('leitura', 'evento', 'eventos'))->with([
            'validator' => JsValidator::make($this->rules),
        ]);
    }

    /**
     * Store a new leitura in the storage.
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
            if(!empty($request->file('arquivo'))){
                $requestData["arquivo"] = $request->file('arquivo')->store('leituras');
            }
            
            $leitura = Leitura::create($requestData);

            return $this->resolveRedirect($requestData, $leitura)->with('success_message', 'Leitura criada com sucesso.');           

        } catch (Exception $exception) {
            if(env('APP_DEBUG')) throw $exception;
            return back()->withInput()->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }

    private function resolveRedirect($requestData, $leitura){
        if(isset($requestData["mestre"])){
            $page = isset($requestData["page_leituras"]) ? intval($requestData["page_leituras"]) : 1;
            if(isset($requestData["save-continue"])) return redirect()->route('leituras.leitura.edit', ["leitura" => $leitura->id, 'evento_id' => $leitura->evento_id, 'page_leituras' => $page]);
            return redirect()->route($requestData["mestre"], ["evento" => $requestData["evento_id"], "leitura_id" => $leitura->id, 'page_leituras' => $page ]);
        }
        if(isset($requestData["save-continue"])) return redirect()->route('leituras.leitura.edit', ["leitura" => $leitura->id]);        
        return redirect()->route('leituras.leitura.index');       
    }

    /**
     * Display the specified leitura.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show($id)
    {
        $leitura = Leitura::with('evento')->findOrFail($id);

        return view('leituras.show', compact('leitura'));
    }

    /**
     * Show the form for editing the specified leitura.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function edit($id, Request $request)
    {
        unset($this->rules["arquivo"]);
        $leitura = Leitura::findOrFail($id);

        //Mestre
        $evento_id = $request->query('evento_id');
        $evento = null;
        $eventos = [];

        if(intval($evento_id) > 0) $evento = Evento::findOrFail($evento_id);
        else $eventos = Evento::orderBy('nome', 'asc')->get();

        return view('leituras.edit', compact('leitura', 'evento', 'eventos'))->with([
            'validator' => JsValidator::make($this->rules),
        ]);
    }

    /**
     * Update the specified leitura in the storage.
     *
     * @param int $id
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        try {
            
            unset($this->rules["arquivo"]);
            $this->validate($request, $this->rules);
            
            $requestData = $request->all();
            $leitura = Leitura::findOrFail($id);

            if(isset($requestData->arquivo)){
                $requestData["arquivo"] = $requestData->file('arquivo')->store('leituras');
            }else{
                $requestData["arquivo"] = $leitura->arquivo;
            }            
            
            $leitura->update($requestData);

            return $this->resolveRedirect($requestData, $leitura)->with('success_message', 'Leitura atualizada com sucesso.');   

        } catch (Exception $exception) {
            if(env('APP_DEBUG')) throw $exception;
            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }        
    }

    /**
     * Remove the specified leitura from the storage.
     *
     * @param int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id, Request $request)
    {
        try {
            $leitura = Leitura::findOrFail($id);
            $leitura->delete();
            return $this->resolveRedirect($request->all(), $leitura)->with('success_message', "Leitura excluída com sucesso."); ;
        }catch (Exception $exception) {
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

        if ($request->has('custom_delete_arquivo')) {
            $data['arquivo'] = null;
        }
        if ($request->hasFile('arquivo')) {
            $data['arquivo'] = $this->moveFile($request->file('arquivo'));
        }



        return $data;
    }
  
    /**
     * Moves the attached file to the server.
     *
     * @param Symfony\Component\HttpFoundation\File\UploadedFile $file
     *
     * @return string
     */
    protected function moveFile($file)
    {
        if (!$file->isValid()) {
            return '';
        }
        
        $path = config('laravel-code-generator.files_upload_path', 'uploads');
        $saved = $file->store('public/' . $path, config('filesystems.default'));

        return substr($saved, 7);
    }

    public function download($id){
        $material = Evento::findOrFail($id);
        return Storage::download($material->arquivo, ($material->nome . "." . pathinfo($material->arquivo, PATHINFO_EXTENSION)));
    }

    public function exportar(Request $request) 
    {
        $requestData = $request->all();
        $fileName = sprintf("Leituras %s.xlsx", date("d-m-Y"));
        return (new LeiturasExport)->filtro($requestData["filter_leituras"])->download($fileName);
    }   
}
