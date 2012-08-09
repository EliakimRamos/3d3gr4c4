<?php
session_start();
require_once ("../models/Base.php");
require_once ("../models/Contapagar.php");


$pacote = $_POST['pacote'];
$tela	= $_POST['tela'];

switch ($tela) {
	case 'contapagar':
		switch ($_POST['op']) {
			case 'Inserir':				
				$contapagar =  new Contapagar();
				$contapagar->conectar();			
				$retorno = $contapagar->inserirContapagar($_POST);
				
				if($retorno){
					$_SESSION['alert'] = "Inserida com sucesso!";			
				}else{
					$_SESSION['alert'] = "Problemas na inserчуo";
				}
				
				header("Location: ../index.php?pac=$pacote&tela=".$tela."Grid");
				exit;
			break;
			
			case 'Editar':
				$contapagar =  new Contapagar();
				$contapagar->conectar();				
				$retorno = $contapagar->editarContapagar($_POST,$_POST['id_contapagar']);
					
				if($retorno){
					$_SESSION['alert'] = "Editada com sucesso!";			
				}else{
					$_SESSION['alert'] = "Problemas na ediчуo";
				}
				header("Location: ../index.php?pac=$pacote&tela=".$tela."Grid");
				exit;
			break;
			
			case 'Deletar':
				$contapagar =  new Contapagar();
				foreach ($_POST['id'] as $id){
					$retorno = $contapagar->excluirContapagar($id,'id_contapagar');
				}
				if($retorno){
					$_SESSION['alert'] = "Excluida com sucesso!";			
				}else{
					$_SESSION['alert'] = "Problemas na exclusуo";
				}
				header("Location: ../index.php?pac=$pacote&tela=".$tela."Grid");
				exit;
			break;
		}//fim
}
?>