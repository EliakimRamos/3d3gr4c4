<?php session_start();
require_once("../models/Base.php");
require_once("../models/Login.php");
require_once("../models/Administrador.php");
require_once("../models/Cliente.php");

$login = new Login();
$administrador = new Administrador();

$user = $login->anti_injection($_POST['email']);
$pass = $login->anti_injection($_POST['senha']);

$tabela = "administrador";

$retorno = $login->Logar($user,$pass,$tabela);

if($retorno){
	$_SESSION['userAdmin'] = "logado";
	$_SESSION['nomeAdmin'] = $retorno['nome'];
	$_SESSION['idAdmin'] = $retorno['id'];
	$_SESSION['nivelAdmin'] = $retorno['nivel'];
	$_SESSION['administradoredegraca'] = true;
	$login->loglogin($_SESSION['id'],"0");
}else{
	$_SESSION['alert'] = "Usuário ou Senha Inválidos";
}
//header("location:../index.php");
echo'<script language="JavaScript" type="text/javascript">
  			window.location = "../index.php";
		</script>';
?>