<?php
session_start();
include ("../models/Base.php");
include ("../models/Administrador.php");


$pacote = $_POST['pac'];
$tela	= $_POST['tela'];

switch ($tela) {
	case 'admin':
		switch ($_POST['op']) {
			case 'Inserir':
				$administrador = new Administrador();
				$administrador->conectar();
				$_POST['senha'] = substr(md5($_POST['senha']),0,100); 
				//verificar se ja existe o mesmo login
				$sql = "SELECT id FROM administrador WHERE email = '".$administrador->anti_injection($_POST['email'])."' ";
				$query = mysql_query($sql);
				echo mysql_error();
				if(mysql_num_rows($query) == 0){
					$retorno = $administrador->inserirAdministrador($_POST);
				}else{
					$_SESSION['alert'] = "Problemas na inser��o: Email utilizado por outro usu�rio";
				//	header("Location: ../index.php?pac=$pacote&tela=".$tela."Form&op=Inserir");
					echo'<script language="JavaScript" type="text/javascript">
  							window.location = "../index.php?pac='.$pacote.'&tela='.$tela.'Form&op=Inserir";
						</script>';
					
				}
				
				
				if($retorno){
					$_SESSION['alert'] = "Inserido com sucesso!";			
				}else{
					$_SESSION['alert'] = "Problemas na inser��o";
				}
				//header("Location: ../index.php?pac=$pacote&tela=".$tela."Form&op=Inserir");
				echo'<script language="JavaScript" type="text/javascript">
  							window.location = "../index.php?pac='.$pacote.'&tela='.$tela.'Form&op=Inserir";
						</script>';
				exit;
			break;
			
			case 'Editar':
				$administrador =  new Administrador();
				$administrador->conectar();
				//verificar se ja existe o mesmo login
				$sql = "SELECT * FROM administrador WHERE email = '".$administrador->anti_injection($_POST['email'])."' AND id <> '".$administrador->anti_injection($_POST['id'])."'";
				$query = mysql_query($sql)or die(mysql_error());
				$sql2 = "SELECT * FROM administrador WHERE  id ='".$administrador->anti_injection($_POST['id'])."'";
				$query2 = mysql_query($sql2)or die(mysql_error());
				$varificaSenha = mysql_fetch_array($query2);
				if($_POST['senha'] != $varificaSenha['senha']){
					 $_POST['senha'] = substr(md5($_POST['senha']),0,100);
				}
				if(mysql_num_rows($query) == 0){
				$retorno = $administrador->editarAdministrador($_POST,$administrador->anti_injection($_POST['id']));
				}else{
					$_SESSION['alert'] = "Problemas na edi��o: Email utilizado por outro usu�rio";
					//header("Location: ../index.php?pac=$pacote&tela=".$tela."Form&op=Editar&i=".$_POST['id']);
					echo'<script language="JavaScript" type="text/javascript">
  							window.location = "../index.php?pac=$pacote&tela='.$tela.'Form&op=Editar&i='.$_POST['id'].'";
						</script>';
					exit;
				}	
				if($retorno){
					$_SESSION['alert'] = "Editado com sucesso!";			
				}else{
					$_SESSION['alert'] = "Problemas na edi��o";
				}
				//header("Location: ../index.php?pac=$pacote&tela=".$tela."Grid");
				echo'<script language="JavaScript" type="text/javascript">
  							window.location = "../index.php?pac='.$pacote.'&tela='.$tela.'Grid";
						</script>';
				exit;
			break;
			
			case 'Deletar':
				
				$administrador =  new Administrador();
				foreach ($_POST['id'] as $id){
					$retorno = $administrador->excluirAdministrador($administrador->anti_injection($id),'id');
				}
				if($retorno){
					$_SESSION['alert'] = "Administrador excluido com sucesso!";			
				}else{
					$_SESSION['alert'] = "Problemas na exclus�o";
				}
				//header("Location: ../index.php?pac=$pacote&tela=".$tela."Grid");
				echo'<script language="JavaScript" type="text/javascript">
  							window.location = "../index.php?pac='.$pacote.'&tela='.$tela.'Grid";
						</script>';
				exit;
			break;
		}//fim categoria
}
?>