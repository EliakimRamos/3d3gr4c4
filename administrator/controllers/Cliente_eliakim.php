<?php
session_start();
include ("../models/Base.php");
include ("../models/Cliente.php");

$pacote = $_POST['pac'];
$tela	= $_POST['tela'];

switch ($tela) {
	case 'cliente':
		switch ($_POST['op']) {
			case 'Inserir':
				if($_SESSION['captcha'] != $_POST['codigo']){
					$_SESSION['alert'] = "Código de Segurança Inválido";
							if(date("d/m/Y") != "15/11/2010"){
								header("Location: ../../cadastro.php");
							}else{
								header("Location: ../../cadastro.php");
							}
				}else{
					$cliente =  new Cliente();
					$cliente->conectar();
					$_POST['nome'] = utf8_decode($_POST['nome']);
					$_POST['data_cadastro'] = date("d/m/Y");
					$_POST['hora_cadastro'] = date("H:i");
					$_POST['senha'] = substr(md5($_POST['senha']),0,100);
					//verificar se ja existe o mesmo login
					$sql = "SELECT id FROM cliente WHERE email = '".$_POST['email']."' ";
						
					$query = mysql_query($sql);
					if($_POST['sms'] == "sim"){
						$_POST['receber_sms'] = "0";
					}else{
						$_POST['receber_sms'] = "1";
					}
					
						$_POST['receber_news'] = "0";
					
					echo mysql_error();
					if(mysql_num_rows($query) == 0){
						$retorno = $cliente->inserirCliente($_POST);
					}else{

						$_SESSION['alert'] = "E-mail utilizado por outro Usuário";
						if($_SESSION['administrador']){
							header("Location: ../index.php?pac=".$pacote."&tela=".$tela."Form&op=Inserir");
						}else{
							if(date("d/m/Y") != "15/11/2010"){
								header("Location: ../../cadastro.php");
							}else{
								header("Location: ../../cadastro.php");
							}
						}
						exit;
					}
						
					if($retorno){
						$_SESSION['nome'] = $_POST['nome'];
						$_SESSION['email'] = $_POST['email'];
					}else{

						$_SESSION['alert'] = "Problemas na inserção";
						if($_SESSION['administrador']){
							header("Location: ../index.php?pac=".$pacote."&tela=".$tela."Form&op=Inserir");
						}else{
							if(date("d/m/Y") != "15/11/2010"){
								header("Location: ../../cadastro.php");
							}else{
								header("Location: ../../cadastro.php");
							}
						}
					}
					if($_SESSION['administrador']){
						header("Location: ../index.php?pac=".$pacote."&tela=".$tela."Form&op=Inserir");
					}else{
						if(date("d/m/Y") != "15/11/2010"){
								$_SESSION['alert'] = "Obrigado por se cadastrar no Pechincha";
								header("Location: ../../cadastro.php");
							}else{
								$_SESSION['alert'] = "Obrigado por se cadastrar no Pechincha";
								if(!empty($_SESSION['url_compra'])){
									header("Location: ../../".$_SESSION['url_compra']);
								}else{
									header("Location: ../../cadastro.php");
								}
							}
					}
				}
				exit;
				break;
					
			case 'Editar':
				$cliente =  new Cliente();
				$cliente->conectar();
				$_POST['nome'] = utf8_decode($_POST['nome']);
				//verificar se ja existe o mesmo login
				$sql = "SELECT * FROM cliente WHERE email = '".$_POST['email']."' AND id <> '".$_POST['id']."'";
				$query = mysql_query($sql)or die(mysql_error());
				$sql2 = "SELECT * FROM cliente WHERE  id ='".$_POST['id']."'";
				$query2 = mysql_query($sql2)or die(mysql_error());
				$varificaSenha = mysql_fetch_array($query2);
				if($_POST['sms'] == "sim"){
					$_POST['receber_sms'] = "0";
				}else{
					$_POST['receber_sms'] = "1";
				}
				if($_POST['newsletter'] == "sim"){
					$_POST['receber_news'] = "0";
				}else{
					$_POST['receber_news'] = "1";
				}

				if($_POST['senha'] != $varificaSenha['senha']){
					$_POST['senha'] = substr(md5($_POST['senha']),0,100);
				}
				//echo mysql_num_rows($query);
				if(mysql_num_rows($query) == 0){
					$retorno = $cliente->editarCliente($_POST,$_POST['id']);
				}else{
					$_SESSION['alert'] = "Problemas na edição: Email utilizado por outro usuário";
					if($_SESSION['administrador']){
						header("Location: ../index.php?pac=".$pacote."&tela=".$tela."Form&op=Editar&i=".$_POST['id']);
					}else{
						header("Location: ../../Cliente/Cadastrar.php");
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
					
			case 'Deletar':

				$cliente =  new Cliente();
				foreach ($_POST['id'] as $id){
					$retorno = $cliente->excluirCliente($id,'id');
				}
				if($retorno){
					$_SESSION['alert'] = "Cliente excluido com sucesso!";
				}else{
					$_SESSION['alert'] = "Problemas na exclusão";
				}
				header("Location: ../index.php?pac=".$pacote."&tela=".$tela."Grid");
				exit;
				break;
		}//fim cliente
}
?>