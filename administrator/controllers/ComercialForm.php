<?php
session_start();
include ("../models/Base.php");
include ("../models/Comercial.php");


$pacote = $_POST['pac'];
$tela	= $_POST['tela'];

switch ($tela) {
	case 'comercial':
		switch ($_POST['op']) {
			case 'Inserir':
				$comercial = new Comercial();
				$comercial->conectar();
				$_POST['senha'] = substr(md5($_POST['senha']),0,100); 
				//verificar se ja existe o mesmo login
				$sql = "SELECT id FROM comercial WHERE email = '".$comercial->anti_injection($_POST['email'])."' ";
				$query = mysql_query($sql);
				echo mysql_error();
				if(mysql_num_rows($query) == 0){
					$retorno = $comercial->inserirComercial($_POST);
				}else{
					$_SESSION['alert'] = "Problemas na inserção: Email utilizado por outro usuário";
					header("Location: ../index.php?pac=$pacote&tela=".$tela."Form&op=Inserir");
				}
				
				
				if($retorno){
					$_SESSION['alert'] = "Inserido com sucesso!";			
				}else{
					$_SESSION['alert'] = "Problemas na inserção";
				}
				header("Location: ../index.php?pac=$pacote&tela=".$tela."Grid");
				exit;
			break;
			
			case 'Editar':
				$comercial =  new Comercial();
				$comercial->conectar();
				//verificar se ja existe o mesmo login
				$sql = "SELECT * FROM comercial WHERE email = '".$comercial->anti_injection($_POST['email'])."' AND id <> '".$comercial->anti_injection($_POST['id'])."'";
				$query = mysql_query($sql)or die(mysql_error());
				$sql2 = "SELECT * FROM comercial WHERE  id ='".$comercial->anti_injection($_POST['id'])."'";
				$query2 = mysql_query($sql2)or die(mysql_error());
				$varificaSenha = mysql_fetch_array($query2);
				if($_POST['senha'] != $varificaSenha['senha']){
					 $_POST['senha'] = substr(md5($_POST['senha']),0,100);
				}
				if(mysql_num_rows($query) == 0){
				$retorno = $comercial->editarComercial($_POST,$_POST['id']);
				}else{
					$_SESSION['alert'] = "Problemas na edição: Email utilizado por outro usuário";
					header("Location: ../index.php?pac=$pacote&tela=".$tela."Form&op=Editar&i=".$_POST['id']);
					exit;
				}	
				if($retorno){
					$_SESSION['alert'] = "Editado com sucesso!";			
				}else{
					$_SESSION['alert'] = "Problemas na edição";
				}
				header("Location: ../index.php?pac=$pacote&tela=".$tela."Grid");
				exit;
			break;
			
			case 'Deletar':
				
				$comercial =  new Comercial();
				foreach ($_POST['id'] as $id){
					$retorno = $comercial->excluirComercial($comercial->anti_injection($id),'id');
				}
				if($retorno){
					$_SESSION['alert'] = "Excluido com sucesso!";			
				}else{
					$_SESSION['alert'] = "Problemas na exclusão";
				}
				header("Location: ../index.php?pac=$pacote&tela=".$tela."Grid");
				exit;
			break;
		}//fim categoria
}
?>