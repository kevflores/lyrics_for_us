<?php
namespace App\Http\Controllers;
use App\Usuario;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function indexRegistro()
    {
        // Mostrar la vista para el registro de usuario.
        return view('userview.usuario.registro', ['usuario' => Auth::User()]);
    }

    public function registrar(Request $request)
    {
        // Validar el registro de usuario.
        $this->validate($request, [
            'nombre' => 'required|string|max:45',
            'apellido' => 'required|string|max:45',
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
        return view('userview.home', ['usuario' => Auth::User()]);
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

    public function mostrarPerfil($nickname)
    {
        // Mostrar el perfil de un usuario.        
        $usuarioPerfil = DB::table('usuarios')->where('nickname', $nickname)->first();

        // Si el usuario existe...
        if ($usuarioPerfil){


            return view ('userview.usuario.ver_perfil', [
                            'usuario' => Auth::User(),
                            'usuarioPerfil' => $usuarioPerfil,
                            
                        ]);
        } 
        // Sino...
        else {
            echo 'Mostrar vista con mensaje de "Usuario No Existe"';
            // return view ('userview.usuario.ver_perfil', ['usuario' => Auth::User()]);
        }
        
    }


    public function comentar(Request $request, $id_usuario)
    {
        // Registrar el comentario realizado sobre un ususario.
        echo "Agregar comentario";
    }

    public function reportar($id_usuario)
    {
        // Registrar el reporte realizado sobre un usuario.
    }

    public function verConfiguracion(){
        // Mostrar toda la información del usuario autenticado, de modo que éste pueda
        // modificar lo que crea conveniente.
        return view ('userview.usuario.ver_configuracion', ['usuario' => Auth::User()]);
    }

    public function actualizarDatos(Request $request)
    {
        // Actualizar los datos del usuario autenticado.

        $usuario = Auth::User();

        // Validar los datos del formulario de configuración.
        $this->validate($request, [
            'nombre' => 'required|string|max:45',
            'apellido' => 'required|string|max:45',
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

    public function actualizarImagen(Request $request)
    {
        // Actualizar la imagen del usuario autenticado.
                
        $this->validate($request, ['imagen' => 'required|mimes:jpg,jpeg,bmp,png|max:1000']);

        $usuario = Auth::User();
        $imagen = $request->file('imagen');

        // Para obtener la extensión (formato) de la imagen subida.
        $imagenInfo = getimagesize($imagen);
        $extension = image_type_to_extension($imagenInfo[2]);

        // Se establece el nombre de la imagen (ID de usuario seguido de la extensión de la imagen).
        $imagenNombre = $usuario->id.$extension;
        $imagenUbicacion = 'avatars/'.$imagenNombre;

        // Si el usuario tiene una imagen almacenada, entonces dicha imagen es eliminada.
        if ($usuario->imagen) {
            Storage::Delete('avatars/'.$usuario->imagen);
            $usuario->imagen = null;
            $usuario->save();
        }
       
        // Se almacena la nueva imagen del usuario.
        $imagenAlmacenada = Storage::put($imagenUbicacion, file_get_contents($imagen->getRealPath()));

        if($imagenAlmacenada){
            // Su la imagen fue almacenada, entonces su nombre es registrado en la BD.
            $usuario->imagen = $imagenNombre;
            $usuario->save();
        }

        $mensaje = "La imagen de perfil ha sido actualizada.";

        return redirect()->back()->withInput()->with(['mensaje' => $mensaje]);
    }

    public function actualizarCorreo(Request $request)
    {
        // Actualizar el correo electrónico del usuario autenticado.
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

    public function actualizarPassword(Request $request)
    {
        // Actualizar la contraseña del usuario autenticado.
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

    public function eliminarAvatarUsuario(Request $request)
    {
        // Borrar la imagen de perfil del usuario.

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

        // Mostrar los favoritos de un usuario.        
        $usuarioFavoritos = DB::table('usuarios')->where('nickname', $nickname)->first();

        // Si el usuario existe, entonces se muestran sus favoritos (si tiene)...
        if ($usuarioFavoritos){

            return view ('userview.usuario.ver_favoritos', [
                            'usuario' => Auth::User(),
                            'usuarioFavoritos' => $usuarioFavoritos,
                            
                        ]);
        } 
        // Sino...
        else {
            echo 'Mostrar vista con mensaje de "Usuario No Existe", por ende no hay favoritos que ver.';
        }
    }

    public function escribirMensaje($id_usuario)
    {
        // Mostrar formulario para redactar el mensaje a enviar a otro usuario.

        // NOTA: En lugar de usar este método, se podría usar el método de
        // MensajeController.
    }

    public function salir()
    {
        // Permitir el cierre de la sesión del usuario autenticado.
        Auth::logout();
        return redirect()->route('userhome');
    }
}
