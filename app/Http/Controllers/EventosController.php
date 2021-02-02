<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Evento;
use Illuminate\Http\Request;
use Exception;

class EventosController extends Controller
{

    /**
     * Display a listing of the eventos.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $eventos = Evento::paginate(25);

        return view('eventos.index', compact('eventos'));
    }

    /**
     * Show the form for creating a new evento.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {
        
        
        return view('eventos.create');
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
            
            $data = $this->getData($request);
            
            Evento::create($data);

            return redirect()->route('eventos.evento.index')
                ->with('success_message', 'Evento was successfully added.');
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
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
        

        return view('eventos.edit', compact('evento'));
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
            $evento->update($data);

            return redirect()->route('eventos.evento.index')
                ->with('success_message', 'Evento was successfully updated.');
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }        
    }

    /**
     * Remove the specified evento from the storage.
     *
     * @param int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $evento = Evento::findOrFail($id);
            $evento->delete();

            return redirect()->route('eventos.evento.index')
                ->with('success_message', 'Evento was successfully deleted.');
        } catch (Exception $exception) {

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
        $rules = [
            'nome' => 'required|string|min:1|max:255',
            'descricao' => 'string|min:1|max:1000',
            'data_inicio' => 'required|date_format:d/m/Y|nullable',
            'data_fim' => 'required|date_format:d/m/Y|nullable',
            'link' => 'string|min:1|nullable',
            'imagem' => 'numeric|nullable',
            'is_active' => 'boolean|nullable', 
        ];

        
        $data = $request->validate($rules);


        $data['is_active'] = $request->has('is_active');


        return $data;
    }

}
