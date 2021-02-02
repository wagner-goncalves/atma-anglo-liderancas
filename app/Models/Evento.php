<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'eventos';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'nome',
                  'descricao',
                  'data_inicio',
                  'data_fim',
                  'link',
                  'imagem',
                  'is_active'
              ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [];
    
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];
    

    /**
     * Set the data_inicio.
     *
     * @param  string  $value
     * @return void
     */
    public function setDataInicioAttribute($value)
    {
        $this->attributes['data_inicio'] = !empty($value) ? \DateTime::createFromFormat('[% date_format %]', $value) : null;
    }

    /**
     * Set the data_fim.
     *
     * @param  string  $value
     * @return void
     */
    public function setDataFimAttribute($value)
    {
        $this->attributes['data_fim'] = !empty($value) ? \DateTime::createFromFormat('[% date_format %]', $value) : null;
    }

    /**
     * Get data_inicio in array format
     *
     * @param  string  $value
     * @return array
     */
    public function getDataInicioAttribute($value)
    {
        return \DateTime::createFromFormat($this->getDateFormat(), $value)->format('d/m/Y');
    }

    /**
     * Get data_fim in array format
     *
     * @param  string  $value
     * @return array
     */
    public function getDataFimAttribute($value)
    {
        return \DateTime::createFromFormat($this->getDateFormat(), $value)->format('d/m/Y');
    }

    /**
     * Get created_at in array format
     *
     * @param  string  $value
     * @return array
     */
    public function getCreatedAtAttribute($value)
    {
        return \DateTime::createFromFormat($this->getDateFormat(), $value)->format('d/m/Y H:i:s');
    }

    /**
     * Get updated_at in array format
     *
     * @param  string  $value
     * @return array
     */
    public function getUpdatedAtAttribute($value)
    {
        return \DateTime::createFromFormat($this->getDateFormat(), $value)->format('d/m/Y H:i:s');
    }

}
