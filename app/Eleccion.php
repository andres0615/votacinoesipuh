<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Eleccion extends Model
{
  public $timestamps = false;

  protected $primaryKey='eleccion_id';

  protected $table = 'eleccion';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      "eleccion_id","eleccion_nombre", "eleccion_activa"
  ];
}
