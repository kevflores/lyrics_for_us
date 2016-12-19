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

    // Al momento de presionar "Enviar" comentario.
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


    // Para la vista de "Mensajes recibidos (Mis mensajes)"
    $("#borrar-marcados").click(function(){
        $('#formulario-mensajes-enviados').attr('action', urlBorrarMacados);
    });

    $("#marcar-como-leidos").click(function(){
        $('#formulario-mensajes-enviados').attr('action', urlMarcarComoLeidos);
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