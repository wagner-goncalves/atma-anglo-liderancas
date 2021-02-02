<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

use Kyslik\ColumnSortable\Sortable;
  

/**
 * @property integer $id
 * @property integer $empresa_id
 * @property string $name
 * @property string $email
 * @property string $email_verified_at
 * @property string $phone
 * @property string $password
 * @property string $remember_token
 * @property string $created_at
 * @property string $updated_at
 * @property boolean $is_active
 * @property Empresa $empresa
 * @property Acesso[] $acessos
 * @property Feedback[] $feedbacks
 * @property Matricula[] $matriculas
 * @property Post[] $posts
 * @property Visualizaco[] $visualizacoes
 */
class User extends Authenticatable
{

    use HasFactory, Notifiable, HasRoles, Sortable;

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['empresa_id', 'name', 'email', 'cpf', 'email_verified_at', 'phone', 'password', 'remember_token', 'created_at', 'updated_at', 'is_active', 'password_changed_at'];


        /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
  
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public $sortable = ['name'];    


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function empresa()
    {
        return $this->belongsTo('App\Models\Empresa');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function acessos()
    {
        return $this->hasMany('App\Models\Acesso');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function feedbacks()
    {
        return $this->hasMany('App\Models\Feedback', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function matriculas()
    {
        return $this->hasMany('App\Models\Matricula');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts()
    {
        return $this->hasMany('App\Models\Post');
    }

    public function countPosts()
    {
        return $this->hasMany('App\Models\Post')->count();
    }    

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function visualizacoes()
    {
        return $this->hasMany('App\Models\Visualizaco');
    }
}
