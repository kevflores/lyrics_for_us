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
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <!-- <script src="{{ URL::to('bootstrap-3.3.7/js/bootstrap.min.js') }}></script> -->

        <script>
            $(document).ready(function(){
                $("a[class='ver-comentarios']").click(function(){
                    $("#lfu-panel-comentarios").toggleClass("no-border-bottom");
                    $(".ver-comentarios").hide();
                    $(".ocultar-comentarios").show();
                    $("#lfu-panel-heading-comentarios").css("border-radius","0px");

                });
                $("a[class='ocultar-comentarios']").click(function(){
                    $("#lfu-panel-comentarios").toggleClass("no-border-bottom");
                    $(".ver-comentarios").show();
                    $(".ocultar-comentarios").hide();
                    $("#lfu-panel-heading-comentarios").css({"border-bottom-left-radius":"3px","border-bottom-right-radius":"3px"});
                });
                $("#lfu-comentar").click(function(){
                    $("#myModal").modal();
                });
                // Al momento de presionar "Enviar" comentario
                $(".modal-body").on('click', '#enviar-comentario', function (e) {
                    $(this.form).submit();              // Se envía el comentario
                    $("#lfu-campo_comentario").val(''); // El campo queda en blanco
                    $("#myModal").modal('hide');        // Se oculta el modal
                });
            });
        </script>

    </body>
</html>
