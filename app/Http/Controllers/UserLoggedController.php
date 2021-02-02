<?php
    
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class UserLoggedController extends Controller
{

    public function __construct()
    {
        $this->middleware('role:Admin|Aluno|Gestor');
    }

    public function show()
    {
        $user = User::find(Auth::id());
        return view('users.edit-logged',compact('user'));
    }      

    public function edit()
    {
        $user = User::find(Auth::id());
        return view('users.edit-logged',compact('user'));
    }    
    
    public function index(Request $request)
    {
        $user = User::find(Auth::id());
        return view('users.edit-logged',compact('user'));
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.Auth::id(),
            'password' => 'same:confirm-password',
        ]);
    
        $input = $request->all();
        if(!empty($input['password'])){ 
            $input['password'] = Hash::make($input['password']);
            $input['password_changed_at'] = date("Y-m-d H:i:s");
        }else{
            $input = Arr::except($input,array('password'));    
        }
    
        $user = User::find(Auth::id());
        $user->update($input);

        //return view('users.edit-logged',compact('user'))->with('success','Dados atualizados com sucesso.');
    
        return redirect()->route('userslogged.index')
                        ->with('success','Dados atualizados com sucesso.');
    }    
}