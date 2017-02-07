<?php

namespace App\Http\Controllers;
use App\Artista;
use App\Disco;
use App\ComentarioArtista;
use App\ArtistaFavorito;

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

class ArtistaController extends Controller
{
    public function index()
    {
        // Mostrar la vista con todas las opciones disponibles para seleccionar a un artista.

        // Consultar los más populares...
        $artistas = null;

        return view('userview.artistas.index', ['usuario' => Auth::User(), 
                                                'seleccion' => 'top',
                                                'artistas' => $artistas]);
    }

    public function verLista($seleccion)
    {
        // Mostrar la lista de artistas asociados a la selección del usuario.

        // Validar que selección sea "top" o "#" o "a" - "z" o "A" - "Z" o "nn" o "NN"
        // Mostrar msj de error en caso que de que sea distinto...
        if ( $seleccion === 'top') {

            // Consultar los mas populares...
            $artistas = null;

        } elseif ( $seleccion === 'numero' ) {
            $artistas = Artista::where(DB::raw('substring(nombre,1,1)'), '~', '^[0-9]')
                                    ->orderBy('nombre')->paginate(10);
        } elseif (preg_match("/^[a-zA-Z]$/", $seleccion)){
            $mayuscula = Str::upper($seleccion);
            $minuscula = Str::lower($seleccion);

            if ( $seleccion !== 'n' || $seleccion !== 'N' ) {
                $artistas = Artista::where(DB::raw('substring(nombre,1,1)'), $mayuscula)
                                ->orWhere(DB::raw('substring(nombre,1,1)'), $minuscula)
                                ->orderBy('nombre')->paginate(10);
            } else {
                // Se consulta la lista de artistas cuyos nombres comiencen por N/Ñ
                $artistas = Artista::where(DB::raw('substring(nombre,1,1)'), $mayuscula)
                                ->orWhere(DB::raw('substring(nombre,1,1)'), $minuscula)
                                ->orWhere(DB::raw('substring(nombre,1,1)'), 'Ñ')
                                ->orWhere(DB::raw('substring(nombre,1,1)'), 'ñ')
                                ->orderBy('nombre')->paginate(10);
            }
        } else {
            // El usuario (probablemente) insertó un valor NO VÁLIDO en la URL.
            return redirect()->action('ArtistaController@index');
        }
        return view('userview.artistas.ver_lista', ['usuario' => Auth::User(),
                                                    'seleccion' => $seleccion,
                                                    'artistas' => $artistas]);
    }
    
    public function verInformacion($id_artista)
    {
        // Mostrar la información de un artista específico.
        $artista = Artista::find($id_artista);
        $usuario = Auth::User();

        if ( $artista ) {

            $nombresArtista = $artista->nombresAlternativos;

            // Se obtiene el número de usuarios que han agregado al Artista a sus Favoritos
            $numeroFavoritos = $artista->usuarios()->count();

            if ( $usuario ) {
                // En caso de que el usuario esté autenticado, se verifica
                // si dicho usuario tiene al Artista en sus Favoritos.
                $usuarioFavorito = $artista->usuarios()
                                            ->where('usuario_id', $usuario->id)
                                            ->where('artista_id', $artista->id)->first();
            } else {
                $usuarioFavorito = json_decode (null); // Se crea un objeto vacío.
            }

            // Discos propios
            $discosArtista = $artista->discos()->orderBy('fecha', 'desc')->get();

            // Canciones no incluidas en discos
            $cancionesArtistaSinDisco = $artista->canciones->where('pivot.invitado', FALSE)->where('disco_id', NULL);

            // Colaboraciones como artista invitado con otros artistas
            $cancionesArtistaInvitado = $artista->canciones->where('pivot.invitado', TRUE);

            // Colaboraciones como artista principal, pero en un disco que no pertenezca al artista
            $cancionesArtistaPrincipalEnOtroDisco = DB::table('canciones AS a')
            ->join('canciones_artistas AS b', 'a.id', '=', 'b.cancion_id')
            ->join('discos AS c', 'a.disco_id', '=', 'c.id')
            ->where('b.invitado', FALSE)
            ->where('b.artista_id', $artista->id)
            ->where('c.artista_id', '<>', $artista->id)
            ->select('a.id', 'a.titulo')
            ->orderBy('fecha', 'desc')
            ->get();

            $comentariosArtista = DB::table('comentarios_artistas AS a')
            ->join('usuarios AS b', 'a.usuario_id', '=', 'b.id')
            ->where('a.artista_id', $artista->id)
            ->select('a.id', 'a.descripcion', 'a.fecha', 'a.usuario_id', 'b.nickname', 'b.nombre', 'b.apellido', 'b.imagen AS imagen_usuario')
            ->orderBy('fecha', 'desc')
            ->get();

            // Se verifica si el artista posee discografía.
            if ( count($discosArtista) || count($cancionesArtistaSinDisco) || count($cancionesArtistaInvitado) || count($cancionesArtistaPrincipalEnOtroDisco) ) {
                $sinDiscografia = false;
            } else {
                $sinDiscografia = true;
            }

            return view('userview.artistas.ver_informacion', ['usuario' => $usuario,
                                                          'artista' => $artista,
                                                          'nombresArtista' => $nombresArtista,
                                                          'numeroFavoritos' => $numeroFavoritos,
                                                          'discosArtista' => $discosArtista,
                                                          'cancionesArtistaSinDisco' => $cancionesArtistaSinDisco,
                                                          'cancionesArtistaInvitado' => $cancionesArtistaInvitado,
                                                          'cancionesArtistaPrincipalEnOtroDisco' => $cancionesArtistaPrincipalEnOtroDisco,
                                                          'usuarioFavorito' => $usuarioFavorito,
                                                          'sinDiscografia' => $sinDiscografia,
                                                          'comentariosArtista' => $comentariosArtista]);
        } else {
            return redirect()->action('ArtistaController@index');
        }

        
    }

