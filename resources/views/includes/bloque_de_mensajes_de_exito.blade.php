{{-- Mostrar mensaje de éxito --}}
@if(Session::has('mensaje'))
  <script> 
    toastr.options = {
      "closeButton": true,
      "debug": false,
      "newestOnTop": false,
      "progressBar": true,
      "positionClass": "toast-bottom-right",
      "preventDuplicates": false,
      "onclick": null,
      "showDuration": "300",
      "hideDuration": "1000",
      "timeOut": "10000",
      "extendedTimeOut": "10000"
    }
    toastr.success('{{Session::get('mensaje')}}'); 
  </script>
@endif

{{-- Mostrar confirmación de mensaje enviado a usuario --}}
@if(Session::has('mensajeEnviado'))
  <script> 
    toastr.options = {
      "closeButton": true,
      "debug": false,
      "newestOnTop": false,
      "progressBar": true,
      "positionClass": "toast-bottom-right",
      "preventDuplicates": false,
      "onclick": null,
      "showDuration": "300",
      "hideDuration": "1000",
      "timeOut": "10000",
      "extendedTimeOut": "10000"
    }
    var mensajeConLink = 'El <a href="{{ route('ver_mensaje_enviado', ['id_mensaje' => Session::get('mensajeEnviado')]) }}">mensaje privado</b></a> ha sido enviado satisfactoriamente.';
    toastr.success(mensajeConLink);
  </script>
@endif

{{-- Mostrar confirmación de envío de solicitud --}}
@if(Session::has('solicitudEnviada'))
    <div class="lfu-seccion-completa col-xs-12">
        <div class="col-xs-1 col-sm-2 col-md-3 col-lg-3 lfu-espacio-responsive"></div>
        <div class="col-xs-10 col-sm-8 col-md-6 col-lg-6">
            <div class="alert alert-success alert-dismissable">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                
                <strong> La <a href="{{ route('usuario.ver_solicitud', ['id_solicitud' => Session::get('solicitudEnviada')]) }}">solicitud</b></a> ha sido enviada satisfactoriamente. </strong>

            </div>
        </div>
        <div class="col-xs-1 col-sm-2 col-md-3 col-lg-3 lfu-espacio-responsive"></div>
    </div>
@endif