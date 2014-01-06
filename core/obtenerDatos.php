<?php

$conexion = mysql_connect('localhost', 'root', '');
mysql_select_db('mapas', $conexion);


//Se obtienen los propietarios
$queEmp = 'SELECT * FROM propietarios ORDER BY idPropietario ASC';
$resEmp = mysql_query($queEmp, $conexion) or die(mysql_error());
$totEmp = mysql_num_rows($resEmp);

$listaPropietarios="";
$listaIDPropietario="";
$contador=0;
if ($totEmp> 0) {
   while ($rowEmp = mysql_fetch_assoc($resEmp)) {
	if($contador==0){
		$listaPropietarios=$rowEmp['Nombre']." ".$rowEmp['Paterno']." ".$rowEmp['Materno'];
		$listaIDPropietario=$rowEmp['idPropietario'];
	}else{
		$listaPropietarios=$listaPropietarios."//".$rowEmp['Nombre']." ".$rowEmp['Paterno']." ".$rowEmp['Materno'];
		$listaIDPropietario=$listaIDPropietario."//".$rowEmp['idPropietario'];
	}
	$contador=$contador+1;
   }
}


$propietarios = explode("//",$listaPropietarios);
$clavesPropietario= explode("//",$listaIDPropietario);



//Se obtienen los marcadores

$queEmp = 'SELECT * FROM marcadores m,propietarios p where m.idPropietario=p.idPropietario ORDER BY ID ASC';
$resEmp = mysql_query($queEmp, $conexion) or die(mysql_error());
$totEmp = mysql_num_rows($resEmp);

$contador=0;

if ($totEmp> 0) {
   while ($rowEmp = mysql_fetch_assoc($resEmp)) {
	if($contador==0){
		//$listaMarcadores=$rowEmp['coordenadas'];
		$listaMarcadores="(".$rowEmp['latitud'].",".$rowEmp['longitud'].")";
		$listaInfo='<p><b>Estado  '.$rowEmp['idEstado'].'</b></p>';
		$listaInfo=$listaInfo.'<p><b>Municipio  '.$rowEmp['idMunicipio'].'</b></p>';
		$listaInfo=$listaInfo.'<p><b>Localidad  '.$rowEmp['idLocalidad'].'</b></p>';
		$listaInfo=$listaInfo.'<p><b>Direccion  '.$rowEmp['direccion'].'</b></p>';
		$listaInfo=$listaInfo.'<p><b>Numero '.$rowEmp['numero'].'</b></p>';
		$listaInfo=$listaInfo.'<p><b>CP '.$rowEmp['CP'].'</b></p>';
		$listaInfo=$listaInfo.'<p><b>Propietario '.$rowEmp['Paterno'].' '.$rowEmp['Materno'].' '.$rowEmp['Nombre'].'</b></p>';
	}else{
		//$listaMarcadores=$listaMarcadores."//".$rowEmp['coordenadas'];
		$listaMarcadores=$listaMarcadores."//"."(".$rowEmp['latitud'].",".$rowEmp['longitud'].")";
		$listaInfo=$listaInfo.'//';
		$listaInfo=$listaInfo.'<p><b>Estado '.$rowEmp['idEstado'].'</b></p>';
		$listaInfo=$listaInfo.'<p><b>Municipio  '.$rowEmp['idMunicipio'].'</b></p>';
		$listaInfo=$listaInfo.'<p><b>Localidad  '.$rowEmp['idLocalidad'].'</b></p>';
		$listaInfo=$listaInfo.'<p><b>Direccion  '.$rowEmp['direccion'].'</b></p>';
		$listaInfo=$listaInfo.'<p><b>Numero  '.$rowEmp['numero'].'</b></p>';
		$listaInfo=$listaInfo.'<p><b>CP '.$rowEmp['CP'].'</b></p>';
		$listaInfo=$listaInfo.'<p><b>Propietario '.$rowEmp['Paterno'].' '.$rowEmp['Materno'].' '.$rowEmp['Nombre'].'</b></p>';
	}

	$contador=$contador+1;
   }
}





