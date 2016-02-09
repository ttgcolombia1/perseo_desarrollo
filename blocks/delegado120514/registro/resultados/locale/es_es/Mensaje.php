<?php
//------------------Mensajes ----------------------------------- 

$this->idioma["mensajeVotacionesAbiertas"]="<p class='textoCentrar'>Las votaciones aun se encuentran abiertas, para poder visualizar el resultado se debe realizar el cierre y decodificar los votos</p>";

$this->idioma["botonVerResultado"] = "Visualizar Resultados";

$this->idioma["mensajeVotosNoDecodificados"] = "<p class='textoCentrar'>No existen votos decodificados</p>";

$this->idioma["mensajeUsuarioError"] = "<p class='textoCentrar'>El usuario digitado no existe, por favor vuelva a intentar</p>";

$this->idioma["mensajeClaveError"] = "<p class='textoCentrar'>Nombre de usuario o contraseña incorrecta</p>";

$this->idioma["noDefinido"] = 'No Definido';
if(isset($argumentos) && is_array($argumentos)){
	switch($argumentos['tipo']){
		
		case 'totalVotos':
			$this->idioma["mensajeTotalVotos"]='Total de Votación:'.$argumentos['totalVotos'];
			
	}
}
?>