<?php
session_start();
include ("../models/Base.php");
include ("../models/Cliente.php");
include ("../models/CidadeCliente.php");

$pacote = $_POST['pac'];
$tela	= $_POST['tela'];

switch ($tela) {
	case 'cliente':
		switch ($_POST['op']) {
			case 'Inserir':
				if($_SESSION['captcha'] != $_POST['codigo']){
					$_SESSION['alert'] = utf8_encode("Código de Segurança Inválido");
					header("Location: ../../index.php");
				}else{
					$cliente =  new Cliente();
					$cliente->conectar();
					$_POST['nome'] = $cliente->anti_injection(utf8_decode($_POST['nome']));
					$_POST['data_cadastro'] = date("d/m/Y");
					$_POST['hora_cadastro'] = date("H:i");
					$_POST['senha'] = substr(md5($_POST['senha']),0,30);
					$_POST['identificador'] = substr(md5($_POST['nome'].$_POST['email'].$_POST['data_cadastro'].$_POST['hora_cadastro']), 0,5);

					//verificar se ja existe o mesmo login
					$sql = "SELECT id FROM cliente WHERE email = '".$cliente->anti_injection($_POST['email'])."' ";
						
					$query = mysql_query($sql);
					if($_POST['sms'] == "sim"){
						$_POST['receber_sms'] = "0";
					}else{
						$_POST['receber_sms'] = "1";
					}					
						$_POST['receber_news'] = "0";
					
					echo mysql_error();
					
					if(mysql_num_rows($query) == 0){
						$ObjCidadesCliente = new CidadeCliente();						
						$nomeCidade = $ObjCidadesCliente->getCidadeCliente($cliente->anti_injection($_POST['cidade']));
						$_POST['cidade'] = $nomeCidade['descricao'];
						$retorno = $cliente->inserirCliente($_POST);					
						
						
						if(!empty($_POST['id_cidades'])){
						 	foreach ($_POST['id_cidades'] as $AtualCidade){
								$cidade['id_cliente'] = $retorno;
								$cidade['id_cidade'] = $AtualCidade;
								$ObjCidadesCliente->inserirCidadeCliente($cidade);	
						 	}
						}						
					}else{
						$_SESSION['alert'] = utf8_encode("E-mail utilizado por outro Usuário");
						if($_SESSION['administrador']){
							header("Location: ../index.php?pac=".$pacote."&tela=".$tela."Form&op=Inserir");
						}else{
							header("Location: ../../index.php");
						}
						exit;
					}
						
					if($retorno){
						$_SESSION['nome'] = $_POST['nome'];
						$_SESSION['email'] = $_POST['email'];						
					}else{
						$_SESSION['alert'] = utf8_encode("Problemas na inserção");
						if($_SESSION['administrador']){
							header("Location: ../index.php?pac=".$pacote."&tela=".$tela."Form&op=Inserir");
						}else{
							header("Location: ../../index.php");
						}
					}
					if($_SESSION['administrador']){
						header("Location: ../index.php?pac=".$pacote."&tela=".$tela."Form&op=Inserir");
					}else{
						$_SESSION['alert'] = "Obrigado por se cadastrar no Pechincha!";
						$_SESSION['Cadastrei'] = $_POST['cidade'];
						if(!empty($_SESSION['url_compra'])){
							header("Location: ../../".$_SESSION['url_compra']);
						}else{
							header("Location: ../../index.php?idCidade=".$_POST['cidade']);
						}
					}
				}
				exit;
				break;
					
			case 'Editar':
				$cliente =  new Cliente();
				$cliente->conectar();
				$_POST['nome'] = $cliente->anti_injection(utf8_decode($_POST['nome']));
				//verificar se ja existe o mesmo login
				$sql = "SELECT * FROM cliente WHERE email = '".$cliente->anti_injection($_POST['email'])."' AND id <> '".$cliente->anti_injection($_POST['id'])."'";
				$query = mysql_query($sql)or die(mysql_error());
				$sql2 = "SELECT * FROM cliente WHERE  id ='".$cliente->anti_injection($_POST['id'])."'";
				$query2 = mysql_query($sql2)or die(mysql_error());
				$varificaSenha = mysql_fetch_array($query2);
				if($_POST['sms'] == "sim"){
					$_POST['receber_sms'] = "0";
				}else{
					$_POST['receber_sms'] = "1";
				}

				if($_POST['senha'] != $varificaSenha['senha']){
					$_POST['senha'] = substr(md5($_POST['senha']),0,100);
				}
				//echo mysql_num_rows($query);
				if(mysql_num_rows($query) == 0){
					$retorno = $cliente->editarCliente($_POST,$_POST['id']);					
					$ObjCidadesCliente = new CidadeCliente();
					$ObjCidadesCliente->excluirCidadeCliente($_POST['id'], "id_cliente");
						
					if(!empty($_POST['id_cidades'])){
					 	foreach ($_POST['id_cidades'] as $AtualCidade){
							$cidade['id_cliente'] = $retorno;
							$cidade['id_cidade'] = $AtualCidade;
							$ObjCidadesCliente->inserirCidadeCliente($cidade);	
					 	}
					}	
				}else{
					$_SESSION['alert'] = "Problemas na edição: Email utilizado por outro usuário";
					if($_SESSION['administrador']){
						header("Location: ../index.php?pac=".$pacote."&tela=".$tela."Form&op=Editar&i=".$_POST['id']);
					}else{
						header("Location: ../../index.php");
					}
					exit;
				}
					
				if($retorno){
					$_SESSION['alert'] = "Editado com sucesso!";
				}else{
					$_SESSION['alert'] = "Problemas na edição";
					if($_SESSION['administrador']){
						header("Location: ../index.php?pac=".$pacote."&tela=".$tela."Form&op=Editar&i=".$_POST['id']);
					}else{
						header("Location: ../../Cliente/Cadastrar.php");
					}
				}
				if($_SESSION['administrador']){
					header("Location: ../index.php?pac=".$pacote."&tela=".$tela."Form&op=Editar&i=".$_POST['id']);
				}else{
					header("Location: ../../minhaconta2.php");
				}
				exit;
				break;
		}//fim cliente
}
?>