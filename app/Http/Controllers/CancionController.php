<?php

namespace App\Http\Controllers;
use App\Cancion;
use App\Artista;
use App\Disco;
use App\Usuario;
use App\ComentarioCancion;
use App\CancionFavorita;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

use DateTime;

class CancionController extends Controller
{
    public function index()
    {
        // Mostrar la vista con todas las opciones disponibles para seleccionar a una canción.
        // Consultar las canciones más populares... y REUTILIZAR código en $seleccion === 'top'
        $canciones = null;

        return view('userview.canciones.index', ['usuario' => Auth::User(), 
                                                'seleccion' => 'top',
                                                'canciones' => $canciones]);
    }

    public function verLista($seleccion)
    {
        // Mostrar la lista de canciones asociadas a la selección del usuario.
        if ( $seleccion === 'top') {

            // Consultar las más populares... REUTILIZAR código de index();
            $canciones = null;

        } elseif ( $seleccion === 'numero' ) {
            $canciones = Cancion::where(DB::raw('substring(titulo,1,1)'), '~', '^[0-9]')
                                    ->orderBy('titulo')->paginate(10);
        } elseif (preg_match("/^[a-zA-Z]$/", $seleccion)){
            $mayuscula = Str::upper($seleccion);
            $minuscula = Str::lower($seleccion);

            if ( $seleccion !== 'n' || $seleccion !== 'N' ) {
                $canciones = Cancion::where(DB::raw('substring(titulo,1,1)'), $mayuscula)
                                ->orWhere(DB::raw('substring(titulo,1,1)'), $minuscula)
                                ->orderBy('titulo')->paginate(10);
            } else {
                // Se consulta la lista de discos cuyos títulos comiencen por N/Ñ
                $canciones = Cancion::where(DB::raw('substring(titulo,1,1)'), $mayuscula)
                                ->orWhere(DB::raw('substring(titulo,1,1)'), $minuscula)
                                ->orWhere(DB::raw('substring(titulo,1,1)'), 'Ñ')
                                ->orWhere(DB::raw('substring(titulo,1,1)'), 'ñ')
                                ->orderBy('titulo')->paginate(10);
            }
        } else {
            // El usuario (probablemente) insertó un valor NO VÁLIDO en la URL.
            return redirect()->action('CancionController@index');
        }
        return view('userview.canciones.ver_lista', ['usuario' => Auth::User(),
                                                    'seleccion' => $seleccion,
                                                    'canciones' => $canciones]);
    }
    
    public function verInformacion($id_cancion)
    {
        // Mostrar la información de una canción.
        $cancion = Cancion::find($id_cancion);
        $usuario = Auth::User();

        if ( $cancion ) {
            // Se obtiene el número de usuarios que han agregado el disco a su lista de favoritos
            $numeroFavoritos = $cancion->usuarios()->count();

            if ( $usuario ) {
                // En caso de que el usuario esté autenticado, se verifica si éste tiene el disco entre sus Favoritos.
                $usuarioFavorito = $cancion->usuarios()
                                            ->where('usuario_id', $usuario->id)
                                            ->where('cancion_id', $cancion->id)->first();
            } else {
                $usuarioFavorito = json_decode (null); // Se crea un objeto vacío.
            }

            // Se obtiene el listado de los artistas principales que participan en la canción.
            $artistasPrincipales = $cancion->artistas()->where('invitado', false)->orderBy('artistas.nombre')->get();

            // Se obtiene el listado de los artistas que participan como invitados en la canción.
            $artistasInvitados = $cancion->artistas()->where('invitado', true)->orderBy('artistas.nombre')->get();


            // Se busca la letra de la canción
            $letra = $cancion->letra()->where('usuario_proveedor', 'true')->first();
            // Si hay letra, entonces hay un usuario proveedor
            if ( $letra ) {
                $usuarioProveedor = Usuario::find($letra->usuario_id);
            } else {
                $usuarioProveedor = null;
            }
            // Se busca la letra modificada de la canción
            $letraModificada = $cancion->letra()->where('usuario_proveedor', 'false')->first();
            // Si hay letra, entonces hay un usuario modificador
            if ( $letraModificada ) {
                $usuarioModificador = Usuario::find($letraModificada->usuario_id);
            } else {
                $usuarioModificador = null;
            }

            $comentariosCancion = DB::table('comentarios_canciones AS a')
            ->join('usuarios AS b', 'a.usuario_id', '=', 'b.id')
            ->where('a.cancion_id', $cancion->id)
            ->select('a.id', 'a.descripcion', 'a.fecha', 'a.usuario_id', 'b.nickname', 'b.nombre', 'b.apellido', 'b.imagen AS imagen_usuario')
            ->orderBy('fecha', 'desc')
            ->get();

            return view('userview.canciones.ver_informacion', ['usuario' => $usuario,
                                                          'cancion' => $cancion,
                                                          'numeroFavoritos' => $numeroFavoritos,
                                                          'usuarioFavorito' => $usuarioFavorito,
                                                          'artistasPrincipales' => $artistasPrincipales,
                                                          'artistasInvitados' => $artistasInvitados,
                                                          'letra' => $letra,
                                                          'letraModificada' => $letraModificada,
                                                          'usuarioProveedor' => $usuarioProveedor,
                                                          'usuarioModificador' => $usuarioModificador,
                                                          'comentariosCancion' => $comentariosCancion]);
        } else {
            return redirect()->action('CancionController@index');
        }
    }