//ya que leimos todo
$marcadores = explode("//",$listaMarcadores); 
$direcciones= explode("//",$listaInfo);


//cargamos las areas

$queEmp = 'SELECT * FROM areas ORDER BY ID ASC';
$resEmp = mysql_query($queEmp, $conexion) or die(mysql_error());
$totEmp = mysql_num_rows($resEmp);


$contador=0;

if ($totEmp> 0) {
   while ($rowEmp = mysql_fetch_assoc($resEmp)) {
	if($contador==0){
		$listaAreas=$rowEmp['coordenadas'];
	}else{
		$listaAreas=$listaAreas."".$rowEmp['coordenadas'];
	}
	$contador=$contador+1;
   }
}

//ya que leimos todo
$areas = explode("//",$listaAreas); 





//incluimos el javascript
echo "
<!DOCTYPE html><html> 
 <head>    <meta name='viewport' content='initial-scale=1.0, user-scalable=no' />    
<style type='text/css'>      html { height: 100% }      
body { height: 100%; margin: 0; padding: 0 }   
	#map_canvas { height: 100%;width:80%}  
	#formulario { height: 100%;width:20%}
</style>    <script type='text/javascript'      src='http://maps.googleapis.com/maps/api/js?key=AIzaSyCKqBjiaGHDvul2Xfej5aL1EG14okbGPq0 &sensor=true'> 


   </script>    <script type='text/javascript'>      

var rutas=false;
var marcas=false;
var caminito=new Array();
var arrCaminos=new Array();
var marcadores=new Array();
function initialize() {    
    var mapOptions = {          
	center: new google.maps.LatLng(19.315031384033126,-98.20052146911621),  
        zoom: 18,    
        mapTypeId: google.maps.MapTypeId.SATELLITE        };     
   var map = new google.maps.Map(document.getElementById('map_canvas'),     
       mapOptions);  
        
	var myLatlng = new google.maps.LatLng(19.318152,-98.19416667);
        var myLatlnga = new google.maps.LatLng(19.4,-98.437515);




	var image = 'descarga.jpg';


	    rutas=false;
	
	
	var cantidad=0;
	var numRegiones=0;
	var numMarcadores=0;

	var dibujado;


	google.maps.event.addListener(map, 'click', 
			function(event) {    
			var posi = event.latLng; 
			
			

			if(rutas==true){
				caminito[cantidad]=posi;
				cantidad=cantidad+1;

				dibujado= new google.maps.Polyline({
    					path: caminito,
			    		strokeColor: '#FF0000',
    					strokeOpacity: 1.0,
		    			strokeWeight: 2
		  		});
			

				if(caminito.length>3){
				var bermudaTriangle = new google.maps.Polygon({
   				 	paths: caminito,
   					 strokeColor: '#FF0000',
    					strokeOpacity: 0.8,
   					 strokeWeight: 2,
    					fillColor: '#FF0000',
    					fillOpacity: 0.35,
					editable: true
  				});
					bermudaTriangle.setMap(map);


					arrCaminos[numRegiones]=caminito;
					numRegiones=numRegiones+1;


					dibujado.setMap(null);
					caminito=new Array();
					cantidad=0;
				}
				if(cantidad>0)
				   dibujado.setMap(map);

			}else
			if(marcas==true)
			{
				//solo vamos a poner una marca asi que 
				//vamos a poner un contador

				if(numMarcadores==0){
	        		var marker2 = new google.maps.Marker({
      					position: posi,
      					map: map,
      					title:'',
						draggable:true
  						});
					marcadores[numMarcadores]=posi;
					numMarcadores=numMarcadores+1;
			    }

			}



			 });

cargarAnteriores(map,image);
cargarAnterioresAreas(map,image);



var coordenadasfinales= bermudaTriangle.getPath();
 } 


