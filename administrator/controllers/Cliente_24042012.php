<?php
session_start();
include ("../models/Base.php");
include ("../models/Cliente.php");
include ("../models/CidadeCliente.php");

$pacote = $_POST['pac'];
$tela	= $_POST['tela'];
$headers = 'From: atendimento@edegraca.com.br' . "\r\n" .
    								'Reply-To: atendimento@edegraca.com.br' . "\r\n" .
    								'X-Mailer: PHP/' . phpversion();

switch ($tela) {
	case 'cliente':
		switch ($_POST['op']) {
			case 'Inserir':
				if($_SESSION['captcha'] != $_POST['captcha']){
					$_SESSION['alert'] = utf8_encode("Código de Segurança Inválido");
					//header("Location: ../../cadastro.php");
					?>
						 <script language="JavaScript" type="text/javascript">
  								window.location = "../../cadastro.php";				
						</script>
  					<?php
				}else{
					$cliente =  new Cliente();
					$cliente->conectar();
					$_POST['nome'] = $cliente->anti_injection(utf8_decode($_POST['nome']));
					$_POST['cidade'] = utf8_decode($_POST['cidade']);
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
						if($_POST['receber_news'] == "sim"){
							$_POST['receber_news'] = "0";
						}else{
							$_POST['receber_news'] = "1";
						}
						
					
					echo mysql_error();
					
					if(mysql_num_rows($query) == 0){
						$retorno = $cliente->inserirCliente($_POST);
						mail($_POST['email'],"Seu Codigo para o sorteio","segue seu codigo para o sorteio boa sorte </br></br>Codigo:".$_POST['captcha'],$headers);					
						$ObjCidadesCliente = new CidadeCliente();
						
						if(!empty($_POST['id_cidades'])){
						 	foreach ($_POST['id_cidades'] as $AtualCidade){
								$cidade['id_cliente'] = $retorno;
								$cidade['id_cidade'] = $AtualCidade;
								$ObjCidadesCliente->inserirCidadeCliente($cidade);	
						 	}
						}						
					}else{
						$_SESSION['alert'] = utf8_encode("E-mail utilizado por outro Usu�rio");
						if($_SESSION['administrador']){
							//header("Location: ../index.php?pac=".$pacote."&tela=".$tela."Form&op=Inserir");
								?>
						 		<script language="JavaScript" type="text/javascript">
  										window.location = "../index.php?pac=<?php echo $pacote."&tela=".$tela."Form&op=Inserir";?>";				
								</script>
  					<?php
						}else{
							//header("Location: ../../cadastro.php");
								?>
						 <script language="JavaScript" type="text/javascript">
  								window.location = "../../cadastro.php";				
						</script>
  					<?php
						}
						exit;
					}
						
					if($retorno){
						$_SESSION['nome'] = $_POST['nome'];
						$_SESSION['email'] = $_POST['email'];						
					}else{
						$_SESSION['alert'] = utf8_encode("Problemas na inser��o");
						if($_SESSION['administrador']){
							//header("Location: ../index.php?pac=".$pacote."&tela=".$tela."Form&op=Inserir");
							?>
						 <script language="JavaScript" type="text/javascript">
  								window.location = "../index.php?pac=<?php echo $pacote."&tela=".$tela."Form&op=Inserir";?>";				
						</script>
  					<?php
						}else{
							//header("Location: ../../cadastro.php");
							?>
						 <script language="JavaScript" type="text/javascript">
  								window.location = "../../cadastro.php";				
						</script>
  					<?php
						}
					}
					if($_SESSION['administrador']){
						//header("Location: ../index.php?pac=".$pacote."&tela=".$tela."Form&op=Inserir");
						?>
						 <script language="JavaScript" type="text/javascript">
  								window.location = "../index.php?pac=<?php echo $pacote."&tela=".$tela."Form&op=Inserir";?>";				
						</script>
  					<?php
					}else{
						$_SESSION['alert'] = "Parab&eacute;ns voc&ecirc; se cadastrou no &Eacute; de Gra&ccedil;a o melhor site de Compra coletiva do Brasil!!";
						if(!empty($_SESSION['url_compra'])){
					//		header("Location: ../../".$_SESSION['url_compra']);
					
							?>
						 <script language="JavaScript" type="text/javascript">
  								window.location = "<?php echo $_SESSION['url_compra']?>";				
						</script>
  				<?php
						}else{
							//header("Location: ../../cadastro.php");
						
    								
						//mail($_POST['email'],"Seu Codigo para o sorteio","segue seu codigo para o sorteio boa sorte </br></br>Codigo:".$_POST['captcha'],$headers);
						?>
						 <script language="JavaScript" type="text/javascript">
  								window.location = "../../cadastro.php";				
						</script>
  					<?php
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
					$_POST['cidade'] = utf8_decode($_POST['cidade']);
					$retorno = $cliente->editarCliente($_POST,$_POST['id']);
					mail($_POST['email'],"Seu Codigo para o sorteio","segue seu codigo para o sorteio boa sorte  Codigo:".$_POST['captcha'],$headers);					
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
					$_SESSION['alert'] = "Problemas na edi��o: Email utilizado por outro usu�rio";
					if($_SESSION['administrador']){
						//header("Location: ../index.php?pac=".$pacote."&tela=".$tela."Form&op=Editar&i=".$_POST['id']);
						?>
						 <script language="JavaScript" type="text/javascript">
  								window.location = "../index.php?pac=.<?php echo $pacote."&tela=".$tela."Form&op=Editar&i=".$_POST['id']?>";				
						</script>
  				<?php
					}else{
						//header("Location: ../../cadastro.php");
						?>
						 <script language="JavaScript" type="text/javascript">
  								window.location = "../../cadastro.php";				
						</script>
  				<?php
					}
					exit;
				}
					
				if($retorno){
					$_SESSION['alert'] = "Parab&eacute;ns voc&ecirc; se cadastrou no &Eacute; de Gra&ccedil;a o melhor site de Compra coletiva do Brasil!!!";
				}else{
					$_SESSION['alert'] = "Problemas na edi��o";
					if($_SESSION['administrador']){
						//header("Location: ../index.php?pac=".$pacote."&tela=".$tela."Form&op=Editar&i=".$_POST['id']);
						?>
						 <script language="JavaScript" type="text/javascript">
  								window.location = "../index.php?pac=.<?php echo $pacote."&tela=".$tela."Form&op=Editar&i=".$_POST['id']?>";				
						</script>
  				<?php
					}else{
						//header("Location: ../../cadastro.php");
											?>
						 <script language="JavaScript" type="text/javascript">
  								window.location = "../../cadastro.php";				
						</script>
  				<?php
					}
				}
				if($_SESSION['administrador']){
					//header("Location: ../index.php?pac=".$pacote."&tela=".$tela."Form&op=Editar&i=".$_POST['id']);
					?>
						 <script language="JavaScript" type="text/javascript">
  								window.location = "../index.php?pac=.<?php echo $pacote."&tela=".$tela."Form&op=Editar&i=".$_POST['id']?>";				
						</script>
  				<?php
					
				}else{
					//header("Location: ../../cadastro.php");
					?>
						 <script language="JavaScript" type="text/javascript">
  								window.location = "../../cadastro.php";				
						</script>
  				<?php
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
					$_SESSION['alert'] = "Problemas na exclus�o";
				}
				//header("Location: ../index.php?pac=".$pacote."&tela=".$tela."Grid");
				?>
						 <script language="JavaScript" type="text/javascript">
  								window.location = "../index.php?pac=".<?php echo $pacote;?>."&tela=".<?php echo $tela;?>."Grid"";				
						</script>
  				<?php
				exit;
				break;
		}//fim cliente
}
?>