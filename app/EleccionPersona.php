<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EleccionPersona extends Model
{
  public $timestamps = false;

  protected $primaryKey='eleccion_persona_id';

  protected $table = 'eleccion_persona';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      "eleccion_persona_id","eleccion_id","persona_id"
  ];
}
