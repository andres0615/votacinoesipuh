<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Persona extends Authenticatable
{
  use Notifiable;

  protected $primaryKey='persona_id';

  public $timestamps = false;

  protected $table = 'persona';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      "persona_id","persona_nombre","persona_apellido","persona_foto","persona_codigo_alterno",
      "tipo_persona_id","persona_activa","persona_ingreso",'persona_identificacion',"persona_email"
  ];
}
