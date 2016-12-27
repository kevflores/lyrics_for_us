<?php
namespace App\Http\Controllers;
use App\Usuario;
use App\UsuarioReportado;
use App\ComentarioUsuario;
use App\Artista;
use App\Disco;
use App\Cancion;
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
            $mensaje = "¡Bienvenido, ".Auth::User()->nombre." ".Auth::User()->apellido."!";
            return redirect()->route('userhome')->with(['mensaje' => $mensaje]);
        } elseif (Auth::attempt(['email' => $request['login'], 'password' => $request['password']])) {
            // Se verifica si el login es igual a algún "email" con su password correspondiente...
            $mensaje = "¡Bienvenido, ".Auth::User()->nombre." ".Auth::User()->apellido."!";
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
        $usuarioPerfil = DB::table('usuarios')->where('nickname', $nickname)->first();
        
        if ($usuarioPerfil){

            // Se consulta el listado de canciones, cuyas letras fueron provistas por el usuario del perfil.
            $letrasProvistas = DB::table('canciones')
            ->where('canciones.usuario_id', $usuarioPerfil->id)
            ->select('canciones.*', 'canciones.id AS cancion_id')
            ->orderBy('fecha_letra', 'desc')
            ->orderBy('canciones.titulo', 'asc')
            ->get();

            // Se consultan todos los comentarios escritos en el perfil del usuario.
            $comentariosUsuario = DB::table('comentarios_usuarios AS a')
            ->join('usuarios AS b', 'a.usuario_emisor_id', '=', 'b.id')
            ->where('a.usuario_receptor_id', $usuarioPerfil->id)
            ->select('a.id', 'a.descripcion', 'a.fecha', 'a.usuario_emisor_id', 'b.nickname', 'b.nombre', 'b.apellido', 'b.imagen AS imagen_usuario')
            ->orderBy('fecha', 'desc')
            ->get();

            return view ('userview.usuario.ver_perfil', ['usuario' => Auth::User(),
                                                         'usuarioPerfil' => $usuarioPerfil,
                                                         'letrasProvistas' => $letrasProvistas,
                                                         'comentariosUsuario' => $comentariosUsuario]);
        } 
        else {
            return view ('userview.usuario.ver_perfil', ['usuario' => Auth::User(),
                                                         'usuarioPerfil' => $usuarioPerfil]);
        }
    }

    // Método para registrar el comentario realizado sobre un ususario.
    public function comentar(Request $request, $id_usuario)
    {
        $this->validate($request, ['descripcion-comentario' => 'required|string']);

        $emisor = Auth::User();

        $comentarioUsuario = new ComentarioUsuario();

        $comentarioUsuario->descripcion = $request['descripcion-comentario'];
        $comentarioUsuario->fecha = new DateTime();
        $comentarioUsuario->usuario_receptor_id = $id_usuario;
        $comentarioUsuario->usuario_emisor_id = $emisor->id; 

        $comentarioUsuario->save();

        $mensaje = "El comentario ha sido enviado exitosamente.";

        return redirect()->back()->with(['mensaje' => $mensaje]);
    }

    // Método para registrar el reporte realizado sobre un usuario.
    public function reportar(Request $request, $id_usuario)
    {
        $this->validate($request, ['descripcion-reporte' => 'required|string']);

        $reportante = Auth::User();

        $reporteUsuario = new UsuarioReportado();

        $reporteUsuario->descripcion = $request['descripcion-reporte'];
        $reporteUsuario->fecha_reporte = new DateTime();
        $reporteUsuario->usuario_reportado_id = $id_usuario;
        $reporteUsuario->usuario_reportante_id = $reportante->id; 

        $reporteUsuario->save();

        $mensaje = "El reporte ha sido enviado exitosamente.";

        return redirect()->back()->with(['mensaje' => $mensaje]);
    }

    public function verConfiguracion(){
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
        if($imagenAlmacenada){
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

            $mensaje = "El correo electrónico introducido es su correo electrónico actual.";
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
            Storage::Delete('avatars/'.$usuario->imagen);
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
        $usuario = Auth::user();

        $this->validate($request, ['tipo' => 'required', 'id_favorito' => 'required|integer']);

        $tipo = $request['tipo'];
        $id_favorito = $request['id_favorito'];

        switch ($tipo) {
            case "artista":
                $artistaFavorito = ArtistaFavorito::find($id_favorito);
                if ( $artistaFavorito->usuario_id === $usuario->id ) {
                    $nombreArtista = Artista::find($artistaFavorito->artista_id);
                    $artistaFavorito->delete();
                    return redirect()->back()->with('mensaje', $nombreArtista->nombre.' ya no forma parte de sus artistas favoritos.');
                } else {
                    return redirect()->back()->with('mensajeError', 'Eliminación fallida.');
                }
                break;
            case "disco":
                $discoFavorito = DiscoFavorito::find($id_favorito);
                if ( $discoFavorito->usuario_id === $usuario->id ) {
                    $disco = Disco::find($discoFavorito->disco_id);
                    $discoFavorito->delete();
                    return redirect()->back()->with('mensaje', '"'.$disco->titulo.'" ya no forma parte de sus discos favoritos.');
                } else {
                    return redirect()->back()->with('mensajeError', 'Eliminación fallida.');
                }
                break;
            case "cancion":
                $cancionFavorita = CancionFavorita::find($id_favorito);
                if ( $cancionFavorita->usuario_id === $usuario->id ) {
                    $cancion = Cancion::find($cancionFavorita->cancion_id);
                    $cancionFavorita->delete();
                    return redirect()->back()->with('mensaje', '"'.$cancion->titulo.'" ya no forma parte de sus canciones favoritas.');
                } else {
                    return redirect()->back()->with('mensajeError', 'Eliminación fallida.');
                }
                break;
        }

        return redirect()->back()->with('mensajeError', 'Eliminación fallida.');

        /*
        $usuario = Auth::user();

        $this->validate($request, [
            'tipo' => 'required',
            'artista' => 'required'
        ]);

        $tipo = $request['tipo'];
        $id_favorito = $request['artista'];

        switch ($tipo) {
            case "artista":
                $artistaFavorito = ArtistaFavorito::where('id', $id_favorito)->first();
                if ( $artistaFavorito->usuario_id === $usuario->id ) {
                    $artistaFavorito->delete();
                } else {
                    return redirect()->back();
                }
                break;
            case "disco":
                break;
            case "cancion":
                break;
            default:
                echo "Tipo?";
        }
        return response()->json(['message' => 'Eliminado'], 200);
        */
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
