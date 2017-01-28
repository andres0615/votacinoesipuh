<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoPersona extends Model
{

  public $timestamps = false;

  protected $table = 'tipo_persona';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      "tipo_persona_id","tipo_persona_nombre"
  ];
}
