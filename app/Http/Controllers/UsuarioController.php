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
        $this->validate($request, [
            'password-repeat' => 'same:password'
        ]);

        $nickname = $request['nickname'];
        $nombre = $request['nombre'];
        $apellido = $request['apellido'];
        $email = $request['email'];
        $password = bcrypt($request['password']);
        $remember_token = $request['_token'];

        $usuario = new Usuario();

        $usuario->nickname = $nickname;
        $usuario->nombre = $nombre;
        $usuario->apellido = $apellido;
        $usuario->email = $email;
        $usuario->password = $password;
        $usuario->categoria_usuario_id = 2; // Categoría = Usuario.
        $usuario->remember_token = $remember_token;

        $usuario->save();

        Auth::login($usuario); // Línea provisional.

        return redirect()->route('usuario.configuracion');
    }
    
    public function activarCuenta($codigo)
    {
        // Validar el código para activar la cuenta del usuario.
        return view('userview.usuario.activar_cuenta');
    }
    
    public function indexIngreso()
    {
        // Mostrar vista para el ingreso al sistema.

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

    public function editarDatos(Request $request)
    {
        // Actualizar los datos del usuario autenticado.
    }    

    public function verFavoritos($id_usuario)
    {
        // Mostrar los favoritos (artistas, discos y canciones) de un usuario.
        return view('userview.usuario.ver_favoritos', ['usuario' => Auth::User()]);
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
