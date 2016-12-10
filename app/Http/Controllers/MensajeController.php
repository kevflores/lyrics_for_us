<?php
namespace App\Http\Controllers;
use App\Mensaje;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use DateTime;

class MensajeController extends Controller
{
    public function verMensajesRecibidos()
    {
        // Mostrar lista de mensajes recibidos por el usuario autenticado.
        return view('userview.mensajes.ver_lista_mensajes_recibidos', ['usuario' => Auth::User()]);
    }
    
    public function verMensajeRecibido($id_mensaje)
    {
        // Mostrar un mensaje en específico de la lista de mensajes recibidos por el usuario autenticado.
        // Sólo lo puede ver el usuario emisor
        return view('userview.mensajes.ver_mensaje_recibido', ['usuario' => Auth::User()]);
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

    public function verMensajesEnviados($mensajePantalla=null)
    {
        // Mostrar lista de mensajes enviados por el usuario autenticado.
        return view('userview.mensajes.ver_lista_mensajes_enviados', ['usuario' => Auth::User()]);
    }
    
    public function verMensajeEnviado($id_mensaje)
    {
        // Mostrar un mensaje en específico de la lista de mensajes enviados por el usuario autenticado.
        // Sólo lo puede ver el usuario emisor
        return view('userview.mensajes.ver_mensaje_enviado', ['usuario' => Auth::User()]);
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
        return view('userview.mensajes.escribir_mensaje.blade.php', ['usuario' => Auth::User()]);
    }

    public function enviarMensaje(Request $request, $id_receptor, $origen)
    {
        // Almanacenar el mensaje (escrito por el usuario autenticado) dirigido a otro usuario.

        $this->validate($request, [
            'asunto' => 'required|string|max:100',
            'descripcion' => 'required|string'
        ]);

        $emisor = Auth::User();

        $mensaje = new Mensaje();

        $mensaje->asunto = $request['asunto'];
        $mensaje->descripcion = $request['descripcion'];
        $mensaje->fecha = new DateTime();
        $mensaje->usuario_receptor_id = $id_receptor;
        $mensaje->usuario_emisor_id = $emisor->id; 

        $mensaje->save();

        $idMensaje = $mensaje->id;

        if ( $origen === "vista_de_nuevo_mensaje" ) {
            // Enviar a vista...
            //return view ('userview.mensajes.ver_lista_mensajes_enviados', ['usuario' => Auth::User(), 'mensaje' => $mensajePantalla]);
            // ...o enviar a método verMensajesEnviados() (?)
            return redirect()->action('MensajeController@verMensajesEnviados', ['mensajePantalla' => $mensajePantalla]);
        } else {
            return redirect()->back()->with(['mensajeEnviado' => $idMensaje]);
        }
    }
}
