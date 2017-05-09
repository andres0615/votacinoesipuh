<?php

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

/*Route::get('/', function () {
    //return view('welcome');
    return view('index');
});*/


Route::group(['middleware' => ['auth']], function(){

  Route::get('/auth/showadminvalidation',["as" => "authshowvalidation", "uses" => "CredentialsController@showAdminValidation"]);

  Route::get('/auth/adminvalidation/{opcion}',["as" => "authvalidation", "uses" => "CredentialsController@adminValidation"]);

  Route::group(['middleware' => ['auth.admin.aux']], function(){

    Route::post('/admin/aux/persona/ingreso/proccess', ["as" => "admin.persona.ingreso.proccess", "uses" => "PersonaController@ingreso"]);
    
    Route::get('/admin/persona/identificaciones/{text?}', ["as" => "admin.persona.identificaciones", "uses" => "PersonaController@getIdentificacionesJson"]);

    Route::get('/admin/aux/persona/ingreso',["as" => "admin.persona.ingreso", "uses" => "PersonaController@ingresoForm"]);

    Route::group(['middleware' => ['auth.admin']], function(){

    Route::group(["prefix" => "admin", "as" => "admin."], function(){

      Route::resource('persona', 'PersonaController');

      Route::post('persona/destroyMass', [
          'as' => 'persona.destroyMass',
          'uses' => 'PersonaController@destroyMass'
      ]);

      Route::resource('tipopersona', 'TipoPersonaController');

      Route::post('tipopersona/destroyMass', [
          'as' => 'tipopersona.destroyMass',
          'uses' => 'TipoPersonaController@destroyMass'
      ]);

      Route::resource('eleccion', 'EleccionController');

      Route::post('eleccion/destroyMass', [
          'as' => 'eleccion.destroyMass',
          'uses' => 'EleccionController@destroyMass'
      ]);

      Route::get('/eleccion/reporte/{eleccion_id}',["as" => 'eleccion.reporte',
        'uses' => 'EleccionController@reporte']);

      Route::get('/eleccion/reportedetallado/{eleccion_id}',["as" => 'eleccion.reporte.detallado',
        'uses' => 'EleccionController@reporteDetallado']);

      Route::resource('votacion', 'VotacionController');

      Route::post('persona/candidato',["as" => "persona.candidato", "uses" => "PersonaController@candidato"]);

      Route::get('persona/reporte/general',["as" => 'persona.reporte.general',
        'uses' => 'PersonaController@reporteGeneral']);

      Route::get('persona/reporte/ingreso',["as" => 'persona.reporte.ingreso',
        'uses' => 'PersonaController@reportePersonasIngreso']);

      Route::get('persona/general/salida',["as" => 'persona.general.salida',
        'uses' => 'PersonaController@salidaGeneral']);

      Route::get('eleccion/reporte/resumen/{id}',["as" => 'eleccion.reporte.resumen',
        'uses' => 'EleccionController@reporteResumen']);

    });

    //Route::resource('eleccion', 'VotacionController');
    
    });
  
  });

  Route::get('/profile', ["as" => "profile", "uses" => "PersonaController@profile"]);
  Route::post('/profile/update/{id}', ["as" => "profile.update", "uses" => "PersonaController@profileUpdate"]);

  //Route::get('/', ["as" => "inicio",'uses' => 'VotacionController@index']);
  Route::get('/', ["as" => "inicio",'uses' => 'VotacionController@index']);

  Route::get('/uieleccion/{eleccion_codigo}', ["as" => "uieleccion",'uses' => 'VotacionController@eleccion']);

  Route::post('/admin/votacion', ["as" => "admin.votacion.store", "uses" => "VotacionController@store"]);

});

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::get('/forgetpassword', ["as" => "forgetpassword", "uses" => 'CredentialsController@showForgetPassword']);

Route::post('/forgetpassword/proccess', ["as" => "forgetpassword.proccess", "uses" => 'CredentialsController@proccessForgetPassword']);

Route::get('/test',[function(){
  //return view('auth.authadmin');
  //Request::session('test','valor');
  //session(['test' => 'valor']);
  //dd(Request::session()->all());
  //dd(session()->all());

  /*$data["persona"] = App\Persona::find(26);

  return view('mail.rememberpassword',$data);*/


}]);

Route::get('/test2', 'PersonaController@testmail');