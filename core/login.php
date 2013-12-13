<?php
//Hacemos la busqueda del usuario y contraseña (usando objeto)
//En la base de acceso y si no existe el usuario mandamos a llamar nuevamente 
//index.html con el mensaje de login incorrecto

// si existe usuario y contraseña entonces genera código 
//si no esta como usuario entonces error

$html = file_get_contents('../html/serviciosmunicipales.html');
echo $html;
?>