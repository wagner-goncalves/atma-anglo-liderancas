<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use DB;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use JsValidator;
use Illuminate\Validation\Rule;
use App\Models\Empresa;

use App\Notifications\UsuarioCadastrado;

class UserController extends Controller
{
    use \App\Traits\HandleSqlError;

    protected $validationRules = [
        'name' => 'required',
        'password' => 'required|same:confirm-password',
        'roles' => 'required',
        'empresa_id' => 'required|integer',
        'cpf' => 'required|unique:users,cpf|regex:/(^\d{3}\x2E\d{3}\x2E\d{3}\x2D\d{2}$)/',
        'email' => 'required|email|unique:users,email',
    ];

    public function __construct()
    {
        $this->middleware('role:Admin|Gestor');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        $filter = $request->query('filter');
        $empresa_id = $request->query('empresa_id');
        $users = User::sortable()->orderBy('created_at', 'desc');

        if(intval($empresa_id) > 0) $users->where('empresa_id', '=', intval($empresa_id));

        //Somente empresas que o gestor pode ver
        if ($user->hasRole('Gestor'))  $users->where('empresa_id', '=', $user->empresa_id);

        if (!empty($filter)) {
            $users->where(function ($query) use ($filter) {
                $query->where('name', 'like', '%' . $filter . '%')
                    ->orWhere('cpf', '=', $filter);
            });
        }

        $users = $users->paginate(10);

        $empresas = $this->empresasUsuario();

        return view('users.index', compact('users', 'empresas', 'empresa_id', 'filter'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    private function empresasUsuario()
    {
        $user = auth()->user();
        if ($user->hasRole('Admin')) {
            return \App\Models\Empresa::all()->sortBy("nome");
        } elseif ($user->hasRole('Gestor') && intval($user->empresa_id) > 0) {
            return \App\Models\Empresa::where("id", "=", $user->empresa_id)->get();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = [];
        $loggedUser = auth()->user();
        if ($loggedUser->hasRole('Admin')){
            unset($this->validationRules["empresa_id"]);
            $roles = Role::pluck('name', 'name')->all();
        }elseif ($loggedUser->hasRole('Gestor')){
            $roles = Role::whereNotIn('name', ["Admin"])->pluck('name', 'name')->all();
        }

        $empresas = $this->empresasUsuario();
        unset($this->validationRules["password"]);
        
        $this->validationRules["email"] = "required|email";
        $this->validationRules["cpf"] = "required|regex:/(^\d{3}\x2E\d{3}\x2E\d{3}\x2D\d{2}$)/";
        $validator = JsValidator::make($this->validationRules);

        $user = new User();
        $userRole = [];
        
        return view('users.edit', compact('user', 'roles', 'userRole', 'empresas'))->with([
            'validator' => $validator,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $loggedUser = auth()->user();
        $this->validationRules['email'] = Rule::unique('users');
        $this->validationRules['cpf'] = Rule::unique('users', 'cpf');
        unset($this->validationRules["password"]);

        if ($loggedUser->hasRole('Admin')){
            unset($this->validationRules["empresa_id"]);
        }

        $this->validate($request, $this->validationRules);

        //Cria usuário com senha padrão
        $input = $request->all();
        $input['password'] = Hash::make(substr(str_replace(".", "", $input["cpf"]), 0, 6)); //Hash::make($input['password']);
        $input['password_changet_at'] = null;
        $user = User::create($input);

        //Cria papéis
        $roles = $request->input('roles');
        if (!$user->hasRole('Admin')) unset($roles["Admin"]);
        //Todos os usuários também são alunos, por padrão.
        if(!in_array("Aluno", $roles)) $roles[] = "Aluno";
        $user->assignRole($roles);

        //Matricula usuário automaticamente em todos os cursos da empresa
        if(intval($input["empresa_id"]) > 0){
            $this->matriculaUsuario($user->id, $input["empresa_id"]);
        }
       
        //Envia notificação
        $user->notify(new UsuarioCadastrado($user, Empresa::find($input["empresa_id"]), $roles));


        return redirect()->route('users.index')
            ->with('success', 'Usuário criado com sucesso.');
    }

    private function matriculaUsuario($user_id, $empresa_id = null){

        $empresas = intval($empresa_id) > 0 ? \App\Models\Empresa::where("id", "=", $empresa_id)->get() : \App\Models\Empresa::all();
        if($empresas){
            foreach($empresas as $empresa){
                $planos = $empresa->planos();
                if($planos){
                    foreach($planos->get() as $plano){
                        $cursos = $plano->cursos();
                        if($cursos){
                            foreach($cursos->get() as $curso){
                                $data_conclusao = new \Carbon\Carbon();
                                $tempo_acesso = $curso->pivot->tempo_acesso;
                                $data_limite = $data_conclusao->addDays(intval($tempo_acesso))->toDateTimeString();
                                $matricula = \App\Models\Matricula::updateOrCreate(
                                    [
                                        "user_id" => $user_id, 
                                        "plano_id" => $plano->id, 
                                        "curso_id" => $curso->id, 
                                        "empresa_id" => $empresa->id
                                    ],
                                    [
                                        "tempo_acesso" => $tempo_acesso, 
                                        "data_limite" => $data_limite
                                    ]
                                );
                            }
                        }
                    }
                }
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $loggedUser = auth()->user();
        $user = User::find($id);

        if ($loggedUser->hasRole('Gestor') && !$loggedUser->hasRole('Admin') && $user->empresa_id != $loggedUser->empresa_id){
            return redirect()->route('users.index')->with('error', 'Operação inválida.');
            //\App::abort(403, 'Ação não autorizada.');
        }

        $roles = [];
        if ($loggedUser->hasRole('Admin')) $roles = Role::pluck('name', 'name')->all();
        elseif ($loggedUser->hasRole('Gestor')){
            $roles = Role::whereNotIn('name', ["Admin"])->pluck('name', 'name')->all();
        } 

        $userRole = $user->roles->pluck('name', 'name')->all();
        $empresas = $this->empresasUsuario();
        if($loggedUser->hasRole('Admin') ){
            unset($this->validationRules['empresa_id']);
        }
        unset($this->validationRules["password"]);
        $this->validationRules["email"] = "required|email";
        $this->validationRules["cpf"] = "required|regex:/(^\d{3}\x2E\d{3}\x2E\d{3}\x2D\d{2}$)/";        
        $validator = JsValidator::make($this->validationRules);

        return view('users.edit', compact('user', 'roles', 'empresas', 'userRole'))->with([
            'validator' => $validator,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $loggedUser = auth()->user();
        $input = $request->all();

        if ($loggedUser->hasRole('Gestor') && !$loggedUser->hasRole('Admin')  && $input["empresa_id"] != $loggedUser->empresa_id){
            return redirect()->route('users.index')
            ->with('error', 'Operação inválida.');
        }

        if($loggedUser->hasRole('Admin') ){
            unset($this->validationRules['empresa_id']);
        }

        $this->validationRules['email'] = Rule::unique('users')->ignore($id);
        $this->validationRules['cpf'] = Rule::unique('users', 'cpf')->ignore($id); //'required|email|unique:users,email';
        unset($this->validationRules['password']);
        $this->validate($request, $this->validationRules);

        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
            $input['password_changed_at'] = "2000-01-01 00:00:01";
        } else {
            $input = Arr::except($input, array('password'));
        }

        
        $user = User::find($id);
        
        $user->update($input);
        DB::table('model_has_roles')->where('model_id', $id)->delete();

        if (!$user->hasRole('Admin')) unset($request->input('roles')["Admin"]);
        $user->assignRole($request->input('roles'));

        return redirect()->route('users.index')
            ->with('success', 'Atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $loggedUser = auth()->user();
        $user = User::find($id);

        if ($loggedUser->hasRole('Gestor')  && !$loggedUser->hasRole('Admin') && $user->empresa_id != $loggedUser->empresa_id){
            return redirect()->route('users.index')
            ->with('error', 'Operação inválida.');
        }

        DB::beginTransaction();
        try{

            if($user->hasRole('Admin')){
                $user->feedbacks()->delete();
            }

            $user->delete();
            DB::commit();
        } catch(\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            $mensagem = $this->formatSqlError($e->getPrevious()->getErrorCode(), $e->getMessage());
            return redirect()->route('users.index')->with('error', sprintf('Não foi possível excluir o registro. <br />%s', $mensagem));
        }

        return redirect()->route('users.index')
            ->with('success', 'Usuário excluído com sucesso.');
    }

    public function resetPassword($id){

    }
}
