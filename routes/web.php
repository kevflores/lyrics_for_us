<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', [
    'uses' => 'HomeController@index',
    'as' => 'home'
]);

// Rutas para Modo Usuario:

Route::get('/home', [
    'uses' => 'HomeController@indexUsuario',
    'as' => 'userhome'
]);

Route::get('/artista', [
    'uses' => 'ArtistaController@index',
    'as' => 'artista'
]);

Route::get('/artista/por/{seleccion}', [
    'uses' => 'ArtistaController@verLista',
    'as' => 'artista.lista'
]);

Route::get('/artista/{id_artista}', [
    'uses' => 'ArtistaController@verInformacion',
    'as' => 'artista.informacion'
]);

Route::post('/artista/{id_artista}/comentar', [
    'uses' => 'ArtistaController@comentar',
    'as' => 'artista.comentar'
]);

Route::post('/artista/{id_artista}/favorito', [
    'uses' => 'ArtistaController@favorito',
    'as' => 'artista.favorito'
]);

Route::get('/disco', [
    'uses' => 'DiscoController@index',
    'as' => 'disco'
]);

Route::get('/disco/por/{seleccion}', [
    'uses' => 'DiscoController@verLista',
    'as' => 'disco.lista'
]);

Route::get('/disco/{id_disco}', [
    'uses' => 'DiscoController@verInformacion',
    'as' => 'disco.informacion'
]);

Route::post('/disco/{id_disco}/comentar', [
    'uses' => 'DiscoController@comentar',
    'as' => 'disco.comentar'
]);

Route::post('/disco/{id_disco}/favorito', [
    'uses' => 'DiscoController@favorito',
    'as' => 'disco.favorito'
]);

Route::get('/cancion', [
    'uses' => 'CancionController@index',
    'as' => 'cancion'
]);

Route::get('/cancion/por/{seleccion}', [
    'uses' => 'CancionController@verLista',
    'as' => 'cancion.lista'
]);

Route::get('/cancion/{id_cancion}', [
    'uses' => 'CancionController@verInformacion',
    'as' => 'cancion.informacion'
]);

Route::post('/cancion/{id_cancion}/comentar', [
    'uses' => 'CancionController@comentar',
    'as' => 'cancion.comentar'
]);

Route::post('/cancion/{id_cancion}/favorita', [
    'uses' => 'CancionController@favorita',
    'as' => 'cancion.favorita'
]);

Route::post('/cancion/{id_cancion}/guardarletra', [
    'uses' => 'CancionController@guardarLetra',
    'as' => 'cancion.guardarletra'
]);

Route::post('/cancion/{id_cancion}/reportarletra', [
    'uses' => 'CancionController@reportarLetra',
    'as' => 'cancion.reportarletra'
]);

Route::get('/registro', [
    'uses' => 'UsuarioController@indexRegistro',
    'as' => 'usuario.registro'
]);

Route::post('/registro/continuar', [
    'uses' => 'UsuarioController@registrar',
    'as' => 'usuario.continuar_registro'
]);

Route::get('/activar-cuenta/{codigo}', [
    'uses' => 'UsuarioController@activarCuenta',
    'as' => 'usuario.activar'
]);

Route::get('/ingreso', [
    'uses' => 'UsuarioController@indexIngreso',
    'as' => 'usuario.ingreso'
]);

Route::post('/ingreso/continuar', [
    'uses' => 'UsuarioController@ingresar',
    'as' => 'usuario.continuar_ingreso'
]);

Route::get('/recuperar-password', [
    'uses' => 'UsuarioController@recuperarPassworld',
    'as' => 'usuario.recuperar_password'
]);

Route::post('/recuperar-password/validar', [
    'uses' => 'UsuarioController@validarRecuperacion',
    'as' => 'usuario.validar_recuperacion'
]);

Route::get('/activar-recuperacion/{codigo}', [
    'uses' => 'UsuarioController@activarRecuperacion',
    'as' => 'usuario.activar_recuperacion'
]);

Route::post('/generar-password/{id_usuario}', [
    'uses' => 'UsuarioController@generarPassword',
    'as' => 'usuario.generar_password'
]);

Route::get('/usuario/{id_usuario}', [
    'uses' => 'UsuarioController@mostrarPerfil',
    'as' => 'usuario.perfil'
]);

