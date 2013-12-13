        function loginSistema(usuario,password){
            var url="/serviciosMunicipales/core/login.php";
            $.ajax({   
                type: "POST",
                url:url,
                data:{
					"usuario":usuario,
					"password":password	
					},
                success: function(datos){    
				    //inicializamapa();
                    $('#sistema').html(datos);
					$('#sistema').ready(function(){
						var script = document.createElement('script');
						script.type = 'text/javascript';
						script.id = 'googleMaps';
						script.src = 'https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&callback=initGoogle';
						document.body.appendChild(script);
					});
                }
            });
        }