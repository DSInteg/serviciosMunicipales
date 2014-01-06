<?php




$conexion = mysql_connect("localhost", "root", "");
mysql_select_db("mapas", $conexion);



$marcadores=$_POST["datosMarcas"];
$areas=$_POST["datosAreas"];

//+++++++++++++++++++++++++Los datos del formulario

$CP=$_POST["datoCP"];
$IdEstado=$_POST["datoIDEstado"];
$IdMunicipio=$_POST["datoIDMunicipio"];
$IdLocalidad=$_POST["datoIDLocalidad"];
$IdPropietario=$_POST["datoPropietario"];
$direccion=$_POST["datoDireccion"];
$numero=$_POST["datoNumero"];

//++++++++++++++latitud y longitud
$latitud=$_POST["datoLatitud"];
$longitud=$_POST["datoLongitud"];



if($marcadores!=''){//Si hay algo que guardar
	$que = "INSERT INTO marcadores(coordenadas,idEstado,idMunicipio,idLocalidad,direccion,numero,CP,idPropietario,latitud,longitud) ";
	//$que = "INSERT INTO marcadores(coordenadas) ";
	//$que.= "VALUES ('".$marcadores."'".") ";
	$que.= "VALUES ('".$marcadores."',"
			.$IdEstado.","
			.$IdMunicipio.","
			.$IdLocalidad.","
			."'".$direccion."',"
			."'".$numero."',"
			."'".$CP."',"
			.$IdPropietario.","
			.$latitud.","
			.$longitud.""
			.")";


	$res = mysql_query($que, $conexion) or die(mysql_error());
	//echo "Todo Guardado";
}

if($areas!=''){//Si hay algo que guardar
	$que = "INSERT INTO areas(coordenadas) ";
	$que.= "VALUES ('".$areas."') ";
	$res = mysql_query($que, $conexion) or die(mysql_error());
	//echo "Todo Guardado";
}



include("obtenerDatos.php");

?>