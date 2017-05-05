<?php
namespace App\Http\Controllers;
use App\Usuario;
use App\UsuarioReportado;
use App\ComentarioUsuario;
use App\Artista;
use App\Disco;
use App\Cancion;
use App\CancionLetra;
use App\ArtistaFavorito;
use App\DiscoFavorito;
use App\CancionFavorita;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use Intervention\Image\Facades\Image; // Use this if you want facade style code
//use Intervention\Image\ImageManager // Use this if you don't want facade style code

use DateTime;

class UsuarioController extends Controller
{
    public function indexRegistro()
    {
        // Mostrar la vista para el registro de usuario.
        return view('userview.usuario.registro', ['usuario' => Auth::User()]);
    }

    // Método para registrar un nuevo usuario convencional.
    public function registrar(Request $request)
    {
        $this->validate($request, [
            'nombre' => 'required|string|max:25',
            'apellido' => 'required|string|max:25',
            'nickname' => 'required|unique:usuarios|min:5|max:20',
            'email' => 'required|email|unique:usuarios',
            'password' => 'required|min:4',
            'password-repeat' => 'required'
        ]);

        // Validar que las contraseñas coincidan.
        $this->validate($request, ['password-repeat' => 'same:password']);

        $usuario = new Usuario();

        $usuario->nickname = $request['nickname'];
        $usuario->nombre = $request['nombre'];
        $usuario->apellido = $request['apellido'];
        $usuario->email = $request['email'];
        $usuario->password = bcrypt($request['password']);
        $usuario->categoria_usuario_id = 2; // Categoría = Usuario.
        $usuario->remember_token = $request['_token'];

        $usuario->save();

        Auth::login($usuario);  // Después de registrarse, el usuario es autenticado automáticamente 
                                // para configurar todos sus datos en el submódulo "Configuración".
        return redirect()->route('usuario.configuracion');
    }
    
    public function activarCuenta($codigo)
    {
        // Validar el código para activar la cuenta del usuario.
        return view('userview.usuario.activar_cuenta');
    }
    
    public function indexIngreso()
    {
        // Mostrar vista para el ingreso del usuario al sistema.
        return view ('userview.usuario.ingreso', ['usuario' => Auth::User()]);
    }

