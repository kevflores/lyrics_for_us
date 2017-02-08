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
        // Mostrar la vista con todas las opciones disponibles para seleccionar a un disco.

        // Consultar los discos más populares...
        $discos = null;

        return view('userview.discos.index', ['usuario' => Auth::User(), 
                                                'seleccion' => 'top',
                                                'discos' => $discos]);
    }

    public function verLista($seleccion)
    {
        // Mostrar la lista de discos asociados a la selección del usuario.

        // Validar que selección sea "top" o "numero" o "a" - "z" o "A" - "Z"
        if ( $seleccion === 'top') {

            // Consultar los más populares...
            $discos = null;

        } elseif ( $seleccion === 'numero' ) {
            $discos = Disco::where(DB::raw('substring(titulo,1,1)'), '~', '^[0-9]')
                                    ->orderBy('titulo')->paginate(10);
        } elseif (preg_match("/^[a-zA-Z]$/", $seleccion)){
            $mayuscula = Str::upper($seleccion);
            $minuscula = Str::lower($seleccion);

            if ( $seleccion !== 'n' || $seleccion !== 'N' ) {
                $discos = Disco::where(DB::raw('substring(titulo,1,1)'), $mayuscula)
                                ->orWhere(DB::raw('substring(titulo,1,1)'), $minuscula)
                                ->orderBy('titulo')->paginate(10);
            } else {
                // Se consulta la lista de discos cuyos títulos comiencen por N/Ñ
                $discos = Disco::where(DB::raw('substring(titulo,1,1)'), $mayuscula)
                                ->orWhere(DB::raw('substring(titulo,1,1)'), $minuscula)
                                ->orWhere(DB::raw('substring(titulo,1,1)'), 'Ñ')
                                ->orWhere(DB::raw('substring(titulo,1,1)'), 'ñ')
                                ->orderBy('titulo')->paginate(10);
            }
        } else {
            // El usuario (probablemente) insertó un valor NO VÁLIDO en la URL.
            return redirect()->action('DiscoController@index');
        }
        return view('userview.discos.ver_lista', ['usuario' => Auth::User(),
                                                    'seleccion' => $seleccion,
                                                    'discos' => $discos]);
    }
    
    public function verInformacion($id_disco)
    {
        // Mostrar la información de un disco específico.
        $disco = Disco::find($id_disco);
        $usuario = Auth::User();

        if ( $disco ) {
            // Se obtienen los datos del artistas al cual pertenece el disco.
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

    public function getImagenDisco($imagenNombre)
    {
        // Se obtiene la portada del disco para mostrarla en pantalla.
        $avatar = Storage::disk('img-discos')->get($imagenNombre);
        return new Response($avatar, 200);
    }
    
    public function comentar(Request $request, $id_disco)
    {
        // Registrar el comentario realizado sobre un disco.
    }
    
    public function favorito($id_disco)
    {
        // Agregar o quitar como favorito (del usuario autenticado) a un disco.
    }
}
