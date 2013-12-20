<?php
//Hacemos la busqueda del usuario y contraseña (usando objeto)
//En la base de acceso y si no existe el usuario mandamos a llamar nuevamente 
//index.html con el mensaje de login incorrecto

// si existe usuario y contraseña entonces genera código 
//si no esta como usuario entonces error
//require_once 'config.php';
//$SESION_USUARIO=new sesion_usuario();
//if $EXITE_USUARIO.existe($usuario)..
//$TIPO_USUARIO=new tipo_usuario($usuario);
//$ESTADO_USUARIO
//$MUNICIPIO_USUARIO
//$LOCALIDAD_USUARIO
//$OPTION_LOCALIDAD = generaoptionLocalidad($ESTADO,$MUNICIPIO,$LOCALIDAD); crea el código html segun los datos de estado,municipio,localidad
// ejemplo 
//<option value="1">TLAXCALA DE XICOTENCATL</option>
//<option value="8">OCOTLAN</option>
$html = file_get_contents('../html/serviciosmunicipales.html');
echo $html;
?>