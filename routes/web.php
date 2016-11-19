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

Route::group(['middleware' => ['web']], function () {

    Route::get('/', ['uses' => 'InicioController@index', 'as' => 'home'
    ]);

    # RUTAS PARA MODO USUARIO

    # INICIO

    Route::get('/inicio', 'InicioController@indexUsuario')->name('userhome');


    # ARTISTAS

    Route::get('/artistas', 'ArtistaController@index')->name('artistas');
    Route::get('/artistas/por/{seleccion}', 'ArtistaController@verLista')->name('artistas.lista');
    Route::get('/artistas/{id_artista}', 'ArtistaController@verInformacion')->name('artistas.informacion');
    Route::post('/artistas/{id_artista}/comentar', 'ArtistaController@comentar')->name('artistas.comentar');
    Route::post('/artistas/{id_artista}/favorito', 'ArtistaController@favorito')->name('artistas.favorito');


    # DISCOS

    Route::get('/discos', 'DiscoController@index')->name('discos');
    Route::get('/discos/por/{seleccion}', 'DiscoController@verLista')->name('discos.lista');
    Route::get('/discos/{id_disco}', 'DiscoController@verInformacion')->name('discos.informacion');
    Route::post('/discos/{id_disco}/comentar', 'DiscoController@comentar')->name('discos.comentar');
    Route::post('/discos/{id_disco}/favorito', 'DiscoController@favorito')->name('discos.favorito');


    # CANCIONES

    Route::get('/canciones', 'CancionController@index')->name('canciones');
    Route::get('/canciones/por/{seleccion}', 'CancionController@verLista')->name('canciones.lista');
    Route::get('/canciones/{id_cancion}', 'CancionController@verInformacion')->name('canciones.informacion');
    Route::post('/canciones/{id_cancion}/comentar', 'CancionController@comentar')->name('canciones.comentar');
    Route::post('/canciones/{id_cancion}/favorita', 'CancionController@favorita')->name('canciones.favorita');
    Route::post('/canciones/{id_cancion}/guardarletra', 'CancionController@guardarLetra')->name('canciones.guardarletra');
    Route::post('/canciones/{id_cancion}/reportarletra', 'CancionController@reportarLetra')->name('canciones.reportarletra');


    # REGISTRO

    Route::get('/registro', 'UsuarioController@indexRegistro')->name('usuario.registro');
    Route::post('/registro/continuar', 'UsuarioController@registrar')->name('usuario.continuar_registro');


    # INGRESO Y SALIDA 

    Route::get('/ingreso', 'UsuarioController@indexIngreso')->name('usuario.ingreso');
    Route::post('/ingreso/continuar', 'UsuarioController@ingresar')->name('usuario.continuar_ingreso');
    Route::get('/salir', 'UsuarioController@salir')->name('usuario.salir');


    # ACTIVACIÓN DE CUENTA Y RECUPERACIÓN DE PASSWORD

    Route::get('/activar-cuenta/{codigo}', 'UsuarioController@activarCuenta')->name('usuario.activar');
    Route::get('/recuperar-password', 'UsuarioController@recuperarPassworld')->name('usuario.recuperar_password');
    Route::post('/recuperar-password/validar', 'UsuarioController@validarRecuperacion')->name('usuario.validar_recuperacion');
    Route::get('/activar-recuperacion/{codigo}', 'UsuarioController@activarRecuperacion')->name('usuario.activar_recuperacion');
    Route::post('/generar-password/{id_usuario}', 'UsuarioController@generarPassword')->name('usuario.generar_password');


    # USUARIO

    Route::get('/usuario/{nickname}', 'UsuarioController@mostrarPerfil')->name('usuario.perfil');
    Route::post('/usuario/{id_usuario}/comentar', 'UsuarioController@comentar')->name('usuario.comentar');
    Route::post('/usuario/{id_usuario}/reportar', 'UsuarioController@reportar')->name('usuario.reportar');
    Route::get('/usuario/{id_usuario}/favoritos', 'UsuarioController@verFavoritos')->name('usuario.ver_favoritos');


    # MI CUENTA

    Route::get('/cuenta/configuracion', 'UsuarioController@verConfiguracion')->name('usuario.configuracion');
    Route::get('/cuenta/configuracion/editar-datos', 'UsuarioController@editarDatos')->name('usuario.editar_datos');
    Route::get('/cuenta/mensajes-recibidos', 'MensajeController@verMensajesRecibidos')->name('mensajes_recibidos');
    Route::get('/cuenta/mensajes-recibidos/{id_mensaje}', 'MensajeController@verMensajeRecibido')->name('ver_mensaje_recibido');
    Route::get('/cuenta/mensajes-recibidos/{id_mensaje}/borrar', 'MensajeController@borrarMensajeRecibido')->name('borrar_mensaje_recibido');
    Route::get('/cuenta/mensajes-recibidos/{id_mensaje}/responder', 'MensajeController@responder')->name('responder_mensaje');
    Route::get('/cuenta/mensajes-recibidos/borrar-marcados/{mensajes}', 'MensajeController@borrarMensajesRecibidosMarcados')->name('borrar_mensajes_recibidos');
    Route::get('/cuenta/mensajes-recibidos/marcar-leidos/{mensajes}', 'MensajeController@marcarComoLeidos')->name('marcar_como_leidos');
    Route::get('/cuenta/mensajes-enviados', 'MensajeController@verMensajesEnviados')->name('mensajes_enviados');
    Route::get('/cuenta/mensajes-enviados/{id_mensaje}', 'MensajeController@verMensajeEnviado')->name('ver_mensaje_enviado');
    Route::get('/cuenta/mensajes-enviados/{id_mensaje}/borrar', 'MensajeController@borrarMensajeEnviado')->name('borrar_mensaje_recibido');
    Route::get('/cuenta/mensajes-enviados/borrar-marcados/{mensajes}', 'MensajeController@borrarMensajesEnviadosMarcados')->name('borrar_mensajes_enviados');
    Route::get('/cuenta/nuevo-mensaje', 'MensajeController@escribirMensaje')->name('nuevo_mensaje');
    Route::post('/cuenta/nuevo-mensaje/enviar', 'MensajeController@enviarMensaje')->name('enviar_mensaje');
    Route::get('/cuenta/mis-solicitudes', 'SolicitudController@verLista')->name('usuario.solicitudes');
    Route::get('/cuenta/mis-solicitudes/{id_solicitud}', 'SolicitudController@verSolicitud')->name('usuario.ver_solicitud');
    Route::get('/cuenta/nueva-solicitud', 'SolicitudController@nuevaSolicitud')->name('usuario.nueva_solicitud');
    Route::post('/cuenta/nueva-solicitud/enviar', 'SolicitudController@enviarSolicitud')->name('usuario.enviar_solicitud');


    # BUSCAR

    Route::get('/buscar', 'BusquedaController@index')->name('buscar');


    # RUTAS PARA MODO ADMINISTRADOR

    Route::get('/adminview/home', 'InicioController@indexAdmin')->name('adminhome');

});

function current_page($uri = "/") {
    return strstr(request()->path(), $uri);
    //return request()->path == $uri;
}

Auth::routes();

Route::get('/home', 'HomeController@index');
