<?php session_start();
require_once("administrator/models/Base.php");
require_once("administrator/models/Cliente.php");

$ObjCliente = new Cliente();
$email = $ObjCliente->anti_injection($_POST['email']);
$dados = $ObjCliente->getCliente($email,'email');

if(!empty($dados)){
	echo $dados['id'];
}else{
	echo " ";
}
?>