    // Método para actualizar la imagen del artista.
    public function actualizarImagen(Request $request, $id_artista)
    {
        $this->validate($request, ['imagen' => 'required|mimes:jpg,jpeg,bmp,png|max:5000']);

        $artista = Artista::find($id_artista);
        $imagen = $request->file('imagen');

        // Para obtener la extensión (formato) de la imagen subida.
        $imagenInfo = getimagesize($imagen);
        $extension = image_type_to_extension($imagenInfo[2]);

        // Se establece el nombre de la imagen (ID de usuario seguido de la extensión de la imagen).
        $imagenNombre = $artista->id.$extension;
        $imagenUbicacion = 'img-artistas/'.$imagenNombre;

        // Si el artista ya posee una imagen almacenada, entonces dicha imagen es eliminada.
        if ($artista->imagen) {
            Storage::Delete('img-artistas/'.$artista->imagen);
            Storage::Delete('img-artistas/thumbnail_'.$artista->imagen);
            $artista->imagen = null;
            $artista->save();
        }
       
        // Se almacena la nueva imagen del artista.
        $imagenAlmacenada = Storage::put($imagenUbicacion, file_get_contents($imagen->getRealPath()));

        // Si la imagen fue almacenada...
        if($imagenAlmacenada){
            // Se crea el thumbnail de la imagen.
            $thumbnail = Image::make($imagen->getRealPath()); // use this if you want facade style code
            $thumbnail->resize(intval(100), null, function($constraint) {
                 $constraint->aspectRatio();
            });
            $thumbnail->save(storage_path('app/img-artistas'). '/thumbnail_'.$imagenNombre);

            // Se guarda el nombre de la imagen en la BD.
            $artista->imagen = $imagenNombre;
            $artista->save();
        }

        $mensaje = "La imagen del artista ha sido actualizada.";

        return redirect()->back()->withInput()->with(['mensaje' => $mensaje]);
    }

    public function getImagenArtista($imagenNombre)
    {
        // Se obtiene la imagen del artista para mostrarla en pantalla.
        $avatar = Storage::disk('img-artistas')->get($imagenNombre);
        return new Response($avatar, 200);
    }
    
    public function comentar(Request $request, $id_artista)
    {
        // Registrar el comentario realizado sobre un artista.
        $this->validate($request, ['descripcion-comentario' => 'required|string']);

        $usuario = Auth::User();

        $comentarioArtista = new ComentarioArtista();

        $comentarioArtista->descripcion = $request['descripcion-comentario'];
        $comentarioArtista->fecha = new DateTime();
        $comentarioArtista->artista_id = $id_artista;
        $comentarioArtista->usuario_id = $usuario->id; 

        $comentarioArtista->save();

        $mensaje = "El comentario ha sido enviado exitosamente.";

        return redirect()->back()->with(['mensaje' => $mensaje]);
    }
    
    public function favorito(Request $request)
    {
        // Agregar o quitar como favorito (del usuario autenticado) a un artista específico.
        $usuario = Auth::user();

        $this->validate($request, ['id_artista' => 'required|integer']);
        $this->validate($request, ['opcion' => 'required']);

        $artista = Artista::find($request['id_artista']);
        $opcion = $request['opcion'];

        if ( $artista && ( $opcion === 'agregar' || $opcion === 'eliminar' ) ) {
            if ( $opcion === 'agregar' ) {
                // El artista se debe agregar a la lista de favoritos del usuario.
                try {
                    $artistaFavorito = new ArtistaFavorito();
                    $artistaFavorito->artista_id = $artista->id;
                    $artistaFavorito->usuario_id = $usuario->id;
                    $artistaFavorito->fecha = new DateTime();
                    $artistaFavorito->save();
                } catch ( \Illuminate\Database\QueryException $e) {
                    return redirect()->back()->with('mensajeError', $artista->nombre.' ya está en tu lista de artistas favoritos.');
                }
                return redirect()->back()->with('mensaje', $artista->nombre.' ha sido agregado a tu lista de artistas favoritos.');
            } else {
                // El artista se debe eliminar de la lista de favoritos del usuario.
                $artistaFavorito = ArtistaFavorito::where('artista_id', $artista->id)
                                                    ->where('usuario_id', $usuario->id)
                                                    ->first();
                $artistaFavorito->delete();
                return redirect()->back()->with('mensaje', $artista->nombre.' ha sido eliminado de tu lista de artistas favoritos.');
            }
        } else {
            return redirect()->back()->with('mensajeError', 'Error.');
        }

    }
    
}
