<?php

$key = '';
$keycar = '';
$keyNum = '';
$longitud=4;
$pattern = 'abcdefghijklmnopqrstuvwxyz';
$num = '1234567890';


$caracter = '=_#$-';
$max = strlen($pattern)-1;
$maxCar = strlen($caracter)-1;
$maxNum = strlen($num)-1;

//selecciona las letras
for($i=0;$i < $longitud;$i++)
{ $key .= $pattern{mt_rand(0,$max)};}
/* selecciona el caracter especial
 for($j=0;$j < 1;$j++)
{ $keycar .= $caracter{mt_rand(0,$maxCar)};}*/
//selecciona los numeros
for($k=0;$k < 2;$k++)
{ $keyNum .= $num{mt_rand(0,$maxNum)};}

$pass=$key.$keycar.$keyNum;
$vida=$this->miConfigurador->getVariableConfiguracion("tiempo_vida_clave");
$horaInicial=date('Y-m-d H:i:s');
$segundos_horaInicial=strtotime($horaInicial);
$segundos_minutoAnadir=$vida*60;
$expiraClave=($segundos_horaInicial+$segundos_minutoAnadir);

$arregloDatos=array('idUsuario' => $_REQUEST["idUsuario"],
					'contrasena'=>$pass,
					'vidaClave'=>$vida,
					'timeClave'=>date('H:i:s',$horaInicial),
					'expiracion'=>$expiraClave,);
var_dump($arregloDatos);
$conexion = "estructura";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
$cadena_sql =  $this->sql->cadena_sql("actualizarContrasena", $arregloDatos);
$resultado = $esteRecursoDB->ejecutarAcceso($cadena_sql, "");

if ($resultado == true) {
    $resultado = urlencode(serialize($resultado));
    $resultado = $this->miConfigurador->fabricaConexiones->crypto->codificar($resultado);
    $this->redireccionar("actualizoContrasena",$arregloDatos);
} else {
    $this->redireccionar("mostrarMensajeNoRegistro", "");
}

//blocks/voto/consultaCenso/funcion/cambiarContrasena.php pendiente cambiar la contraseña

?>
