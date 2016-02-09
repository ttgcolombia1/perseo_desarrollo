<?php
$this->idioma[sha1('usuario'.$_REQUEST['tiempo'])]="Identificación: ";
$this->idioma[sha1('clave'.$_REQUEST['tiempo'])]="Clave: ";
$this->idioma[sha1('usuario'.$_REQUEST['tiempo']).'Titulo']='Número de documento o código en caso de estudiantes.';
$this->idioma[sha1('clave'.$_REQUEST['tiempo']).'Titulo']="Clave de Acceso";
$this->idioma["botonAceptar"]="Aceptar";
$this->idioma["botonCancelar"]="Cancelar";
$this->idioma["noDefinido"]="No definido";
$this->idioma["botonIngresar"]="Ingresar";

?>