Route::post('/usuario/{id_usuario}/comentar', [
    'uses' => 'UsuarioController@comentar',
    'as' => 'usuario.comentar'
]);

Route::post('/usuario/{id_usuario}/reportar', [
    'uses' => 'UsuarioController@reportar',
    'as' => 'usuario.reportar'
]);

Route::post('/usuario/{id_usuario}/reportar', [
    'uses' => 'UsuarioController@reportar',
    'as' => 'usuario.reportar'
]);

Route::get('/usuario/{id_usuario}/favoritos', [
    'uses' => 'UsuarioController@verFavoritos',
    'as' => 'usuario.ver_favoritos'
]);

Route::get('/configuracion', [
    'uses' => 'UsuarioController@verConfiguracion',
    'as' => 'usuario.configuracion'
]);

Route::get('/configuracion/editar-datos', [
    'uses' => 'UsuarioController@editarDatos',
    'as' => 'usuario.editar_datos'
]);

Route::get('/salir', [
    'uses' => 'UsuarioController@salir',
    'as' => 'usuario.salir'
]);

Route::get('/mensajes-recibidos', [
    'uses' => 'MensajeController@verMensajesRecibidos',
    'as' => 'mensajes_recibidos'
]);

Route::get('/mensajes-recibidos/{id_mensaje}', [
    'uses' => 'MensajeController@verMensajeRecibido',
    'as' => 'ver_mensaje_recibido'
]);

Route::get('/mensajes-recibidos/{id_mensaje}/borrar', [
    'uses' => 'MensajeController@borrarMensajeRecibido',
    'as' => 'borrar_mensaje_recibido'
]);

Route::get('/mensajes-recibidos/{id_mensaje}/responder', [
    'uses' => 'MensajeController@responder',
    'as' => 'responder_mensaje'
]);

Route::get('/mensajes-recibidos/borrar-marcados/{mensajes}', [
    'uses' => 'MensajeController@borrarMensajesRecibidosMarcados',
    'as' => 'borrar_mensajes_recibidos'
]);

Route::get('/mensajes-recibidos/marcar-leidos/{mensajes}', [
    'uses' => 'MensajeController@marcarComoLeidos',
    'as' => 'marcar_como_leidos'
]);

Route::get('/mensajes-enviados', [
    'uses' => 'MensajeController@verMensajesEnviados',
    'as' => 'mensajes_enviados'
]);

Route::get('/mensajes-enviados/{id_mensaje}', [
    'uses' => 'MensajeController@verMensajeEnviado',
    'as' => 'ver_mensaje_enviado'
]);

Route::get('/mensajes-enviados/{id_mensaje}/borrar', [
    'uses' => 'MensajeController@borrarMensajeEnviado',
    'as' => 'borrar_mensaje_recibido'
]);

Route::get('/mensajes-enviados/borrar-marcados/{mensajes}', [
    'uses' => 'MensajeController@borrarMensajesEnviadosMarcados',
    'as' => 'borrar_mensajes_enviados'
]);

Route::get('/nuevo-mensaje', [
    'uses' => 'MensajeController@escribirMensaje',
    'as' => 'nuevo_mensaje'
]);

Route::post('/nuevo-mensaje/enviar', [
    'uses' => 'MensajeController@enviarMensaje',
    'as' => 'enviar_mensaje'
]);

Route::get('/mis-solicitudes', [
    'uses' => 'SolicitudController@verLista',
    'as' => 'usuario.solicitudes'
]);

Route::get('/mis-solicitudes/{id_solicitud}', [
    'uses' => 'SolicitudController@verSolicitud',
    'as' => 'usuario.ver_solicitud'
]);

Route::get('/nueva-solicitud', [
    'uses' => 'SolicitudController@nuevaSolicitud',
    'as' => 'usuario.nueva_solicitud'
]);

Route::post('/nueva-solicitud/enviar', [
    'uses' => 'SolicitudController@enviarSolicitud',
    'as' => 'usuario.enviar_solicitud'
]);

Route::get('/buscar', [
    'uses' => 'BusquedaController@index',
    'as' => 'buscar'
]);

// Rutas para Modo Administrador:

Route::get('/adminview/home', [
    'uses' => 'HomeController@indexAdmin',
    'as' => 'adminhome'
]);
