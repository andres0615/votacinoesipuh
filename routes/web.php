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

    Route::get('/admin/persona/identificaciones', ["as" => "admin.persona.identificaciones", "uses" => "PersonaController@getIdentificacionesJson"]);

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

      Route::resource('votacion', 'VotacionController');

    });

    //Route::resource('eleccion', 'VotacionController');
    
    });
  
  });

  Route::get('/profile', ["as" => "profile", function(){
    return view('admin.persona.menu');
  }]);

  //Route::get('/', ["as" => "inicio",'uses' => 'VotacionController@index']);
  Route::get('/', ["as" => "inicio",'uses' => 'VotacionController@index']);
  Route::get('/uieleccion/{eleccion_codigo}', ["as" => "uieleccion",'uses' => 'VotacionController@eleccion']);

});

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::get('/test',[function(){
  //return view('auth.authadmin');
  //Request::session('test','valor');
  //session(['test' => 'valor']);
  //dd(Request::session()->all());
  //dd(session()->all());
}]);