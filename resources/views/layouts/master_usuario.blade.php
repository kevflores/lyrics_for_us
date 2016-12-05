<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('titulo')</title>

        <!-- Fonts 
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        -->

        <!-- CDN de Font-Awesome
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
        -->
        <link rel="stylesheet" href="{{ URL::to('font-awesome/css/font-awesome.css') }}">

        <!-- Latest compiled and minified CSS -->
        <!-- CDN de Bootstrap 3.3.7
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        -->
        <link rel="stylesheet" href="{{ URL::to('bootstrap-3.3.7/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ URL::to('css/estilos.css') }}">
    </head>

    <body>

        @include('includes.header_usuario')
        
        <div class="container">
            @yield('contenido')
        </div>

        @include('includes.footer')

        <!-- jQuery library -->
        <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script> -->
        <script src="{{ URL::to('jquery/jquery-3.1.1.min.js') }}"></script>
        <!-- Latest compiled and minified JavaScript -->
        <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script> -->
        <script src="{{ URL::to('bootstrap-3.3.7/js/bootstrap.min.js') }}"></script>

        <script>
            $(document).ready(function(){
                // Al presionar "Mostrar Comentarios" se muestra la sección de comentarios.
                $("a[class='ver-comentarios']").click(function(){
                    $("#lfu-panel-comentarios").toggleClass("no-border-bottom");
                    $(".ver-comentarios").hide();
                    $(".ocultar-comentarios").show();
                    $("#lfu-panel-heading-comentarios").css("border-radius","0px");

                });
                // Al presionar "Ocultar Comentarios" se oculta la sección de comentarios.
                $("a[class='ocultar-comentarios']").click(function(){
                    $("#lfu-panel-comentarios").toggleClass("no-border-bottom");
                    $(".ver-comentarios").show();
                    $(".ocultar-comentarios").hide();
                    $("#lfu-panel-heading-comentarios").css({"border-bottom-left-radius":"3px","border-bottom-right-radius":"3px"});
                });
                // Al presionar "Comentar" se muestra el Modal para realizar el comentario.
                $("#lfu-comentar").click(function(){
                    $("#comentarModal").modal();
                });
                // Al momento de presionar "Enviar" comentario.
                $(".modal-body").on('click', '#enviar-comentario', function (e) {
                    $(this.form).submit();              // Se envía el comentario
                    $("#lfu-textarea-comentario").val(''); // El campo queda en blanco
                    $("#comentarModal").modal('hide');        // Se oculta el modal
                });
                // Al presionar "Cancelar", el campo del textarea debe quedar en blanco.
                $("#cancelar-comentario").click(function(){
                    $("#lfu-textarea-comentario").val('');
                });
                // Al presionar "X" de cerrar, el campo del textarea debe quedar en blanco.
                $(".cerrar_modal").click(function(){
                    $("#lfu-textarea-comentario").val('');
                });
                // Para desaparecer los espacios 'responsive' del mensaje de bienvenida.
                $(".close").click(function(){
                    $(".mensaje-bienvenida").fadeOut(1000); 
                });

                // Al presionar "Actualizar Contraseña" se muestra el Modal para confirmar la actualización.
                $("#lfu-actualizarPassword").click(function(){
                    $("#actualizarPasswordModal").modal();
                });
                // Al momento de presionar "Confirmar Actualización" de la contraeña.
                $("#enviarNuevaPassword").click(function(){
                    $("#lfu-configuracion-panel-body-password".form).submit(); 
                    
                    $("#actualizarPasswordModal").modal('hide');                // Se oculta el modal
                });
                // Al presionar "Cancelar" la actualización de la contraseña. 
                $("#cancelar-actualizacion").click(function(){
                    $("#password-actual").val('');
                });
                // Al presionar "X" de cerrar la actualización de la contraseña,
                // el campo de la contraseña actual debe quedar en blanco.
                $(".cerrar_modal_actpass").click(function(){
                    $("#lfu-password-actual").val('');
                });
                // Para no permitir que se los datos de los formularios del submódulo "Configuración" se
                // envíen al presionar "ENTER" (sólo se permite presionar el BOTÓN respectivo).
                $('#lfu-form-config-datos').on('keyup keypress', function(e) {
                    var keyCode = e.keyCode || e.which;
                    if (keyCode === 13) { 
                        e.preventDefault();
                        return false;
                    }
                });
                $('#lfu-form-config-imagen').on('keyup keypress', function(e) {
                    var keyCode = e.keyCode || e.which;
                    if (keyCode === 13) { 
                        e.preventDefault();
                        return false;
                    }
                });
                $('#lfu-form-config-correo').on('keyup keypress', function(e) {
                    var keyCode = e.keyCode || e.which;
                    if (keyCode === 13) { 
                        e.preventDefault();
                        return false;
                    }
                });
                $('#lfu-form-config-password').on('keyup keypress', function(e) {
                    var keyCode = e.keyCode || e.which;
                    if (keyCode === 13) { 
                        e.preventDefault();
                        return false;
                    }
                });
                // Para mostrar botón de eliminar (PROVISIONAL)
                $('[data-toggle="popover"]').popover({ 
                    html : true,
                    content: function() {
                      return $("#popover-content").html();
                    }
                });
            });
        </script>

    </body>
</html>
