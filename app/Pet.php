<?php

namespace App;

use App\BaseModel;
use App\User;

use Illuminate\Database\Eloquent\Model;

class Pet extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'pets';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'type', 'age'];

    /**
    * Retorna o projeto de um projeto
    */
    public function owner()
    {
        return $this->belongsTo(User::class);
    }
}
