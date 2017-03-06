<?php
namespace App\Http\Controllers;
use App\Usuario;
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
        $usuario = Auth::User();
        // Mostrar lista de mensajes recibidos por el usuario autenticado.
        $mensajesRecibidos = Usuario::find($usuario->id)
                                    ->mensajesDeReceptor()
                                    ->where("estado_receptor", true)
                                    ->orderBy("fecha","desc")
                                    ->paginate(10);

        return view('userview.mensajes.ver_lista_mensajes_recibidos', ['usuario' => $usuario, 'mensajes' => $mensajesRecibidos]);
    }
    
    public function verMensajeRecibido($id_mensaje)
    {
        // Mostrar un mensaje en específico de la lista de mensajes recibidos por el usuario autenticado.
        
        if ( ctype_digit( $id_mensaje ) ) {
            $usuario = Auth::User();
            $mensajeRecibido = DB::table('mensajes')->where('id',$id_mensaje)->first();
            if ( $usuario->id === $mensajeRecibido->usuario_receptor_id ) {
                if ( $mensajeRecibido->estado_receptor === false ) {
                    return redirect()->action('MensajeController@verMensajesRecibidos');
                } else {
                    $mensaje = Mensaje::find($mensajeRecibido->id);
                    if ( $mensajeRecibido->visto === false ){
                        $mensaje->visto = true;
                        $mensaje->update();
                    }
                    return view('userview.mensajes.ver_mensaje_recibido', ['usuario' => $usuario, 'mensaje' => $mensaje]);
                }
            }
        }
        return redirect()->action("MensajeController@verMensajesRecibidos");
    }
    
    public function borrarMensajeRecibido(Request $request)
    {
        // Cambiar el valor del atributo 'estado_receptor' a "false" en el registro respectivo de la tabla
        // 'mensajes', de modo que el usuario autenticado no pueda acceder a éste nuevamente. 
        $usuario = Auth::User();
        $mensaje = Mensaje::find($request['id_mensaje']);

        if ( $mensaje ) {
            if ($mensaje->usuario_receptor_id === $usuario->id) {
                $mensaje->estado_receptor = false;
                if ( $mensaje->estado_emisor === false ) {
                    $mensaje->delete();
                } else {
                    $mensaje->update();
                }
                return redirect()->back()->with(['mensaje' => 'El mensaje ha sido eliminado satisfactoriamente.']);
            }
        }
        return redirect()->back()->with(['mensajeError' => 'Error. Eliminación fallida.']);
    }

    public function borrarMensajeRecibidoLeido(Request $request) {
        $usuario = Auth::User();
        $mensaje = Mensaje::find($request['id_mensaje']);

        if ($mensaje->usuario_receptor_id === $usuario->id) {
            $mensaje->estado_receptor = false;
            if ( $mensaje->estado_emisor === false ) {
                $mensaje->delete();
            } else {
                $mensaje->update();
            }
            return redirect()->action('MensajeController@verMensajesRecibidos');
        }
        return redirect()->back()->with(['mensajeError' => 'Error. Eliminación fallida.']);
    }

    public function borrarMensajeEnviadoLeido(Request $request) {
        $usuario = Auth::User();
        $mensaje = Mensaje::find($request['id_mensaje']);

        if ($mensaje->usuario_emisor_id === $usuario->id) {
            $mensaje->estado_emisor = false;
            if ( $mensaje->estado_receptor === false ) {
                $mensaje->delete();
            } else {
                $mensaje->update();
            }
            return redirect()->action('MensajeController@verMensajesEnviados');
        }
        return redirect()->back()->with(['mensajeError' => 'Error. Eliminación fallida.']);
    }
    
    public function responder(Request $request)
    {
        // Mostrar la vista con el formulario para que el usuario escriba el mensaje que desea enviar.
        // Por defecto, el formulario debe mostrar el nickname del usuario receptor.
        // NOTA: En vez de realizar una vista para esta función, podría utilizarse un 'modal' o un form
        // en las vista "verMensajeRecibido".

        $emisor = Auth::User();

        $this->validate($request, [
            'asunto' => 'required|string|max:100',
            'descripcion-mensaje' => 'required|string',
            'nickname' => 'required|string|exists:usuarios,nickname'
        ]);

        // BUSCAR ID DE USUARIO SEGÚN NICKNAME
        $receptor = Usuario::where('nickname', $request['nickname'])->first();

        $mensaje = new Mensaje();
        $mensaje->asunto = $request['asunto'];
        $mensaje->descripcion = $request['descripcion-mensaje'];
        $mensaje->fecha = new DateTime();
        $mensaje->usuario_receptor_id = $receptor->id;
        $mensaje->usuario_emisor_id = $emisor->id; 
        $mensaje->save();

        $idMensaje = $mensaje->id;

        return redirect()->back()->with(['mensajeEnviado' => $idMensaje]);
    }

    public function borrarMensajesRecibidosMarcados(Request $request)
    {
        // Cambiar el valor del atributo 'estado_receptor' a "false" en los registros respectivos de la tabla
        // 'mensajes', de modo que el usuario autenticado no pueda acceder a éstos nuevamente. 
        $usuario = Auth::User();
        $idMensajesMarcados = $request['chk'];

        if ($idMensajesMarcados) {
            $cantidad = 0;
            foreach ($idMensajesMarcados as $idMensajeMarcado){
                $mensaje = Mensaje::find($idMensajeMarcado);

                if ($mensaje->usuario_receptor_id === $usuario->id) {
                    $mensaje->estado_receptor = false;
                    // Si el usuario emisor también eliminó el mensaje.
                    if ( $mensaje->estado_emisor === false ) {
                        // Entonces el registro del mensaje es eliminado de la BD.
                        $mensaje->delete();
                    } else {
                        // Sino simplemente se cambia el estado del usuario receptor del mensaje.
                        $mensaje->update();
                    }
                    $cantidad++;
                }
            }

            if ( $cantidad === 0 ) {
                return redirect()->back();
            } elseif ( $cantidad === 1 ) {
                return redirect()->back()->with(['mensaje' => 'El mensaje ha sido eliminado satisfactoriamente.']);
            } elseif ( $cantidad > 1 ) {
                return redirect()->back()->with(['mensaje' => $cantidad.' mensajes han sido eliminados satisfactoriamente']);
            }
        }
        return redirect()->back()->with(['mensajeError' => 'No se ha marcado ningún mensaje.']);
    }

    public function marcarComoLeidos(Request $request)
    {
        $usuario = Auth::User();
        $idMensajesMarcados = $request['chk'];

        if ($idMensajesMarcados) {
            foreach ($idMensajesMarcados as $idMensajeMarcado){
                $mensaje = Mensaje::find($idMensajeMarcado);
                if ($mensaje->usuario_receptor_id === $usuario->id) {
                    $mensaje->visto = true;
                    $mensaje->update();
                }
            }
            return redirect()->back();
        }
        return redirect()->back()->with(['mensajeError' => 'No se ha marcado ningún mensaje.']);

    }

    public function verMensajesEnviados($idMensaje=null)
    {
        $usuario = Auth::User();
        // Mostrar lista de mensajes enviados por el usuario autenticado.
        $mensajesEnviados = Usuario::find($usuario->id)
                                    ->mensajesDeEmisor()
                                    ->where("estado_emisor", true)
                                    ->orderBy("fecha","desc")
                                    ->paginate(10);

        return view('userview.mensajes.ver_lista_mensajes_enviados', ['usuario' => $usuario, 'mensajes' => $mensajesEnviados]);
    }
    
    public function verMensajeEnviado($id_mensaje)
    {
        // Mostrar un mensaje en específico de la lista de mensajes enviados por el usuario autenticado.
        // Sólo lo puede ver el usuario emisor
        // Mostrar un mensaje en específico de la lista de mensajes recibidos por el usuario autenticado.
        
        if ( ctype_digit($id_mensaje) ) {
            $usuario = Auth::User();
            $mensajeEnviado = DB::table('mensajes')->where('id',$id_mensaje)->first();

            if ( $usuario->id === $mensajeEnviado->usuario_emisor_id ) {
                if ( $mensajeEnviado->estado_emisor === false ) {
                    return redirect()->action('MensajeController@verMensajesEnviados');
                } else {
                    $mensaje = Mensaje::find($mensajeEnviado->id);
                    return view('userview.mensajes.ver_mensaje_enviado', ['usuario' => $usuario, 'mensaje' => $mensaje]);
                }
            }
        }
        return redirect()->action('MensajeController@verMensajesEnviados');
    }
    
    public function borrarMensajeEnviado(Request $request)
    {
        // Cambiar el valor del atributo 'estado_emisor' a "false" en el registro respectivo de la tabla
        // 'mensajes', de modo que el usuario autenticado no pueda acceder a éste nuevamente.
        $usuario = Auth::User();
        $mensaje = Mensaje::find($request['id_mensaje']);

        if ($mensaje->usuario_emisor_id === $usuario->id) {
            $mensaje->estado_emisor = false;
            if ( $mensaje->estado_receptor === false ) {
                $mensaje->delete();
            } else {
                $mensaje->update();
            }
            return redirect()->back()->with(['mensaje' => 'El mensaje ha sido eliminado satisfactoriamente.']);
        }
        return redirect()->back()->with(['mensajeError' => 'Error. Eliminación fallida.']);
    }

    public function borrarMensajesEnviadosMarcados(Request $request)
    {
        // Cambiar el valor del atributo 'estado_emisor' a "false" en los registros respectivos de la tabla
        // 'mensajes', de modo que el usuario autenticado no pueda acceder a éstos nuevamente. 
        $usuario = Auth::User();
        $idMensajesMarcados = $request['chk'];

        if ($idMensajesMarcados) {
            $cantidad = 0;
            foreach ($idMensajesMarcados as $idMensajeMarcado){
                $mensaje = Mensaje::find($idMensajeMarcado);

                if ($mensaje->usuario_emisor_id === $usuario->id) {
                    $mensaje->estado_emisor = false;
                    // Si el usuario receptor también eliminó el mensaje.
                    if ( $mensaje->estado_receptor === false ) {
                        // Entonces el registro del mensaje es eliminado de la BD.
                        $mensaje->delete();
                    } else {
                        // Sino simplemente se cambia el estado del usuario emisor del mensaje.
                        $mensaje->update();
                    }
                    $cantidad++;
                }
            }

            if ( $cantidad === 0 ) {
                return redirect()->back();
            } elseif ( $cantidad === 1 ) {
                return redirect()->back()->with(['mensaje' => 'El mensaje ha sido eliminado satisfactoriamente.']);
            } elseif ( $cantidad > 1 ) {
                return redirect()->back()->with(['mensaje' => $cantidad.' mensajes han sido eliminados satisfactoriamente']);
            }
        }
        return redirect()->back()->with(['mensajeError' => 'No se ha marcado ningún mensaje.']);
    }

    public function escribirMensaje()
    {
        // Mostrar la vista con el formulario para que el usuario escriba el mensaje que desea enviar.
        return view('userview.mensajes.escribir_mensaje.blade.php', ['usuario' => Auth::User()]);
    }

    public function enviarMensaje(Request $request, $id_receptor=null, $origen)
    {
        // Almanacenar el mensaje (escrito por el usuario autenticado) dirigido a otro usuario.
        $emisor = Auth::User();

        if ( $origen === "vista_de_nuevo_mensaje" ) {

             $this->validate($request, [
                'asunto' => 'required|string|max:100',
                'descripcion-mensaje' => 'required|string',
                'nickname' => 'required|string|exists:usuarios,nickname'
            ]);

            // BUSCAR ID DE USUARIO SEGÚN NICKNAME
            $receptor = Usuario::where('nickname', $request['nickname'])->first();

            $mensaje = new Mensaje();
            $mensaje->asunto = $request['asunto'];
            $mensaje->descripcion = $request['descripcion-mensaje'];
            $mensaje->fecha = new DateTime();
            $mensaje->usuario_receptor_id = $receptor->id;
            $mensaje->usuario_emisor_id = $emisor->id; 
            $mensaje->save();

            $idMensaje = $mensaje->id;

            return redirect()->back()->with(['mensajeEnviado' => $idMensaje]);

        } elseif ( $origen === 'vista_de_perfil_de_usuario' ) {

            $this->validate($request, [
                'asunto' => 'required|string|max:100',
                'descripcion-mensaje' => 'required|string'
            ]);

            $mensaje = new Mensaje();
            $mensaje->asunto = $request['asunto'];
            $mensaje->descripcion = $request['descripcion-mensaje'];
            $mensaje->fecha = new DateTime();
            $mensaje->usuario_receptor_id = $id_receptor;
            $mensaje->usuario_emisor_id = $emisor->id; 
            $mensaje->save();

            $idMensaje = $mensaje->id;

            return redirect()->back()->with(['mensajeEnviado' => $idMensaje]);
        }

        return redirect()->back();
    }
}
