<?php session_start();
require_once("administrator/models/Base.php");
require_once("administrator/models/Login.php");

$objLogin = new Login();

$email = $objLogin->anti_injection($_POST['email']);
$senha = $objLogin->anti_injection($_POST['senha']);

$retorno = $objLogin->Logar($email,$senha,"cliente");
	

if($retorno){
	
	$_SESSION['cliente'] = true;
	$_SESSION['nome'] = $retorno['nome'];
	$_SESSION['email'] = $retorno['email'];
	$_SESSION['idclientek'] = $retorno['id'];
	$_SESSION['saldo'] = $retorno['saldo'];
	$objLogin->loglogin($_SESSION['idclientek'],"1");
	if(!empty($_SESSION['url_compra'])){
		//header("location:".$_SESSION['url_compra']);
		echo"<script>window.location='".$_SESSION['url_compra']."';</script>";
	}else {
		
		//header("location:./index.php");
		echo"<script>window.location='index.php';</script>";
	}	
}else{
	if(!empty($_SESSION['url_compra'])){
		$_SESSION['alert'] = "Email ou Senha incorreta!";
		//header("location:./login.php");
		echo"<script>window.location='login.php';</script>";
	}else {
		$_SESSION['alert'] = "Email ou Senha incorreta!";
		//header("location:./login.php");
		echo"<script>window.location='login.php';</script>";	
	}
	
}
?>