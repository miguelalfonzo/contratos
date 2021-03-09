<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
|
*/



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/sql', function () {

	

});

Route::get('/pagina_no_encontrada',function(){

	abort(404,'Page not found'); 
});

//Rutas de Maestro

Route::get('/maestro','Maestro\MaestroController@index');
Route::get('/get_list_maestro','Maestro\MaestroController@get_list_maestro');
Route::post('/delete_table_maestro','Maestro\MaestroController@delete_table_maestro');
Route::post('/save_maestro','Maestro\MaestroController@save_maestro');


//Rutas de Usuario

Route::get('/usuario','Seguridad\UsuarioController@index');
Route::get('/get_list_user','Seguridad\UsuarioController@get_list_user');
Route::get('/get_user_detalle','Seguridad\UsuarioController@get_user_detalle');
Route::post('/delete_user','Seguridad\UsuarioController@delete_user');
Route::post('/save_user','Seguridad\UsuarioController@save_user');
Route::post('/reset_contrasena_usuario','Seguridad\UsuarioController@reset_contrasena_usuario');

//Rutas Perfil

Route::get('/perfil/{id}','Seguridad\ProfileController@index');
Route::post('/salvar_perfil','Seguridad\ProfileController@salvar_perfil');

//Rutas roles

Route::get('/roles','Seguridad\RolController@index');
Route::get('/get_list_roles','Seguridad\RolController@get_list_roles');
Route::get('/get_rol_detalle','Seguridad\RolController@get_rol_detalle');
Route::post('/delete_rol','Seguridad\RolController@delete_rol');
Route::post('/salvar_rol','Seguridad\RolController@salvar_rol');

//Rutas empresa

Route::get('/empresa','Seguridad\EmpresaController@index');
Route::post('/actualiza_empresa','Seguridad\EmpresaController@actualiza_empresa');

//Rutas de Ubigeo
Route::get('/ubigeo','Maestro\UbigeoController@index');
Route::get('/get_departamentos','Maestro\UbigeoController@get_departamentos');
Route::get('/get_distritos','Maestro\UbigeoController@get_distritos');
Route::get('/get_provincias','Maestro\UbigeoController@get_provincias');
Route::get('/get_ubigeo','Maestro\UbigeoController@get_ubigeo');
Route::post('/save_Ubigeo','Maestro\UbigeoController@save_Ubigeo');

//Rutas clientes

Route::get('/clientes','Maestro\ClienteController@index');
Route::get('/get_list_clientes','Maestro\ClienteController@get_list_clientes');


Route::get('/cliente','Maestro\ClienteController@new_cliente');
Route::get('/cliente/{id}','Maestro\ClienteController@cliente');
Route::post('/delete_cliente','Maestro\ClienteController@delete_cliente');
Route::post('/save_cliente','Maestro\ClienteController@save_cliente');

//representante
Route::get('/get_cliente_representantes','Maestro\ClienteController@get_cliente_representantes');
Route::post('/salvar_representante','Maestro\ClienteController@salvar_representante');

Route::post('/elimina_representante','Maestro\ClienteController@elimina_representante');

//accionistas
Route::get('/get_cliente_accionistas','Maestro\ClienteController@get_cliente_accionistas');
Route::post('/salvar_accionista','Maestro\ClienteController@salvar_accionista');

Route::post('/elimina_accionista','Maestro\ClienteController@elimina_accionista');

//documento

Route::get('/get_cliente_documentos','Maestro\ClienteController@get_cliente_documentos');
Route::post('/load_file_cliente_documento','Maestro\ClienteController@load_file_cliente_documento');

Route::post('/elimina_documento_cliente','Maestro\ClienteController@elimina_documento_cliente');


//Rutas consorcio
Route::get('/get_cliente_empresas','Maestro\ClienteController@get_cliente_empresas');
Route::get('/get_combo_empresas','Maestro\ClienteController@get_combo_empresas');
Route::post('/guardar_asociados_empresas','Maestro\ClienteController@guardar_asociados_empresas');


//obras


Route::get('/obras', 'Obra\ObraController@index');
Route::get('/obra', 'Obra\ObraController@new_obra');
Route::get('/obra/{id}', 'Obra\ObraController@edit_obra');

Route::get('/get_obras_list', 'Obra\ObraController@get_obras_list');
Route::post('/salvar_obra', 'Obra\ObraController@salvar_obra');

