<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserLoggedController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AulaController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\CertificadoController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\ModuloController;
use App\Http\Controllers\AulaAdministracaoController;
use App\Http\Controllers\MatriculaController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\PlanoController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\QuestionarioController;
use App\Http\Controllers\PerguntaController;
use App\Http\Controllers\RespostaController;
use App\Http\Controllers\FeedbackAdministracaoController;

use App\Http\Controllers\Auth\ExpiredPasswordController;

use App\Http\Controllers\EventosController;
use App\Http\Controllers\MateriaisController;
use App\Http\Controllers\LeiturasController;
use App\Http\Controllers\ApresentacoesController;
use App\Http\Controllers\VideosController;
use App\Http\Controllers\PostsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    auth()->logout();
    return view('auth.login');
});
  
Auth::routes();

Route::get('mail', function () {
    $matricula = new \App\Models\Matricula();

    $matricula = $matricula->where('curso_id', '=', 1)
        ->where('user_id', '=', 1)
        ->where('empresa_id', '=', 1)
        ->first();

    $user = \App\Models\User::find(1);
    $empresa = \App\Models\Empresa::find(1);
    $curso = \App\Models\Curso::find(1);
    //$user->notify(new \App\Notifications\AlunoCadastrado());

    return (new \App\Notifications\PostCriado(
            $user, 
            $empresa, 
            $curso
            ))->toMail($user);
});
  
Route::group(['middleware' => ['auth']], function() {

    Route::middleware(['password_expired'])->group(function () {
        Route::get('/home', [HomeController::class, 'index'])->name('home');
    });    

    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::get('/primeiro-acesso/{id}', [UserController::class, 'resetPassword'])->name('primeiro.acesso');

    Route::resource('userslogged', UserLoggedController::class);
    Route::resource('products', ProductController::class);

    Route::get('/password/expired', [ExpiredPasswordController::class, 'expired'])->name('password.expired');
    Route::post('/password/post_expired', [ExpiredPasswordController::class, 'postExpired'])->name('password.post_expired');

});

Route::group([
    'prefix' => 'eventos',
], function () {
    Route::get('/', [EventosController::class, 'index'])
         ->name('eventos.evento.index');
    Route::get('/create',[EventosController::class, 'create'])
         ->name('eventos.evento.create');
    Route::get('/show/{evento}',[EventosController::class, 'show'])
         ->name('eventos.evento.show')->where('id', '[0-9]+');
    Route::get('/{evento}/edit',[EventosController::class, 'edit'])
         ->name('eventos.evento.edit')->where('id', '[0-9]+');
    Route::post('/', [EventosController::class, 'store'])
         ->name('eventos.evento.store');
    Route::put('evento/{evento}', [EventosController::class, 'update'])
         ->name('eventos.evento.update')->where('id', '[0-9]+');
    Route::delete('/evento/{evento}',[EventosController::class, 'destroy'])
         ->name('eventos.evento.destroy')->where('id', '[0-9]+');
});
