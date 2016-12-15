<?php 

function is_obj_empty($obj){
   if( is_null($obj) ){
      return false;
   }
   foreach( $obj as $key => $val ){
      return true;
   }
   return false;
}