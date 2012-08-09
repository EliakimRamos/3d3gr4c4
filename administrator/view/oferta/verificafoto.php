<?php
session_start();
include ("../../models/Base.php");
include ("../../models/Oferta.php");
$oferta =  new Oferta();
$oferta->conectar();
if(empty($_POST['idoferta'])){
	if(empty( $_SESSION['images']['0'])){
	
		echo"sim";
	} 
}else{
	$fotos = $oferta->listarOfertaImagem(' and id_oferta='.$_POST['idoferta']);
	if(empty($fotos)){
		echo"sim";
	}
}
?>
