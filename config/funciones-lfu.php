<?php

/* Funciones creadas para algunos aspectos de la aplicación */

// Para señalar como "active" al módulo correspondiente.
function current_page($uri = "/") {
    return strstr(request()->path(), $uri);
    //return request()->path == $uri;
}

// Para verificar si un JSON está vacío.
function is_obj_empty($obj){
   if( is_null($obj) ){
      return false;
   }
   foreach( $obj as $key => $val ){
      return true;
   }
   return false;
}