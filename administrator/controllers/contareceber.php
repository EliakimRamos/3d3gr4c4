<?php
session_start();
include '../../models/Base.php';
include '../../models/Contareceber.php';


$pacote = $_POST['pacote'];
$tela	= $_POST['tela'];

switch ($tela) {
	case 'contareceber': 
		switch ($_POST['op']) {
			case 'Inserir':
				$contareceber =  new Contareceber();
				$contareceber->conectar();
				//var_dump($_POST);die;
				if(!empty($_POST['parcelas'])){
					$i = 0;
					$_POST['qtd_parcela'] = $_POST['parcelas'];
					$valorParcela = $_POST['valorareceber'] /$_POST['qtd_parcela'];
					for ($i = 1; $_POST['qtd_parcela'] >= $i; $i++) { 
						$_POST['valorparcela'] =  $valorParcela;
						$_POST['vencimento'] = date("d/m/Y", mktime(0, 0, 0, date("m") + $i, date("d"), date("Y")));
						
						$_POST['bandeira'] = $_POST['pagamento'];
						$_POST['banco'] = $_POST['banco1'][$i];	
						$_POST['numParcela'] = $i;
						$retorno = $contareceber->inserirContareceber($_POST);
						
					}
				}else{
					$_POST['valorparcela'] = $_POST['valorareceber'];
					$_POST['numero'] = $_POST['numerocheque'];
					$_POST['banco']  = $_POST['pagamento'];
					if(!empty($_POST['vencimentocheque'])){
						$_POST['vencimento']  = $_POST['vencimentocheque'];
					}else{
						$_POST['vencimento']  = date("d/m/Y");
					}
					$_POST['qtd_parcela'] = 1;
					$_POST['numParcela'] = 1;
					$retorno = $contareceber->inserirContareceber($_POST);
				}
				if($retorno){
					$_SESSION['alert'] = "Inserida com sucesso!";			
				}else{
					$_SESSION['alert'] = "Problemas na inserчуo";
				}
				
				header("Location: ../../index.php?pac=$pacote&tela=".$tela."Grid");
				exit;
			break;
			
			case 'Editar':
				$contareceber =  new Contareceber();
				$contareceber->conectar();
				
				if($_POST['id_situacao'] == "4"){
					$_POST['dia_pagamento'] = date("d/m/Y");
				}
				$retorno = $contareceber->editarContareceber($_POST,$_POST['id_contareceber']);
				
							
				if($retorno){
					$_SESSION['alert'] = "Editada com sucesso!";			
				}else{
					$_SESSION['alert'] = "Problemas na ediчуo";
				}
				header("Location: ../../index.php?pac=$pacote&tela=".$tela."Grid");
				exit;
			break;
			
			case 'Deletar':
				
				$contareceber =  new Contareceber();
				foreach ($_POST['id'] as $id){
					$retorno = $contareceber->excluirContareceber($id,'id_contareceber');
				}
				if($retorno){
					$_SESSION['alert'] = "Conta a receber excluida com sucesso!";			
				}else{
					$_SESSION['alert'] = "Problemas na exclusуo";
				}
				header("Location: ../../index.php?pac=$pacote&tela=".$tela."Grid");
				exit;
			break;
		}//fim contareceber
}
?>