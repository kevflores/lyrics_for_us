<?php

namespace App\Http\Controllers;
use App\Disco;
use App\Artista;
use App\ComentarioDisco;
use App\DiscoFavorito;

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

class DiscoController extends Controller
{
    public function index()
    {
        // Consultar los discos más populares...
        $discos = $this->topDiscos();

        return view('userview.discos.index', ['usuario' => Auth::User(), 
                                                'seleccion' => 'top',
                                                'discos' => $discos]);
    }

    public function verLista($seleccion)
    {
        // Validar que selección sea "top" o "numero" o "a" - "z" o "A" - "Z"
        if ( $seleccion === 'top') {

            // Consultar los más populares...
            $discos = $this->topDiscos();
            return view('userview.discos.index', ['usuario' => Auth::User(), 
                                                'seleccion' => 'top',
                                                'discos' => $discos]);

        } elseif ( $seleccion === 'numero' ) {
            $discos = Disco::where(DB::raw('substring(titulo,1,1)'), '~', '^[0-9]')
                                    ->orderBy('titulo')->paginate(12);
        } elseif (preg_match("/^[a-zA-Z]$/", $seleccion)){
            $mayuscula = Str::upper($seleccion);
            $minuscula = Str::lower($seleccion);

            if ( $seleccion !== 'n' || $seleccion !== 'N' ) {
                $discos = Disco::where(DB::raw('substring(titulo,1,1)'), $mayuscula)
                                ->orWhere(DB::raw('substring(titulo,1,1)'), $minuscula)
                                ->orderBy('titulo')->paginate(12);
            } else {
                // Se consulta la lista de discos cuyos títulos comiencen por N/Ñ
                $discos = Disco::where(DB::raw('substring(titulo,1,1)'), $mayuscula)
                                ->orWhere(DB::raw('substring(titulo,1,1)'), $minuscula)
                                ->orWhere(DB::raw('substring(titulo,1,1)'), 'Ñ')
                                ->orWhere(DB::raw('substring(titulo,1,1)'), 'ñ')
                                ->orderBy('titulo')->paginate(12);
            }
        } else {
            // El usuario (probablemente) insertó un valor NO VÁLIDO en la URL.
            return redirect()->action('DiscoController@index');
        }
        return view('userview.discos.ver_lista', ['usuario' => Auth::User(),
                                                    'seleccion' => $seleccion,
                                                    'discos' => $discos]);
    }

    // Función para consultar el listado de los doce discos más populares en Lyrics For Us.
    function topDiscos() 
    {
        try {
            $consulta = DB::table('discos')->select('id','titulo',
            DB::raw('(visitas * 0.005) + (SELECT COUNT(disco_id) FROM discos_favoritos WHERE disco_id = discos.id) AS puntos'))
            ->orderBy('puntos', 'desc')->orderBy('titulo')->take(12)->get();
        } catch (Exception $e) {
            return NULL;
        }
        return $consulta;
    }
    
    public function verInformacion($id_disco)
    {
        // Mostrar la información de un disco específico.
        $disco = Disco::find($id_disco);
        $usuario = Auth::User();

        if ( $disco ) {
            // Se actualiza el número de visitas del disco
            $disco->visitas = $disco->visitas + 1;
            $disco->save();

            // Se obtienen los datos del artista al cual pertenece el disco.
            $artistaDisco = $disco->artista;
            // Se obtiene el número de usuarios que han agregado el disco a su lista de favoritos
            $numeroFavoritos = $disco->usuarios()->count();

            if ( $usuario ) {
                // En caso de que el usuario esté autenticado, se verifica si éste tiene el disco entre sus Favoritos.
                $usuarioFavorito = $disco->usuarios()
                                            ->where('usuario_id', $usuario->id)
                                            ->where('disco_id', $disco->id)->first();
            } else {
                $usuarioFavorito = json_decode (null); // Se crea un objeto vacío.
            }

            // Canciones incluidas en el disco
            $cancionesDisco = $disco->canciones()->orderBy('numero')->get();

            $comentariosDisco = DB::table('comentarios_discos AS a')
            ->join('usuarios AS b', 'a.usuario_id', '=', 'b.id')
            ->where('a.disco_id', $disco->id)
            ->select('a.id', 'a.descripcion', 'a.fecha', 'a.usuario_id', 'b.nickname', 'b.nombre', 'b.apellido', 'b.imagen AS imagen_usuario')
            ->orderBy('fecha', 'desc')
            ->get();

            return view('userview.discos.ver_informacion', ['usuario' => $usuario,
                                                          'disco' => $disco,
                                                          'artistaDisco' => $artistaDisco,
                                                          'numeroFavoritos' => $numeroFavoritos,
                                                          'usuarioFavorito' => $usuarioFavorito,
                                                          'cancionesDisco' => $cancionesDisco,
                                                          'comentariosDisco' => $comentariosDisco]);
        } else {
            return redirect()->action('DiscoController@index');
        }
    }

