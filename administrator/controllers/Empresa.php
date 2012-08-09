<?php
session_start();
include ("../models/Base.php");
include ("../models/Empresa.php");


$pacote = $_POST['pac'];
$tela	= $_POST['tela'];

switch ($tela) {
	case 'empresa':
		switch ($_POST['op']) {
			case 'Inserir':
				$empresa =  new Empresa();
				$empresa->conectar();
				$_POST['senha'] = substr(md5($_POST['senha']),0,30);		
				$retorno = $empresa->inserirEmpresa($_POST);
				
				if($retorno){
					$_SESSION['alert'] = "Inserido com sucesso!";			
				}else{
					$_SESSION['alert'] = "Problemas na inser��o";
				}
				if($_SESSION['comercial']){
					header("Location: ../../comercial/index.php?p=empresaGrid");
				}else{
					//header("Location: ../index.php?pac=".$pacote."&tela=".$tela."Grid");
					echo'<script language="JavaScript" type="text/javascript">
  							window.location = "../index.php?pac='.$pacote.'&tela='.$tela.'Grid";
						</script>';
				}
			exit;
			break;
			
			case 'Editar':
				$empresa =  new Empresa();
				$empresa->conectar();
				$sql2 = "SELECT * FROM empresa WHERE  id ='".$_POST['id']."'";
				$query2 = mysql_query($sql2)or die(mysql_error());
				$varificaSenha = mysql_fetch_array($query2);
				if($_POST['senha'] != $varificaSenha['senha']){
					$_POST['senha'] = substr(md5($_POST['senha']),0,30);
				}
				$retorno = $empresa->editarEmpresa($_POST,$_POST['id']);
					
				if($retorno){
					$_SESSION['alert'] = "Editado com sucesso!";			
				}else{
					$_SESSION['alert'] = "Problemas na edi��o";
				}
				if($_SESSION['empresa']){
					header("Location: ../../parceiro");
				}else{
					//header("Location: ../index.php?pac=".$pacote."&tela=".$tela."Grid");
					echo'<script language="JavaScript" type="text/javascript">
  							window.location = "../index.php?pac='.$pacote.'&tela='.$tela.'Grid";
						</script>';
				}
				if($_SESSION['comercial']){
					header("Location: ../../comercial/index.php?p=empresaGrid");
				}else{
					header("Location: ../index.php?pac=".$pacote."&tela=".$tela."Grid");
				}
				
				exit;
			break;
			
			case 'Deletar':
				
				$empresa =  new Empresa();
				foreach ($_POST['id'] as $id){
					$retorno = $empresa->excluirEmpresa($id,'id');
				}
				if($retorno){
					$_SESSION['alert'] = "Empresa excluida com sucesso!";			
				}else{
					$_SESSION['alert'] = "Problemas na exclus�o";
				}
				
				if($_SESSION['comercial']){
					header("Location: ../../comercial/index?p=empresaGrid");
				}else{
					//header("Location: ../index.php?pac=".$pacote."&tela=".$tela."Grid");
					echo'<script language="JavaScript" type="text/javascript">
  							window.location = "../index.php?pac='.$pacote.'&tela='.$tela.'Grid";
						</script>';
				}				
				exit;
			break;
		}//fim cliente
}
?>