    // Método para actualizar la portada de la canción (en caso de que tenga).
    public function actualizarImagen(Request $request, $id_cancion)
    {
        $this->validate($request, ['imagen' => 'required|mimes:jpg,jpeg,bmp,png|max:5000']);

        $cancion = Cancion::find($id_cancion);
        $imagen = $request->file('imagen');

        // Para obtener la extensión (formato) de la imagen subida.
        $imagenInfo = getimagesize($imagen);
        $extension = image_type_to_extension($imagenInfo[2]);

        // Se establece el nombre de la imagen (ID de usuario seguido de la extensión de la imagen).
        $imagenNombre = $cancion->id.$extension;
        $imagenUbicacion = 'img-canciones/'.$imagenNombre;

        // Si el disco ya posee una imagen almacenada, entonces dicha imagen es eliminada.
        if ($cancion->portada) {
            Storage::Delete('img-canciones/'.$cancion->portada);
            Storage::Delete('img-canciones/thumbnail_'.$cancion->portada);
            $cancion->portada = null;
            $cancion->save();
        }
       
        // Se almacena la nueva imagen de la canción.
        $imagenAlmacenada = Storage::put($imagenUbicacion, file_get_contents($imagen->getRealPath()));

        // Si la imagen fue almacenada...
        if($imagenAlmacenada){
            // Se crea el thumbnail de la imagen.
            $thumbnail = Image::make($imagen->getRealPath());
            $thumbnail->resize(intval(100), null, function($constraint) {
                 $constraint->aspectRatio();
            });
            $thumbnail->save(storage_path('app/img-canciones'). '/thumbnail_'.$imagenNombre);

            // Se guarda el nombre de la imagen en la BD.
            $cancion->portada = $imagenNombre;
            $cancion->save();
        }

        $mensaje = "La portada de la canción ha sido actualizada.";

        return redirect()->back()->withInput()->with(['mensaje' => $mensaje]);
    }

    public function getImagenCancion($imagenNombre)
    {
        // Se obtiene la portada de la canción para mostrarla en pantalla.
        $avatar = Storage::disk('img-canciones')->get($imagenNombre);
        return new Response($avatar, 200);
    }
    
    public function comentar(Request $request, $id_cancion)
    {
        // Registrar el comentario realizado sobre una canción.
    }
    
    public function favorita($id_cancion)
    {
        // Agregar o quitar como favorita (del usuario autenticado) a una canción.
    }

    public function guardarLetra(Request $request, $id_cancion)
    {
        // Almacenar la letra (provista por un usuario) de una canción.
    }

    public function reportarLetra(Request $request, $id_cancion)
    {
        // Registrar el reporte realizado sobre la letra de una canción.
    }
}
