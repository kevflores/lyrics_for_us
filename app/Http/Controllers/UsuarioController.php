<?php
namespace App\Http\Controllers;
use App\Usuario;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;


class UsuarioController extends Controller
{
    public function indexRegistro()
    {
        // Mostrar la vista para el registro de usuario.
        return view('userview.usuario.registro');
    }

    public function registrar(Request $request)
    {
        // Validar el registro de usuario.
        $this->validate($request, [
            'nickname' => 'required|unique:usuarios',
            'apellido' => 'required',
            'email' => 'required|email|unique:usuarios',
            'nombre' => 'required|max:120',
            'password' => 'required|min:4'
        ]);

        $nickname = $request['nickname'];
        $nombre = $request['nombre'];
        $apellido = $request['apellido'];
        $email = $request['email'];
        $password = bcrypt($request['password']);

        $usuario = new Usuario();

        $usuario->nickname = $nickname;
        $usuario->nombre = $nombre;
        $usuario->apellido = $apellido;
        $usuario->email = $email;
        $usuario->password = $password;
        $usuario->categoria_usuario_id = 1;

        $usuario->save();

        Auth::login($usuario);

        return redirect()->route('userhome');
    }
    
    public function activarCuenta($codigo)
    {
        // Validar el código para activar la cuenta del usuario.
        return view('userview.usuario.activar_cuenta');
    }
    
    public function indexIngreso()
    {
        // Mostrar vista para el ingreso al sistema.
        return view ('userview.usuario.ingreso');
    }

    public function ingresar(Request $request)
    {
        // Validar credenciales.
    }

    public function recuperarPassword()
    {
        // Mostrar vista para ingresar el email o nickname del usuario que desea recuperar su password.
        return view('userview.usuario.recuperar_password');
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
        return view ('userview.usuario.ver_perfil');
    }


    public function comentar(Request $request, $id_usuario)
    {
        // Registrar el comentario realizado sobre un ususario.
    }

    public function reportar($id_usuario)
    {
        // Registrar el reporte realizado sobre un usuario.
    }

    public function verConfiguracion(){
        // Mostrar toda la información del usuario autenticado, de modo que éste pueda
        // modificar lo que crea conveniente.
        return view ('userview.usuario.ver_configuracion');
    }

    public function editarDatos(Request $request)
    {
        // Actualizar los datos del usuario autenticado.
    }    

    public function verFavoritos($id_usuario)
    {
        // Mostrar los favoritos (artistas, discos y canciones) de un usuario.
        return view('userview.usuario.ver_favoritos');
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
    }
}
