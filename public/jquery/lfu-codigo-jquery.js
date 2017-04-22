$(document).ready(function(){

    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
    INICIO DE CÓDIGO PARA MOSTRAR EL SPINNER DE "CARGANDO"
    * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

        var opts = {
        lines: 13 // The number of lines to draw
        , length: 28 // The length of each line
        , width: 14 // The line thickness
        , radius: 42 // The radius of the inner circle
        , scale: 0.37 // Scales overall size of the spinner
        , corners: 1 // Corner roundness (0..1)
        , color: 'rgba(92, 180, 238, 1)' // #rgb or #rrggbb or array of colors
        , opacity: 0.25 // Opacity of the lines
        , rotate: 0 // The rotation offset
        , direction: 1 // 1: clockwise, -1: counterclockwise
        , speed: 1 // Rounds per second
        , trail: 60 // Afterglow percentage
        , fps: 20 // Frames per second when using setTimeout() as a fallback for CSS
        , zIndex: 2e9 // The z-index (defaults to 2000000000)
        , className: 'spinner' // The CSS class to assign to the spinner
        , top: '50%' // Top position relative to parent
        , left: '50%' // Left position relative to parent
        , shadow: true // Whether to render a shadow
        , hwaccel: false // Whether to use hardware acceleration
        , position: 'absolute' // Element positioning
        }

        var target = document.getElementById('lfu-cargando');
        var spinner = new Spinner(opts).spin(target);

    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
    FIN DE CÓDIGO PARA MOSTRAR EL SPINNER DE "CARGANDO"
    * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */


    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
    INICIO DE CÓDIGO PARA EL MÓDULO DE INICIO
    * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

        // Para desaparecer los espacios 'responsive' del mensaje de bienvenida.
        $(".close").click(function(){
            $(".mensaje-bienvenida").fadeOut(1000); 
        });

    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
    FIN DE CÓDIGO PARA EL MÓDULO DE INICIO
    * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */


    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
    INICIO DE CÓDIGO PARA LA SECCIÓN DE COMENTARIOS
    * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

        // Al presionar "Mostrar Comentarios" se muestra la sección de comentarios.
        $("a[class='ver-comentarios']").click(function(){
            $("#lfu-panel-comentarios").toggleClass("no-border-bottom"); // Para el Perfil de Usuario.
            $("#lfu-panel-artista-comentarios").toggleClass("no-border-bottom"); // Para la sección individual de Artista.
            $("#lfu-panel-disco-comentarios").toggleClass("no-border-bottom"); // Para la sección individual de Disco.
            $("#lfu-panel-cancion-comentarios").toggleClass("no-border-bottom"); // Para la sección individual de Canción.
            $(".ver-comentarios").hide();
            $(".ocultar-comentarios").show();
            $("#lfu-panel-heading-comentarios").css("border-radius","0px"); // Para el Perfil de Usuario.
            $("#lfu-artista-panel-heading-comentarios").css("border-radius","0px"); // Para la sección individual de Artista.
            $("#lfu-disco-panel-heading-comentarios").css("border-radius","0px"); // Para la sección individual de Disco.
            $("#lfu-cancion-panel-heading-comentarios").css("border-radius","0px"); // Para la sección individual de Canción.
        });

        // Al presionar "Ocultar Comentarios" se oculta la sección de comentarios.
        $("a[class='ocultar-comentarios']").click(function(){
            $("#lfu-panel-comentarios").toggleClass("no-border-bottom"); // Para el Perfil de Usuario.
            $("#lfu-panel-artista-comentarios").toggleClass("no-border-bottom"); // Para la sección individual de Artista.
            $("#lfu-panel-disco-comentarios").toggleClass("no-border-bottom"); // Para la sección individual de Disco.
            $("#lfu-panel-cancion-comentarios").toggleClass("no-border-bottom"); // Para la sección individual de Canción.
            $(".ver-comentarios").show();
            $(".ocultar-comentarios").hide();
            $("#lfu-panel-heading-comentarios").css({"border-bottom-left-radius":"3px","border-bottom-right-radius":"3px"});
            $("#lfu-artista-panel-heading-comentarios").css({"border-bottom-left-radius":"3px","border-bottom-right-radius":"3px"}); // Para la sección individual de Artista.
            $("#lfu-disco-panel-heading-comentarios").css({"border-bottom-left-radius":"3px","border-bottom-right-radius":"3px"}); // Para la sección individual de Disco.
            $("#lfu-cancion-panel-heading-comentarios").css({"border-bottom-left-radius":"3px","border-bottom-right-radius":"3px"}); // Para la sección individual de Canción.
        });

        // Al presionar "Comentar" se muestra el Modal para realizar el comentario.
        $("#lfu-comentar").click(function(){
            $("#comentarModal").modal();
            $("#lfu-textarea-comentario").focus();
        });
        
        /*
        // Al momento de presionar "Enviar" comentario.
        $(".modal-body").on('click', '#enviar-comentario', function (e) {
            $(this.form).submit();              // Se envía el comentario
            $("#comentarModal").modal('hide');        // Se oculta el modal
        });
        */

        // Al presionar "Cancelar", el campo del textarea debe quedar en blanco.
        $("#cancelar-comentario").click(function(){
            $("#lfu-textarea-comentario").val('');
        });

        // Al presionar "X" de cerrar, el campo del textarea debe quedar en blanco.
        $(".cerrar_modal").click(function(){
            $("#lfu-textarea-comentario").val('');
        });

    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
    FIN DE CÓDIGO PARA LA SECCIÓN DE COMENTARIOS
    * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */


    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
    INICIO DE CÓDIGO PARA EL PERFIL DE USUARIO
    * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

        // Al presionar "Enviar mensaje a usuario" se muestra el Modal para escribir el mensaje.
        $("#lfu-escribir-mensaje-desde-perfil").click(function(){
            $("#enviarMensajeDesdePerfilModal").modal();
        });

        // Al momento de presionar "Enviar" comentario.
        $(".modal-body").on('click', '#enviar-mensaje-desde-perfil', function (e) {
            $(this.form).submit();              // Se envía el comentario
            //$("#lfu-asunto-mensaje").val(''); // El campo queda en blanco
            //$("#lfu-textarea-mensaje").val(''); // El campo queda en blanco
            $("#enviarMensajeDesdePerfilModal").modal('hide');        // Se oculta el modal
        });

        // Al presionar "Cancelar", el campo del textarea debe quedar en blanco.
        $("#cancelar-envio-mensaje").click(function(){
            $("#lfu-asunto-mensaje").val('');
            $("#lfu-textarea-mensaje").val('');
        });

        // Al presionar "X" de cerrar, el campo del textarea debe quedar en blanco.
        $(".cerrar_modal_envio_mensaje").click(function(){
            $("#lfu-asunto-mensaje").val('');
            $("#lfu-textarea-mensaje").val('');
        });

        // Al presionar "Reportar usuario" se muestra el Modal para escribir el reporte.
        $("#lfu-reportar-usuario").click(function(){
            $("#reportarUsuarioModal").modal();
        });

        // Al momento de presionar "Enviar" reporte.
        $(".modal-body").on('click', '#enviar-reporte-usuario-perfil', function (e) {
            $(this.form).submit();              // Se envía el comentario
            $("#reportarUsuarioModal").modal('hide');        // Se oculta el modal
        });

        // Al presionar "Cancelar", el campo del textarea debe quedar en blanco.
        $("#cancelar-envio-reporte-usuario").click(function(){
            $("#lfu-textarea-reporte-usuario").val('');
        });

        // Al presionar "X" de cerrar, el campo del textarea debe quedar en blanco.
        $(".cerrar_modal_reporte_usuario").click(function(){
            $("#lfu-textarea-reporte-usuario").val('');
        });

    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
    FIN DE CÓDIGO PARA EL PERFIL DE USUARIO
    * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */


    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
    INICIO DE CÓDIGO PARA EL SUBMÓDULO DE CONFIGURACIÓN DE CUENTA
    * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

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
        
        // Al presionar "Eliminar imagen" se muestra el Modal para confirmar la eliminación.
        $("#lfu-eliminar-imagen").click(function(){
            $("#eliminarImagenModal").modal();
        });

        // Al momento de presionar "Eliminar" en el Modal.
        $("#confirmarEliminacionImagen").click(function(){
            $("lfu-form-eliminar-imagen").submit(); 
            $("#eliminarImagenModal").modal('hide'); // Se oculta el modal
        });

        // Al presionar el ícono de "Eliminar artista favorito" se muestra el Modal para confirmar la eliminación.
        $(".eliminar-artista-favorito").click(function(event){
            event.preventDefault();
            var nombre = this.parentNode.dataset['nombreartista'];
            var id_favorito = this.parentNode.dataset['idfavorito'];
            console.log(nombre+" "+id_favorito);
            $("#preguntaFavorito").text("¿Desea eliminar a "+nombre+" de sus artistas favoritos?");
            $("input[name='tipo']").val("artista");
            $("input[name='id_favorito']").val(id_favorito);
            $("#eliminarFavoritoModal").modal();
        });

        // Al presionar el ícono de "Eliminar disco favorito" se muestra el Modal para confirmar la eliminación.
        $(".eliminar-disco-favorito").click(function(event){
            event.preventDefault();
            var titulo = this.parentNode.dataset['titulodisco'];
            var id_favorito = this.parentNode.dataset['idfavorito'];
            console.log(titulo+" "+id_favorito);
            $("#preguntaFavorito").text('¿Desea eliminar "'+titulo+'" de sus discos favoritos?');
            $("input[name='tipo']").val("disco");
            $("input[name='id_favorito']").val(id_favorito);
            $("#eliminarFavoritoModal").modal();
        });

        // Al presionar el ícono de "Eliminar cancion favorita" se muestra el Modal para confirmar la eliminación.
        $(".eliminar-cancion-favorita").click(function(event){
            event.preventDefault();
            var titulo = this.parentNode.dataset['titulocancion'];
            var id_favorito = this.parentNode.dataset['idfavorito'];
            console.log(titulo+" "+id_favorito);
            $("#preguntaFavorito").text('¿Desea eliminar "'+titulo+'" de sus canciones favoritas?');
            $("input[name='tipo']").val("cancion");
            $("input[name='id_favorito']").val(id_favorito);
            $("#eliminarFavoritoModal").modal();
        });

        // Al momento de presionar "Eliminar" en el Modal.
        $("#confirmarEliminacionFavorito").click(function(){
            $("formEliminarFavorito").submit(); 
            $("#eliminarFavoritoModal").modal('hide'); // Se oculta el modal
        });

        // Al presionar el ícono de "Eliminar mensaje" se muestra el Modal para confirmar la eliminación.
        $(".eliminar-mensaje").click(function(event){
            event.preventDefault();
            var asunto = this.parentNode.dataset['asunto'];
            var id_mensaje = this.parentNode.dataset['idmensaje'];
            $("#preguntaMensaje").text('¿Desea eliminar el mensaje "'+asunto+'"?');
            $("input[name='id_mensaje']").val(id_mensaje);
            $("#eliminarMensajeModal").modal();
        });

        // Al momento de presionar "Eliminar" en el Modal.
        $("#confirmarEliminacionMensaje").click(function(){
            $("#formEliminarMensaje").submit(); 
            $("#eliminarMensajeModal").modal('hide'); // Se oculta el modal
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

        $('#lfu-form-eliminar-imagen').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) { 
                e.preventDefault();
                return false;
            }
        });

        // Al hacer HOVER sobre el campo "Seleccionar imagen", se le añade la clase "focusedInput".
        $(".seleccionarImagen").hover(function(){
            $(this).toggleClass("focusedInput");
        });

        // Al seleccionar una imagen, se muestra el nombre de dicha imagen.
        $(".subirImagen").change(function(e) {
            var fileName = e.target.files[0].name;
            $(".spanImagen").text('Imagen: "' + fileName + '"');
        });

    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
    FIN DE CÓDIGO PARA EL SUBMÓDULO DE CONFIGURACIÓN DE CUENTA
    * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */


    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
    INICIO DE CÓDIGO PARA EL SUBMÓDULO DE MIS MENSAJES
    * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

        // Para la vista de "Mensajes recibidos (Mis mensajes)"
        $("#borrar-marcados").click(function(){
            $('#formulario-mensajes-recibidos').attr('action', urlBorrarMacados);
        });

        $("#marcar-como-leidos").click(function(){
            $('#formulario-mensajes-recibidos').attr('action', urlMarcarComoLeidos);
        });

        // Al presionar "Enviar mensaje a usuario" se muestra el Modal para escribir el mensaje.
        $("#lfu-escribir-mensaje").click(function(){
            $("#enviarMensajeModal").modal();
        });

        // Al momento de presionar "Enviar" comentario.
        $(".modal-body").on('click', '#enviar-mensaje', function (e) {
            $(this.form).submit();              // Se envía el comentario
            //$("#lfu-asunto-mensaje").val(''); // El campo queda en blanco
            //$("#lfu-textarea-mensaje").val(''); // El campo queda en blanco
            $("#enviarMensajeModal").modal('hide');        // Se oculta el modal
        });

        // Al presionar "Cancelar", el campo del textarea debe quedar en blanco.
        $("#cancelar-envio-mensaje").click(function(){
            $("#lfu-nickname-mensaje").val('');
            $("#lfu-asunto-mensaje").val('');
            $("#lfu-textarea-mensaje").val('');
        });

        // Al presionar "X" de cerrar, el campo del textarea debe quedar en blanco.
        $(".cerrar_modal_envio_mensaje").click(function(){
            $("#lfu-nickname-mensaje").val('');
            $("#lfu-asunto-mensaje").val('');
            $("#lfu-textarea-mensaje").val('');
        });

        // Para la vista de "Mensajes enviados (Mis mensajes)"
        $("#borrar-enviados-marcados").click(function(){
            $('#formulario-mensajes-enviados').attr('action', urlBorrarMacados);
        });

        // Al presionar el botón de "Eliminar" desde la vista de un mensaje recibido se muestra el Modal
        // para confirmar la eliminación.
        $("#eliminar-mensaje-recibido-boton").click(function(event){
            event.preventDefault();
            var asunto = this.parentNode.dataset['asunto'];
            var id_mensaje = this.parentNode.dataset['idmensaje'];
            $("#preguntaMensaje").text('¿Desea eliminar el mensaje "'+asunto+'"?');
            $("input[name='id_mensaje']").val(id_mensaje);
            $("#eliminarMensajeRecibidoModal").modal();
        });

        // Al momento de presionar "Eliminar" en el Modal.
        $("#confirmarEliminacionMensaje").click(function(){
            $("#formEliminarMensaje").submit(); 
            $("#eliminarMensajeRecibidoModal").modal('hide'); // Se oculta el modal
        });

        // Al presionar el botón de "Eliminar" desde la vista de un mensaje enviado se muestra el Modal
        // para confirmar la eliminación.
        $("#eliminar-mensaje-enviado-boton").click(function(event){
            event.preventDefault();
            var asunto = this.parentNode.dataset['asunto'];
            var id_mensaje = this.parentNode.dataset['idmensaje'];
            $("#preguntaMensaje").text('¿Desea eliminar el mensaje "'+asunto+'"?');
            $("input[name='id_mensaje']").val(id_mensaje);
            $("#eliminarMensajeEnviadoModal").modal();
        });

        // Al momento de presionar "Eliminar" en el Modal.
        $("#confirmarEliminacionMensaje").click(function(){
            $("#formEliminarMensaje").submit(); 
            $("#eliminarMensajeEnviadoModal").modal('hide'); // Se oculta el modal
        });

        // Al presionar el botón de "Responder" desde la vista de un mensaje recibido se muestra el Modal
        // para redactar el mensaje "respuesta".
        $("#responder-mensaje-recibido-boton").click(function(event){
            event.preventDefault();
            var nickname = this.parentNode.dataset['nickname'];
            var id_mensaje = this.parentNode.dataset['idmensaje'];
            $("input[name='nickname']").val(nickname);
            $("#responderMensajeModal").modal();
        });

        // Al momento de presionar "Enviar" en el Modal.
        $("#enviar-mensaje-respuesta").click(function(){
            $("#form-responder-mensaje").submit(); 
            $("#responderMensajeModal").modal('hide'); // Se oculta el modal
        });

    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
    FIN DE CÓDIGO PARA EL SUBMÓDULO DE MIS MENSAJES
    * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */


    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
    INICIO DE CÓDIGO PARA EL SUBMÓDULO DE MIS SOLICITUDES
    * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

        // Al presionar "Realizar Nueva Solicitud" se muestra el Modal.
        $("#lfu-realizar-solicitud").click(function(){
            $("#realizarSolicitudModal").modal();
        });

        // Al momento de presionar "Enviar" solicitud.
        $("#enviar-solicitud").click(function(){
            $("#formRealizarSolicitud").submit(); 
            $("#realizarSolicitudModal").modal('hide'); // Se oculta el modal
        });

        // Al presionar "Cancelar", los campos de texto deben quedar en blanco.
        $("#cancelar-solicitud").click(function(){
            $("#lfu-titulo-solicitud").val('');
            $("#lfu-descripcion-solicitud").val('');
        });

        // Al presionar "X" de cerrar, los campos de texto deben quedar en blanco.
        $(".cerrar_modal_realizar_solicitud").click(function(){
            $("#lfu-titulo-solicitud").val('');
            $("#lfu-descripcion-solicitud").val('');
        });

    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
    FIN DE CÓDIGO PARA EL SUBMÓDULO DE MIS SOLICITUDES
    * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */


    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
    INICIO DE CÓDIGO PARA EL MÓDULO DE ARTISTAS
    * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

        // Al presionar el enlace "Agregar a mi lista de artistas favoritos".
        $("#lfu-agregar-artista-favoritos").click(function(){
            $("#lfu-agregar-artista-favoritos-form").submit(); 
        });

        // Al presionar el enlace "Eliminar de mi lista de artistas favoritos".
        $("#lfu-eliminar-artista-favoritos").click(function(){
            $("#lfu-eliminar-artista-favoritos-form").submit(); 
        });

    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
    FIN DE CÓDIGO PARA EL MÓDULO DE ARTISTAS
    * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */


    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
    INICIO DE CÓDIGO PARA EL MÓDULO DE DISCOS
    * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

        // Al presionar el enlace "Agregar a mi lista de discos favoritos".
        $("#lfu-agregar-disco-favoritos").click(function(){
            $("#lfu-agregar-disco-favoritos-form").submit(); 
        });

        // Al presionar el enlace "Eliminar de mi lista de discos favoritos".
        $("#lfu-eliminar-disco-favoritos").click(function(){
            $("#lfu-eliminar-disco-favoritos-form").submit(); 
        });

    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
    FIN DE CÓDIGO PARA EL MÓDULO DE DISCOS
    * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */


    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
    INICIO DE CÓDIGO PARA EL MÓDULO DE CANCIONES
    * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

        // Al presionar el enlace "Agregar a mi lista de canciones favoritas".
        $("#lfu-agregar-cancion-favoritos").click(function(){
            $("#lfu-agregar-cancion-favoritos-form").submit(); 
        });

        // Al presionar el enlace "Eliminar de mi lista de canciones favoritas".
        $("#lfu-eliminar-cancion-favoritos").click(function(){
            $("#lfu-eliminar-cancion-favoritos-form").submit(); 
        });

        // Al presionar "Reportar letra" se muestra el Modal para escribir el reporte.
        $("#lfu-reportar-letra").click(function(){
            $("#reportarLetraModal").modal();
        });

        // Al momento de presionar "Enviar" reporte.
        $(".modal-body").on('click', '#enviar-reporte-letra', function (e) {
            $(this.form).submit();              // Se envía el comentario
            $("#reportarLetraModal").modal('hide');        // Se oculta el modal
        });

        // Al presionar "Cancelar", el campo del textarea debe quedar en blanco.
        $("#cancelar-envio-reporte-letra").click(function(){
            $("#lfu-textarea-reporte-letra").val('');
        });

        // Al presionar "X" de cerrar, el campo del textarea debe quedar en blanco.
        $(".cerrar_modal_reporte_letra").click(function(){
            $("#lfu-textarea-reporte-letra").val('');
        });

        // Modal de REGISTRAR LETRA DE CANCIÓN
        $("#lfu-proveer-letra").click(function(){
            $("#proveerLetraModal").modal();
        });
        $(".modal-body").on('click', '#guardar-letra', function (e) {
            $(this.form).submit();              // Se envía el comentario
            $("#proveerLetraModal").modal('hide');        // Se oculta el modal
        });
        $("#cancelar-guardado-letra").click(function(){
            $("#lfu-textarea-letra-cancion").val('');
        });
        $(".cerrar_modal_proveer_letra").click(function(){
            $("#lfu-textarea-letra-cancion").val('');
        });

    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
    FIN DE CÓDIGO PARA EL MÓDULO DE CANCIONES
    * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */


    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
    INICIO DE CÓDIGO PARA EL MÓDULO DE BÚSQUEDA
    * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

        // Modal de BÚSQUEDA
        $("#lfu-buscar").click(function(){
            $("#buscarModal").modal();
        });
        $("#realizar-busqueda").click(function(){
            $("#formRealizarBusqueda").submit(); 
            $("#buscarModal").modal('hide'); // Se oculta el modal
        });
        $("#cancelar-busqueda").click(function(){
            $("#lfu-palabra-clave").val('');
        });
        $(".cerrar_modal_busqueda").click(function(){
            $("#lfu-palabra-clave").val('');
        });

        // Al presionar "Ver Listado de Artistas" en la sección de búsqueda.
        $("a[id='ver-listado-artistas']").click(function(){
            $("#ver-listado-artistas").hide();
            $("#ocultar-listado-artistas").show();
        });

        // Al presionar "Ocultar Listado de Artistas" en la sección de búsqueda.
        $("a[id='ocultar-listado-artistas']").click(function(){
            $("#ver-listado-artistas").show();
            $("#ocultar-listado-artistas").hide();
        });

        // Al presionar "Ver Listado de Discos" en la sección de búsqueda.
        $("a[id='ver-listado-discos']").click(function(){
            $("#ver-listado-discos").hide();
            $("#ocultar-listado-discos").show();
        });

        // Al presionar "Ocultar Listado de Discos" en la sección de búsqueda.
        $("a[id='ocultar-listado-discos']").click(function(){
            $("#ver-listado-discos").show();
            $("#ocultar-listado-discos").hide();
        });

        // Al presionar "Ver Listado de Canciones" en la sección de búsqueda.
        $("a[id='ver-listado-canciones']").click(function(){
            $("#ver-listado-canciones").hide();
            $("#ocultar-listado-canciones").show();
        });

        // Al presionar "Ocultar Listado de Canciones" en la sección de búsqueda.
        $("a[id='ocultar-listado-canciones']").click(function(){
            $("#ver-listado-canciones").show();
            $("#ocultar-listado-canciones").hide();
        });

    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
    FIN DE CÓDIGO PARA EL MÓDULO DE BÚSQUEDA
    * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

    /*    
    $('.eliminar-artista-favorito').on('click', function(event) {
        event.preventDefault();
        var tipoo = "artista";
        var artista_favoritoo = this.parentNode.dataset['idfavorito'];
        console.log(artista_favoritoo);
        $.ajax({
            method: 'POST',
            url: url,
            data: {tipo: tipoo, artista_favorito: artista_favoritoo, _token: token}
        })
        .done(function (msg) {
            console.log(msg['message']);
        });
    });
    */  

});