    // Método para permitir el ingreso de un usuario al sistema.
    public function ingresar(Request $request)
    {
        if ($request == null) {
            return redirect()->route('userhome');
        }

        // Validar credenciales.
        $this->validate($request, [
            'login' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt(['nickname' => $request['login'], 'password' => $request['password']])) {
            // Se verifica si el login es igual a algún "nickname" con su password correspondiente...
            $mensaje = "¡Hola, ".Auth::User()->nombre." ".Auth::User()->apellido."!";
            return redirect()->route('userhome')->with(['mensaje' => $mensaje]);
        } elseif (Auth::attempt(['email' => $request['login'], 'password' => $request['password']])) {
            // Se verifica si el login es igual a algún "email" con su password correspondiente...
            $mensaje = "¡Hola, ".Auth::User()->nombre." ".Auth::User()->apellido."!";
            return redirect()->route('userhome')->with(['mensaje' => $mensaje]);
        } else {
            $mensaje = "Credenciales incorrectas.";
            return redirect()->back()->withInput()->with(['mensajeError' => $mensaje]);
        }
    }

    public function recuperarPassword()
    {
        // Mostrar vista para ingresar el email o nickname del usuario que desea recuperar su password.
        return view('userview.usuario.recuperar_password', ['usuario' => Auth::User()]);
    }

    public function validarRecuperacion(Request $request)
    {
        // Validar la existencia de la cuenta de usuario, tomando como base el nickname/email ingresado.
    }

    public function activarRecuperacion($codigo)
    {
        // Validar el código necesario para permitir la recuperación de la contraseña.
    }

    public function generarPassword(Request $request, $id_usuario)
    {
        // Almacenar nueva password del usuario.
    }

    // Método para mostrar el perfil de un usuario.        
    public function mostrarPerfil($nickname)
    {
        $usuarioPerfil = Usuario::where('nickname', $nickname)->first(); // Usuario del perfil.
        $usuario = Auth::User(); // Usuario autenticado.
        
        if ( $usuarioPerfil ){

            if ( $usuario ) {
                if ( $usuario->id !== $usuarioPerfil->id ) {
                    // Se actualiza el número de visitas del usuario.
                    $usuarioPerfil->visitas = $usuarioPerfil->visitas + 1;
                    $usuarioPerfil->save();
                }
                // Se comprueba si el usuario autenticado ha reportado al usuario del Perfil con anterioridad,
                // y si dicho reporte aún no ha sido atendido.
                $reporteComprobacion = UsuarioReportado::where('usuario_reportado_id', $usuarioPerfil->id)
                                    ->where('usuario_reportante_id', $usuario->id)
                                    ->whereNull('usuario_admin_id')->get();
            } else {
                // Se actualiza el número de visitas del usuario.
                $usuarioPerfil->visitas = $usuarioPerfil->visitas + 1;
                $usuarioPerfil->save();
                $reporteComprobacion = NULL;
            }
            
            $letrasProvistas = DB::table('canciones_letras AS a')
            ->where('a.usuario_id', $usuarioPerfil->id)
            ->join('canciones AS b', 'a.cancion_id', '=', 'b.id')
            ->select('a.*', 'b.titulo')
            ->orderBy('a.fecha_letra', 'desc')
            ->orderBy('b.titulo', 'asc')
            ->get();

            // Se consultan todos los comentarios escritos en el perfil del usuario.
            $comentariosUsuario = DB::table('comentarios_usuarios AS a')
            ->join('usuarios AS b', 'a.usuario_emisor_id', '=', 'b.id')
            ->where('a.usuario_receptor_id', $usuarioPerfil->id)
            ->select('a.id', 'a.descripcion', 'a.fecha', 'a.usuario_emisor_id', 'b.nickname', 'b.nombre', 'b.apellido', 'b.imagen AS imagen_usuario')
            ->orderBy('fecha', 'desc')
            ->get();

            // Se calculan los puntos obtenidos por sus contribuciones.
            // PUNTOS = 0.005 * (N° de vis. de letras provistas + N° de vis. de letras modificadas).
            $puntosObtenidos = DB::table('canciones_letras')
            ->where('usuario_id', $usuarioPerfil->id)
            ->select(DB::raw('SUM(visitas)*0.005 AS total'))
            ->first();

            return view ('userview.usuario.ver_perfil', ['usuario' => $usuario,
                                                         'usuarioPerfil' => $usuarioPerfil,
                                                         'letrasProvistas' => $letrasProvistas,
                                                         'comentariosUsuario' => $comentariosUsuario,
                                                         'puntosObtenidos' => $puntosObtenidos,
                                                         'reporteComprobacion' => $reporteComprobacion]);
        } 
        else {
            // El usuario no fue encontrado en la BD, por ende, no existe.
            return view ('userview.usuario.ver_perfil', ['usuario' => Auth::User(),
                                                         'usuarioPerfil' => null]);
        }
    }

    // Método para registrar el comentario realizado sobre un ususario.
    public function comentar(Request $request, $id_usuario)
    {
        $this->validate($request, ['descripcion-comentario' => 'required|string']);

        $emisor = Auth::User();

        if ( $emisor ) {
            try {
                $comentarioUsuario = new ComentarioUsuario();
                $comentarioUsuario->descripcion = $request['descripcion-comentario'];
                $comentarioUsuario->fecha = new DateTime();
                $comentarioUsuario->usuario_receptor_id = $id_usuario;
                $comentarioUsuario->usuario_emisor_id = $emisor->id; 
                $comentarioUsuario->save();

                return response()->json(['insertado'=> true, 'comentarioUsuario' => $comentarioUsuario], 200);

            } catch ( \Illuminate\Database\QueryException $e) {
                return response()->json(array('insertado'=> false));
            }
        } else {
            return response()->json(array('insertado'=> false));
        }
    }

    // Método para registrar el reporte realizado sobre un usuario.
    public function reportar(Request $request, $id_usuario)
    {
        $this->validate($request, ['descripcion-reporte' => 'required|string']);
        
        $reportante = Auth::User();

        if ( $reportante ) {
            try {
                $reporteComprobacion = UsuarioReportado::where('usuario_reportado_id', $id_usuario)
                                        ->where('usuario_reportante_id', $reportante->id)
                                        ->whereNull('usuario_admin_id')->get(); 

                // Si el registro es encontrado y el campo 'usuario_admin_id' es NULO, entonces el usuario autenticado
                // ya había reportado al usuario del perfil, y este reporte aún no ha sida atendido.
                if ( $reporteComprobacion->count() > 0 ) {
                    return response()->json(array('reportado'=> false));
                } else {
                    $reporteUsuario = new UsuarioReportado();
                    $reporteUsuario->descripcion = $request['descripcion-reporte'];
                    $reporteUsuario->fecha_reporte = new DateTime();
                    $reporteUsuario->usuario_reportado_id = $id_usuario;
                    $reporteUsuario->usuario_reportante_id = $reportante->id; 
                    $reporteUsuario->save();

                    return response()->json(['reportado'=> true], 200);
                }
            } catch ( \Illuminate\Database\QueryException $e) {
                return response()->json(array('reportado'=> false));
            }
        } else {
            return response()->json(array('reportado'=> false));
        }
    }

    public function verConfiguracion()
    {
        /* Mostrar toda la información del usuario autenticado, de modo que éste pueda
           modificar lo que crea conveniente. */
        return view ('userview.usuario.ver_configuracion', ['usuario' => Auth::User()]);
    }

    // Método para actualizar los datos del usuario autenticado.
    public function actualizarDatos(Request $request)
    {
        $usuario = Auth::User();

        $this->validate($request, [
            'nombre' => 'required|string|max:25',
            'apellido' => 'required|string|max:25',
            'url' => 'url',
            'ubicacion' => 'required|string',
            'resumen' => 'string|max:255'
        ]);

        $usuario->nombre = $request['nombre'];
        $usuario->apellido = $request['apellido'];
        $usuario->ubicacion = $request['ubicacion'];
        $usuario->url = $request['url'];
        $usuario->resumen = $request['resumen'];

        $usuario->save();

        $mensaje = "Los datos han sido actualizados.";
        
        return redirect()->back()->withInput()->with(['mensaje' => $mensaje]);
    }

    // Método para actualizar la imagen del usuario autenticado.
    public function actualizarImagen(Request $request)
    {
        $this->validate($request, ['imagen' => 'required|mimes:jpg,jpeg,bmp,png|max:5000']);

        $usuario = Auth::User();
        $imagen = $request->file('imagen');

        // Para obtener la extensión (formato) de la imagen subida.
        $imagenInfo = getimagesize($imagen);
        $extension = image_type_to_extension($imagenInfo[2]);

        // Se establece el nombre de la imagen (ID de usuario seguido de la extensión de la imagen).
        $imagenNombre = $usuario->id.$extension;
        $imagenUbicacion = 'avatars/'.$imagenNombre;

        // Si el usuario ya posee una imagen almacenada, entonces dicha imagen es eliminada.
        if ($usuario->imagen) {
            Storage::Delete('avatars/'.$usuario->imagen);
            Storage::Delete('avatars/thumbnail_'.$usuario->imagen);
            $usuario->imagen = null;
            $usuario->save();
        }
       
        // Se almacena la nueva imagen del usuario.
        $imagenAlmacenada = Storage::put($imagenUbicacion, file_get_contents($imagen->getRealPath()));

        // Si la imagen fue almacenada...
        if ($imagenAlmacenada){
            // Se crea el thumbnail de la imagen.
            $thumbnail = Image::make($imagen->getRealPath()); // use this if you want facade style code
            $thumbnail->resize(intval(100), null, function($constraint) {
                 $constraint->aspectRatio();
            });
            $thumbnail->save(storage_path('app/avatars'). '/thumbnail_'.$imagenNombre);

            // Se guarda el nombre de la imagen en la BD.
            $usuario->imagen = $imagenNombre;
            $usuario->save();
        }

        $mensaje = "La imagen de perfil ha sido actualizada.";

        return redirect()->back()->withInput()->with(['mensaje' => $mensaje]);
    }

    // Método para actualizar el correo electrónico del usuario autenticado.
    public function actualizarCorreo(Request $request)
    {
        $usuario = Auth::User();
        
        if ( $usuario->email === $request['email'] ) {

            $mensaje = "El correo electrónico introducido es tu correo electrónico actual.";
            return redirect()->back()->withInput()->with(['mensajeError' => $mensaje, 'correoActual' => '1']);

        } else {
            // Validar el correo electrónico insertado del formulario de configuración.
            $this->validate($request, [
                'email' => 'required|email|unique:usuarios',
                'email-repeat' => 'required|same:email',
            ]);

            $usuario->email = $request['email'];
            $usuario->save();
        }

        $mensaje = "El correo electrónico ha sido actualizado.";
        return redirect()->back()->with(['mensaje' => $mensaje]);
    }

    // Método para actualizar la contraseña del usuario autenticado.
    public function actualizarPassword(Request $request)
    {
        $usuario = Auth::User();
        
        $this->validate($request, [
                'password-actual' => 'required',
                'password-new' => 'required|min:4',
                'password-repeat' => 'required',
            ]);
                                    
        // Se valida que la contraseña actual ingresada sea correcta...
        if (Hash::check($request['password-actual'], $usuario->password)) {
            // Validar que las nuevas contraseñas coincidan.
            $this->validate($request, ['password-repeat' => 'same:password-new']);

            $usuario->password = bcrypt($request['password-new']);
            $usuario->save();
        } else {
            $mensaje = "La contraseña actual ingresada es incorrecta.";
            return redirect()->back()->withInput()->with(['mensajeError' => $mensaje]);
        }

        $mensaje = "La contraseña ha sido actualizada.";
        return redirect()->back()->with(['mensaje' => $mensaje]);
    }

    public function getAvatarUsuario($imagenNombre)
    {
        // Se obtiene el avatar/imagen de perfil para mostrarla en pantalla.
        $avatar = Storage::disk('avatars')->get($imagenNombre);
        return new Response($avatar, 200);
    }

    // Método para borrar la imagen de perfil del usuario.
    public function eliminarAvatarUsuario(Request $request)
    {
        if ($request['_token']) {
            // Si la petición proviene del formulario de Configuración.
            $usuario = Auth::User();
            Storage::Delete('avatars/'.$usuario->imagen); // Se elimina la imagen del storage
            Storage::Delete('avatars/thumbnail_'.$usuario->imagen); // Se elimina su thumbnail correspondiente
            $usuario->imagen = null;
            $usuario->save();
            $mensaje = "La imagen de perfil ha sido eliminada.";
            return redirect()->back()->with(['mensaje' => $mensaje]);
        } else {
            $mensaje = "La imagen de perfil no puede ser eliminada.";
            return redirect()->back()->with(['mensajeError' => $mensaje]);
        }
    }

    public function verFavoritos($nickname)
    {
        // Mostrar los favoritos (artistas, discos y canciones) de un usuario.  
        $usuarioFavoritos = DB::table('usuarios')->where('nickname', $nickname)->first();
        
        // Si el usuario existe...
        if ( count($usuarioFavoritos) ){

            $artistasFavoritos = Usuario::find($usuarioFavoritos->id)->artistasFavoritos()->orderBy('nombre')->get();
            
            $discosFavoritos = DB::table('discos_favoritos AS a')
            ->join('discos AS b', 'a.disco_id', '=', 'b.id')
            ->join('artistas AS c', 'b.artista_id', '=', 'c.id')
            ->where('a.usuario_id', $usuarioFavoritos->id)
            ->select('a.id', 'b.id AS disco_id', 'b.titulo', 'c.nombre AS nombreArtista', 'c.id AS artista_id')
            ->orderBy('b.titulo')
            ->orderBy('c.nombre')
            ->get();

            $cancionesFavoritas = Usuario::find($usuarioFavoritos->id)->cancionesFavoritas()->orderBy('titulo')->get();

            return view ('userview.usuario.ver_favoritos', ['usuario' => Auth::User(),
                                                         'usuarioFavoritos' => $usuarioFavoritos,
                                                         'artistasFavoritos' => $artistasFavoritos,
                                                         'discosFavoritos' => $discosFavoritos,
                                                         'cancionesFavoritas' => $cancionesFavoritas]);
        } 
        // Sino...
        else {
            echo 'Mostrar vista con mensaje de "Usuario No Existe"';
            // return view ('userview.usuario.ver_perfil', ['usuario' => Auth::User()]);
        }
    }

    public function eliminarFavorito (Request $request, $tipo=null, $id_favorito=null)
    {
        $this->validate($request, ['tipo' => 'required', 'id_favorito' => 'required|integer']);

        $usuario = Auth::user();

        if ( $usuario ) {
            $tipo = $request['tipo'];
            $id_favorito = $request['id_favorito'];

            switch ($tipo) {
                case "artista":
                    $artistaFavorito = ArtistaFavorito::find($id_favorito);
                    if ( $artistaFavorito ) {
                        if ( $artistaFavorito->usuario_id === $usuario->id ) {
                            $nombreArtista = Artista::find($artistaFavorito->artista_id);
                            $artistaFavorito->delete();
                            return response()->json(['eliminado'=> true, 'tipo' => 'artista', 'id' => $id_favorito, 'mensaje' => $nombreArtista->nombre.' ya no forma parte de tus artistas favoritos.'], 200);
                        } else {
                            return response()->json(array('reportado'=> false));
                        }
                    }
                    break; 
                case "disco":
                    $discoFavorito = DiscoFavorito::find($id_favorito);
                    if ( $discoFavorito ) {
                        if ( $discoFavorito->usuario_id === $usuario->id ) {
                            $disco = Disco::find($discoFavorito->disco_id);
                            $discoFavorito->delete();
                            return response()->json(['eliminado'=> true, 'tipo' => 'disco', 'id' => $id_favorito, 'mensaje' => '"'.$disco->titulo.'" ya no forma parte de sus discos favoritos.'], 200);
                        } else {
                            return response()->json(array('reportado'=> false));
                        }
                    }
                    break;
                case "cancion":
                    $cancionFavorita = CancionFavorita::find($id_favorito);
                    if ( $cancionFavorita ) {
                        if ( $cancionFavorita->usuario_id === $usuario->id ) {
                            $cancion = Cancion::find($cancionFavorita->cancion_id);
                            $cancionFavorita->delete();
                            return response()->json(['eliminado'=> true, 'tipo' => 'cancion', 'id' => $id_favorito, 'mensaje' => '"'.$cancion->titulo.'" ya no forma parte de sus canciones favoritas.'], 200);
                        } else {
                            return response()->json(array('reportado'=> false));
                        }
                    }
                    break;
            }
        }
        return response()->json(array('reportado'=> false));
    }


    public function escribirMensaje($id_usuario)
    {
        // Mostrar formulario para redactar el mensaje a enviar a otro usuario.

        // NOTA: En lugar de usar este método, se podría usar el método de
        // MensajeController.
    }

    // Método para permitir el cierre de la sesión del usuario autenticado.
    public function salir()
    {
        Auth::logout();
        return redirect()->route('userhome');
    }
}
