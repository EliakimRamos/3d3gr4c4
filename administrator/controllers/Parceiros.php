<?php
session_start();

require_once("../models/Base.php");
require_once("../models/Login.php");

$ObjLogin = new Login();

$user = $ObjLogin->anti_injection($_POST['email']);
$pass = $ObjLogin->anti_injection($_POST['senha']);

$tabela = "empresa";

$retorno = $ObjLogin->Logar($user,$pass,$tabela);

if($retorno){
	$_SESSION['nome'] = $retorno['nome'];
	$_SESSION['id'] = $retorno['id'];
	$_SESSION['empresa'] = true;
	$ObjLogin->loglogin($_SESSION['id'],"3");
}else{
	$_SESSION['alert'] = "Usuário ou Senha Inválidos !";
}
	//header("Location: ../../parceiro/index.php");
	echo"<script>window.location='../../parceiro/index.php';</script>";
?>