function EnviaDatos1() {  

	var cadenaMarcadores='';
	var cadenaRegiones='';
	var i=0;


	for(i=0;i<marcadores.length;i=i+1){
		cadenaMarcadores=cadenaMarcadores+marcadores[i].toString()+'//';
	}

	for(i=0;i<arrCaminos.length;i=i+1){
		cadenaRegiones=cadenaRegiones+arrCaminos[i].toString()+'//';
	}


	document.getElementById('datosMarcas').value=cadenaMarcadores;
	document.getElementById('datosAreas').value=cadenaRegiones;

//Se llenan los datos para guardar info de los usuarios
	document.getElementById('datoCP').value=document.getElementById('cp').value;
	document.getElementById('datoIDEstado').value=document.getElementById('idestado').value;
	document.getElementById('datoIDMunicipio').value=document.getElementById('idmunicipio').value;
	document.getElementById('datoIDLocalidad').value=document.getElementById('idlocalidad').value;
	document.getElementById('datoDireccion').value=document.getElementById('direccion').value;
	document.getElementById('datoNumero').value=document.getElementById('numero').value;


	//alert(marcadores[0].lat());
	//alert(marcadores[0].lng());
	document.getElementById('datoLatitud').value=marcadores[0].lat();
	document.getElementById('datoLongitud').value=marcadores[0].lng();


var indiceS=document.getElementById('idpropietario').selectedIndex;
var aver=document.getElementById('idpropietario').options[indiceS].value;
//alert(aver);
	document.getElementById('datoPropietario').value=aver;
 	document.targetmain.submit(); 
}


function habilitarRutas() {  
    
	var formcache=document.targetmain;
        if(formcache.marcaRutas.checked){
    		rutas=true; 
		marcas=false;
		formcache.habilitaMarca.checked=false;
	}else{
		rutas=false;
	}

	if(document.getElementById('este').checked){
    		rutas=true; 
		marcas=false;
		document.getElementById('on').checked=false;
	}else{
		rutas=false;
	}
}

function habilitarMarcas() {  
    
	var formcache=document.targetmain;
        if(formcache.habilitaMarca.checked){
    		marcas=true;
		rutas=false; 
		formcache.marcaRutas.checked=false;
	}else{
		marcas=false;
	}

	if(document.getElementById('on').checked){
    		marcas=true;
		rutas=false;
		formcache.marcaRutas.checked=false; 
	}else{
		marcas=false;
	}
}


";







//Se cargan las areas
//Se colocan cada uno de los marcadores


echo "function cargarAnteriores(map,image){";

$indice=0;
foreach ($marcadores as $apuntador)
if($apuntador!='')
{


//Creamos su ventana de informacion
echo "
var contentString = '<div>';  ";
		
echo " contentString = contentString+'".$direcciones[$indice]."';  ";
echo " contentString = contentString+'</div>';  ";

//++++++++++++++++++++++++++++++++++++++++++++++
echo "		  var posicion=new google.maps.LatLng".$apuntador.";
		  var marker".$indice." = new google.maps.Marker({
      				position: posicion,
      				map: map,
      				title:'',
				draggable:false
  				});


		 var infowindow".$indice." = new google.maps.InfoWindow({   
		 	content:";
echo                    ""."contentString".",
		 	position: posicion,
			maxWidth: 200
		 });
";

//Se le asigna su ventana de informacion
echo "
		google.maps.event.addListener(marker".$indice.", 'click', function() 
				{  infowindow".$indice.".open(map,marker".$indice.");});


";

$indice=$indice+1;

}
echo "}";


//Se colocan cada uno de las areas
echo "function cargarAnterioresAreas(map,image){";

$longitud=count($areas);


