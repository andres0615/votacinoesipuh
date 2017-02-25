<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Votacion extends Model
{
public $timestamps = false;

  protected $primaryKey='votacion_id';

  protected $table = 'votacion';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      "votacion_id","persona_id", "eleccion_id","candidato_id"
  ];
}
