<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function indexRegistro()
    {
        // Mostrar la vista para el registro de usuario.
    }

    public function registrar(Request $request)
    {
        // Validar el registro de usuario.
    }
    
    public function activarCuenta($codigo)
    {
        // Validar el código para activar la cuenta del usuario.
    }
    
    public function indexIngreso()
    {
        // Mostrar vista para el ingreso al sistema.
    }

    public function ingresar(Request $request)
    {
        // Validar credenciales.
    }

    public function recuperarPassword()
    {
        // Mostrar vista para ingresar el email o nickname del usuario que desea recuperar su password.
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

    public function mostrarPerfil($id_usuario)
    {
        // Mostrar el perfil de un usuario.
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
    }

    public function editarDatos(Request $request)
    {
        // Actualizar los datos del usuario autenticado.
    }    

    public function verFavoritos($id_usuario)
    {
        // Mostrar los favoritos (artistas, discos y canciones) de un usuario.
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
