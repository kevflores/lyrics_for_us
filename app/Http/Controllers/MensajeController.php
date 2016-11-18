<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MensajeController extends Controller
{
    public function verMensajesRecibidos()
    {
        // Mostrar lista de mensajes recibidos por el usuario autenticado.
        return view('userview.mensajes.ver_lista_mensajes_recibidos');
    }
    
    public function verMensajeRecibido($id_mensaje)
    {
        // Mostrar un mensaje en específico de la lista de mensajes recibidos por el usuario autenticado.
        return view('userview.mensajes.ver_mensaje_recibido');
    }
    
    public function borrarMensajeRecibido($id_mensaje)
    {
        // Cambiar el valor del atributo 'estado_receptor' a "false" en el registro respectivo de la tabla
        // 'mensajes', de modo que el usuario autenticado no pueda acceder a éste nuevamente. 
    }
    
    public function responder($id_mensaje)
    {
        // Mostrar la vista con el formulario para que el usuario escriba el mensaje que desea enviar.
        // Por defecto, el formulario debe mostrar el nickname del usuario receptor.

        // NOTA: En vez de realizar una vista para esta función, podría utilizarse un 'modal' o un form
        // en las vista "verMensajeRecibido".
    }

    public function borrarMensajesRecibidosMarcados($mensajes)
    {
        // Cambiar el valor del atributo 'estado_receptor' a "false" en los registros respectivos de la tabla
        // 'mensajes', de modo que el usuario autenticado no pueda acceder a éstos nuevamente. 
    }

    public function marcarComoLeidos($mensajes)
    {
        // Cambiar el valor del atributo 'visto' a "true" en los registros respectivos de la tabla 'mensajes'.
    }

    public function verMensajesEnviados()
    {
        // Mostrar lista de mensajes enviados por el usuario autenticado.
        return view('userview.mensajes.ver_lista_mensajes_enviados');
    }
    
    public function verMensajeEnviado($id_mensaje)
    {
        // Mostrar un mensaje en específico de la lista de mensajes enviados por el usuario autenticado.
        return view('userview.mensajes.ver_mensaje_enviado');
    }
    
    public function borrarMensajeEnviado($id_mensaje)
    {
        // Cambiar el valor del atributo 'estado_emisor' a "false" en el registro respectivo de la tabla
        // 'mensajes', de modo que el usuario autenticado no pueda acceder a éste nuevamente.
    }

    public function borrarMensajesEnviadosMarcados($mensajes)
    {
        // Cambiar el valor del atributo 'estado_emisor' a "false" en los registros respectivos de la tabla
        // 'mensajes', de modo que el usuario autenticado no pueda acceder a éstos nuevamente. 
    }

    public function escribirMensaje()
    {
        // Mostrar la vista con el formulario para que el usuario escriba el mensaje que desea enviar.
        return view('userview.mensajes.escribir_mensaje.blade.php');
    }

    public function enviarMensaje(Request $request)
    {
        // Almanacenar el mensaje (escrito por el usuario autenticado) dirigido a otro usuario.
    }
}