foreach ($areas as $area){//para cada bloque de cordenadas diferente

//obtenemos todos los vertices

if($area=="")
	break;

//intentemos hacerlo de dos en dos
$vertices = explode(",",$area); 




//para saber cual es el ultimo
$longitud=count($vertices);


//se establece la ruta del area a crear
echo "	var ruta = [";

	for($i=0;i<$longitud;$i+=2){
		if($i>=$longitud)
			break;
	    	echo "new google.maps.LatLng".$vertices[$i].",".$vertices[$i+1];
		if(($i+2)<$longitud){
			echo ",";
		}
	}
echo  	"];";







echo "	
		var bermuda = new google.maps.Polygon({
   				 	paths: ruta,
   					 strokeColor: '#FF0000',
    					strokeOpacity: 0.8,
   					 strokeWeight: 2,
    					fillColor: '#FF0000',
    					fillOpacity: 0.35,
					editable: true
  				});
					bermuda.setMap(map);	 
";
}

echo "}";







//se termina de poner el script de javascript


echo "

   </script>  </head> 

<body onload='initialize()'>  

<div id='map_canvas' style='width:700; height:500;position:relative; top:0px; left:0px;'></div>  
<div id='formulario' style='position:absolute; top:0; right:0;'>
<table>
<form name='targetmain' action='cargarMapa.php' method='post'>

<p>
<input type='checkbox' name='habilitaMarca'  id='on' onClick='habilitarMarcas()'>Habilitar Marcas</input>
<input type='checkbox' name='marcaRutas'  id='este' onClick='habilitarRutas()'>Trazar rutas</input>


        <input id='datosMarcas' name='datosMarcas' type='hidden' value='' />
	<input id='datosAreas' name='datosAreas' type='hidden' value='' />

	<input id='datoCP' name='datoCP' type='hidden' value='' />
	<input id='datoIDEstado' name='datoIDEstado' type='hidden' value='' />
	<input id='datoIDMunicipio' name='datoIDMunicipio' type='hidden' value='' />
	<input id='datoIDLocalidad' name='datoIDLocalidad' type='hidden' value='' />
	<input id='datoDireccion' name='datoDireccion' type='hidden' value='' />
	<input id='datoNumero' name='datoNumero' type='hidden' value='' />
	<input id='latitud' name='latitud' type='hidden' value='' />
	<input id='longitud' name='longitud' type='hidden' value='' />
	<input id='datoPropietario' name='datoPropietario' type='hidden' value='' />
	<input id='datoLongitud' name='datoLongitud' type='hidden' value='' />
	<input id='datoLatitud' name='datoLatitud' type='hidden' value='' />
	
</p>

";
//ponemos los campos para el formulario
echo"
<p><tr><td> IDEstado		</td><td><input id='idestado' type='text' name='idestado' value='29'> </td></tr></p>
<p><tr><td> IDMunicipio		</td>	<td><input id='idmunicipio' type='text' value='10'name='idmunicipio'></td></tr></p>
<p><tr><td> IDLocalidad		</td>	<td><input id='idlocalidad' type='text' value='1'name='idlocalidad'></td></tr></p>
<p><tr><td> Direccion		</td>	<td><input id='direccion' type='text' name='direccion'></td></tr></p>
<p><tr><td> Numero		</td><td><input id='numero' type='text' name='numero'></td></tr></p>
<p><tr><td> CP			</td>	<td><input id='cp' type='text' name='cp' value='90800'></td>
";

echo "
</tr></p>
";

echo "<p><tr><td>Propietario</td><td>";
//se pone el select para los propietarios
echo "<select id='idpropietario' name='idpropietario'> Propietario";

for ($i=0;$i<count($propietarios);$i++){
	echo "<option value=".$clavesPropietario[$i].">".$propietarios[$i]."</option>";
}

echo "</select>";

echo "
</td></tr></p>
";
//ponemos el boton para finalizar y enviar el formulario
echo"
        <input name='button2' type='button' 
onclick='EnviaDatos1()' value='Enviar Datos' />

</table>
</form>

</div> 
</body></html>
";

?>