Route::get('/get_obra_documentos', 'Obra\ObraController@get_obra_documentos');
Route::post('/load_file_obra_documento', 'Obra\ObraController@load_file_obra_documento');
Route::post('/elimina_documento_obra', 'Obra\ObraController@elimina_documento_obra');


Route::get('/get_obras_combo_autocompletar', 'Obra\ObraController@get_obras_combo_autocompletar');

Route::get('/export_obras', 'Obra\ObraController@export_obras');

//solicitud 

Route::get('/solicitud/{id}','Obra\SolicitudController@solicitud');
Route::get('/get_solicitud_documentos','Obra\SolicitudController@get_solicitud_documentos');
Route::post('/load_file_solicitud_documento', 'Obra\SolicitudController@load_file_solicitud_documento');
Route::post('/elimina_documento_solicitud', 'Obra\SolicitudController@elimina_documento_solicitud');
Route::post('/load_file_solicitud_documento_memoria', 'Obra\SolicitudController@load_file_solicitud_documento_memoria');
Route::post('/elimina_documento_solicitud_memoria', 'Obra\SolicitudController@elimina_documento_solicitud_memoria');
Route::post('/save_solicitud', 'Obra\SolicitudController@save_solicitud');

Route::post('/rechazar_solicitud', 'Obra\SolicitudController@rechazar_solicitud');

//gestion carta fianza

Route::get('/gestion_carta_fianza','Obra\FianzaController@gestion_carta_fianza'); 


Route::get('/get_list_fianzas','Obra\FianzaController@get_list_fianzas'); 

Route::get('/get_detalle_carta_fianza','Obra\FianzaController@get_detalle_carta_fianza'); 

Route::post('/save_carta_fianza', 'Obra\FianzaController@save_carta_fianza');

Route::get('/get_detalle_carta_fianza_garantia','Obra\FianzaController@get_detalle_carta_fianza_garantia'); 

Route::post('/subir_documento_gestion_carta_fianza', 'Obra\FianzaController@subir_documento_gestion_carta_fianza');

Route::post('/elimina_file_gestion_carta_fianza', 'Obra\FianzaController@elimina_file_gestion_carta_fianza');

//renovacion de carta fianza

Route::post('/renovar_carta_fianza', 'Obra\FianzaController@renovar_carta_fianza');
Route::post('/subir_documento_avance_obra', 'Obra\FianzaController@subir_documento_avance_obra');

Route::post('/elimina_file_avance_obra', 'Obra\FianzaController@elimina_file_avance_obra');

Route::get('/get_list_garantias_relacionadas','Obra\FianzaController@get_list_garantias_relacionadas'); 

Route::get('/get_list_fianzas_relacionadas','Obra\FianzaController@get_list_fianzas_relacionadas'); 

Route::get('/set_datos_renovacion_garantia','Obra\FianzaController@set_datos_renovacion_garantia'); 



Route::post('/save_renovacion_garantia', 'Obra\FianzaController@save_renovacion_garantia');


Route::get('/set_inputs_datos_renovacion','Obra\FianzaController@set_inputs_datos_renovacion');

Route::post('/cerrar_carta_fianza', 'Obra\FianzaController@cerrar_carta_fianza'); 


// reportes

Route::get('/reporte_historial/{CodigoObra}','Reporte\ReporteController@reporte_historial');
Route::get('/reporte_cumpleanos_rep/{IdEmpresa}','Reporte\ReporteController@reporte_cumpleanos_representantes');

//busqueda ws ruc -dni


Route::get('/buscar_ruc','Maestro\RucController@search_ruc');
Route::get('/buscar_dni','Maestro\DniController@search_dni');


//alertas

Route::get('/get_alertas_fianzas','Reporte\AlertaController@get_alertas_fianzas');
Route::get('/get_alertas_garantias','Reporte\AlertaController@get_alertas_garantias');
Route::get('/get_alertas_cumpleanos','Reporte\AlertaController@get_alertas_cumpleanos');
Route::get('/export_todos_cumpleanos','Reporte\AlertaController@export_todos_cumpleanos');


//parametros

Route::get('/parametros','Maestro\MaestroController@parametros');
Route::post('/actualiza_parametros','Maestro\MaestroController@actualiza_parametros');

