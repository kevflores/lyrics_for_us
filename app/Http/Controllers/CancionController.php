<?php

namespace App\Http\Controllers;
use App\Cancion;
use App\Artista;
use App\Disco;
use App\Usuario;
use App\ComentarioCancion;
use App\CancionFavorita;
use App\CancionLetra;
use App\LetraReportada;

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
            // Se actualiza el número de visitas de la canción
            $cancion->visitas = $cancion->visitas + 1;
            $cancion->save();

            // Se obtiene el número de usuarios que han agregado el disco a su lista de favoritos
            $numeroFavoritos = $cancion->usuarios()->count();

            if ( $usuario ) {
                // En caso de que el usuario esté autenticado, se verifica si éste tiene el disco entre sus Favoritos.
                $usuarioFavorito = $cancion->usuarios()
                                            ->where('usuario_id', $usuario->id)
                                            ->where('cancion_id', $cancion->id)->first();
                // También se verifica si el usuario autenticado ha reportado la letra de la canción previamente,
                // y que dicho reporte aún no haya sido atendido por algún administrador.
                $letraReportada = LetraReportada::where('cancion_id', $cancion->id)
                                                ->where('usuario_reportante_id', $usuario->id)
                                                ->whereNull('usuario_admin_id')->get(); 
                if ( $letraReportada->count() > 0 ) {
                    $reporteAtendido = false;
                } else {
                    // El reporte fue atendido, por lo tanto, el usuario puede reportar la letra otra vez.
                    $reporteAtendido = true;
                }
            } else {
                $usuarioFavorito = json_decode (null); // Se crea un objeto vacío.
                $reporteAtendido = NULL; 
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
                // Se actualiza el número de visualizaciones de la letra.
                $letraModificada->visitas = $letraModificada->visitas + 1;
                $letraModificada->save();
                $usuarioModificador = Usuario::find($letraModificada->usuario_id);
            } else {
                $usuarioModificador = null;
                if ( $letra ) {
                    // Se actualiza el número de visualizaciones de la letra provista,
                    // sólo si no ha sido modificada.
                    $letra->visitas = $letra->visitas + 1;
                    $letra->save();
                }
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
                                                          'reporteAtendido' => $reporteAtendido,
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
        $this->validate($request, ['descripcion-comentario' => 'required|string']);

        try {
            $usuario = Auth::User();

            $comentarioCancion = new ComentarioCancion();

            $comentarioCancion->descripcion = $request['descripcion-comentario'];
            $comentarioCancion->fecha = new DateTime();
            $comentarioCancion->cancion_id = $id_cancion;
            $comentarioCancion->usuario_id = $usuario->id; 
            $comentarioCancion->save();

            $mensaje = "El comentario ha sido enviado exitosamente.";
        } catch ( \Illuminate\Database\QueryException $e) {
            return redirect()->back()->with('mensajeError', 'El comentario no pudo ser enviado.');
        }
        return redirect()->back()->with(['mensaje' => $mensaje]);
    }
    
    public function favorita(Request $request)
    {
        // Agregar o quitar como favorita (del usuario autenticado) a una canción.
        $usuario = Auth::user();

        $this->validate($request, ['id_cancion' => 'required|integer']);
        $this->validate($request, ['opcion' => 'required']);

        $cancion = Cancion::find($request['id_cancion']);
        $opcion = $request['opcion'];

        if ( $cancion && ( $opcion === 'agregar' || $opcion === 'eliminar' ) ) {
            if ( $opcion === 'agregar' ) {
                // La canción se debe agregar a la lista de favoritos del usuario.
                try {
                    $cancionFavorita = new CancionFavorita();
                    $cancionFavorita->cancion_id = $cancion->id;
                    $cancionFavorita->usuario_id = $usuario->id;
                    $cancionFavorita->fecha = new DateTime();
                    $cancionFavorita->save();
                } catch ( \Illuminate\Database\QueryException $e) {
                    return redirect()->back()->with('mensajeError', '"'.$cancion->titulo.'" ya está en tu lista de canciones favoritas.');
                }
                return redirect()->back()->with('mensaje', '"'.$cancion->titulo.'" ha sido agregada a tu lista de canciones favoritas.');
            } else {
                // La canción se debe eliminar de la lista de favoritos del usuario.
                try {
                    $cancionFavorita = CancionFavorita::where('cancion_id', $cancion->id)
                                                    ->where('usuario_id', $usuario->id)
                                                    ->first();
                    $cancionFavorita->delete();
                } catch ( \Illuminate\Database\QueryException $e) {
                    return redirect()->back()->with('mensajeError', 'Error en la eliminación de la lista de canciones favoritas.');
                }   
                return redirect()->back()->with('mensaje', '"'.$cancion->titulo.'" ha sido eliminada de tu lista de canciones favoritas.');
            }
        } else {
            return redirect()->back()->with('mensajeError', 'Error.');
        }
    }

    public function guardarLetra(Request $request, $id_cancion)
    {
        // Almacenar la letra (provista por un usuario) de una canción.
        $this->validate($request, ['letra-cancion' => 'required|string']);

        try {
            $letraComprobacion = CancionLetra::where('cancion_id', $id_cancion)->get(); 

            // Si el registro es encontrado, quiere decir que la canción ya posee una letra,
            // así que no se puede registrar otra (a no ser que un usuario apto decida modificarla).
            if ( $letraComprobacion->count() > 0 ) {
                return redirect()->back()->with(['mensajeError' => 'Error. La canción ya posee tiene letra.']);
            } else {
                // El usuario puede registrar la letra de la canción.
                $usuario = Auth::User();
                $letra = new CancionLetra();
                $letra->cancion_id = $id_cancion;
                $letra->usuario_id = $usuario->id; 
                $letra->letra = $request['letra-cancion'];
                $letra->fecha_letra = new DateTime();
                $letra->usuario_proveedor = TRUE;
                $letra->visitas = 0;
                $letra->save();
            }
        } catch (Exception $e) {
            return redirect()->back()->with(['mensajeError' => 'Error.']);
        }
        return redirect()->back()->with(['mensaje' => 'La letra de la canción ha sido registrada exitosamente.']);
    }

    public function reportarLetra(Request $request, $id_cancion)
    {
        // Registrar el reporte realizado sobre la letra de una canción.
        $this->validate($request, ['descripcion-reporte' => 'required|string']);

        try {
            $reportante = Auth::User();

            $reporteComprobacion = LetraReportada::where('cancion_id', $id_cancion)
                                        ->where('usuario_reportante_id', $reportante->id)
                                        ->whereNull('usuario_admin_id')->get(); 

            // Si el registro es encontrado y el campo 'usuario_admin_id' es NULO, entonces el usuario
            // ya había reportado la letra y ésta aún no ha sida atendida.
            if ( $reporteComprobacion->count() > 0 ) {
                return redirect()->back()->with(['mensajeError' => 'Error. El reporte ya fue realizado con anterioridad.']);
            } else {
                // El usuario puede reportar la letra sin problemas, ya que no ha reportado la letra (o lo hizo, pero
                // su reporte ya fue atendido).
                $reporteLetra = new LetraReportada();
                $reporteLetra->descripcion = $request['descripcion-reporte'];
                $reporteLetra->cancion_id = $id_cancion;
                $reporteLetra->fecha_reporte = new DateTime();
                $reporteLetra->usuario_reportante_id = $reportante->id; 
                $reporteLetra->save();
            }
        } catch (Exception $e) {
            return redirect()->back()->with(['mensajeError' => 'Error en el envío del reporte.']);
        }
        return redirect()->back()->with(['mensaje' => 'El reporte ha sido enviado exitosamente.']);
    }
}