    // Método para actualizar la portada del disco.
    public function actualizarImagen(Request $request, $id_disco)
    {
        $this->validate($request, ['imagen' => 'required|mimes:jpg,jpeg,bmp,png|max:5000']);

        $disco = Disco::find($id_disco);
        $imagen = $request->file('imagen');

        // Para obtener la extensión (formato) de la imagen subida.
        $imagenInfo = getimagesize($imagen);
        $extension = image_type_to_extension($imagenInfo[2]);

        // Se establece el nombre de la imagen (ID de usuario seguido de la extensión de la imagen).
        $imagenNombre = $disco->id.$extension;
        $imagenUbicacion = 'img-discos/'.$imagenNombre;

        // Si el disco ya posee una imagen almacenada, entonces dicha imagen es eliminada.
        if ($disco->portada) {
            Storage::Delete('img-discos/'.$disco->portada);
            Storage::Delete('img-discos/thumbnail_'.$disco->portada);
            $disco->portada = null;
            $disco->save();
        }
       
        // Se almacena la nueva imagen del disco.
        $imagenAlmacenada = Storage::put($imagenUbicacion, file_get_contents($imagen->getRealPath()));

        // Si la imagen fue almacenada...
        if($imagenAlmacenada){
            // Se crea el thumbnail de la imagen.
            $thumbnail = Image::make($imagen->getRealPath());
            $thumbnail->resize(intval(100), null, function($constraint) {
                 $constraint->aspectRatio();
            });
            $thumbnail->save(storage_path('app/img-discos'). '/thumbnail_'.$imagenNombre);

            // Se guarda el nombre de la imagen en la BD.
            $disco->portada = $imagenNombre;
            $disco->save();
        }

        $mensaje = "La portada del disco ha sido actualizada.";

        return redirect()->back()->withInput()->with(['mensaje' => $mensaje]);
    }

    public function getImagenDisco($imagenNombre)
    {
        // Se obtiene la portada del disco para mostrarla en pantalla.
        $avatar = Storage::disk('img-discos')->get($imagenNombre);
        return new Response($avatar, 200);
    }
    
    public function comentar(Request $request, $id_disco)
    {
        // Registrar el comentario realizado sobre un disco.
        $this->validate($request, ['descripcion-comentario' => 'required|string']);

        try {
            $usuario = Auth::User();

            $comentarioDisco = new ComentarioDisco();

            $comentarioDisco->descripcion = $request['descripcion-comentario'];
            $comentarioDisco->fecha = new DateTime();
            $comentarioDisco->disco_id = $id_disco;
            $comentarioDisco->usuario_id = $usuario->id; 
            $comentarioDisco->save();

            $mensaje = "El comentario ha sido enviado exitosamente.";
        } catch ( \Illuminate\Database\QueryException $e) {
            return redirect()->back()->with('mensajeError', 'El comentario no pudo ser enviado.');
        }
        return redirect()->back()->with(['mensaje' => $mensaje]);
    }
    
    public function favorito(Request $request)
    {
        // Agregar o quitar como favorito (del usuario autenticado) a un disco.
        $usuario = Auth::user();

        $this->validate($request, ['id_disco' => 'required|integer']);
        $this->validate($request, ['opcion' => 'required']);

        $disco = Disco::find($request['id_disco']);
        $opcion = $request['opcion'];

        if ( $disco && ( $opcion === 'agregar' || $opcion === 'eliminar' ) ) {
            if ( $opcion === 'agregar' ) {
                // El disco se debe agregar a la lista de favoritos del usuario.
                try {
                    $discoFavorito = new DiscoFavorito();
                    $discoFavorito->disco_id = $disco->id;
                    $discoFavorito->usuario_id = $usuario->id;
                    $discoFavorito->fecha = new DateTime();
                    $discoFavorito->save();
                } catch ( \Illuminate\Database\QueryException $e) {
                    return redirect()->back()->with('mensajeError', '"'.$disco->titulo.'" ya está en tu lista de discos favoritos.');
                }
                return redirect()->back()->with('mensaje', '"'.$disco->titulo.'" ha sido agregado a tu lista de discos favoritos.');
            } else {
                // El disco se debe eliminar de la lista de favoritos del usuario.
                try {
                    $discoFavorito = DiscoFavorito::where('disco_id', $disco->id)
                                                    ->where('usuario_id', $usuario->id)
                                                    ->first();
                    $discoFavorito->delete();
                } catch ( \Illuminate\Database\QueryException $e) {
                    return redirect()->back()->with('mensajeError', 'Error en la eliminación de la lista de favoritos.');
                }   
                return redirect()->back()->with('mensaje', '"'.$disco->titulo.'" ha sido eliminado de tu lista de discos favoritos.');
            }
        } else {
            return redirect()->back()->with('mensajeError', 'Error.');
        }
    }
}
