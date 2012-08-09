<?php
session_start();

require_once("../models/Base.php");
require_once("../models/Login.php");

$ObjLogin = new Login();

$user = $ObjLogin->anti_injection($_POST['email']);
$pass = $ObjLogin->anti_injection($_POST['senha']);

$tabela = "comercial";

$retorno = $ObjLogin->Logar($user,$pass,$tabela);

if($retorno){
	$_SESSION['nome'] = $retorno['nome'];
	$_SESSION['idcomercial'] = $retorno['id'];
	$_SESSION['comercial'] = true;
	$ObjLogin->loglogin($_SESSION['idcomercial'],"2");
}else{
	$_SESSION['alert'] = "Usuário ou Senha Inválidos !";
}
	header("Location: ../../comercial/index.php");
?>
