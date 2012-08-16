<?php
session_start();
include ("../models/Base.php");
include ("../models/Oferta.php");
include ("../models/CidadesOferta.php");
require_once '../models/ClassUpload.php';


$pacote = $_POST['pac'];
$tela	= $_POST['tela'];

$_POST['valor'] = str_replace("R$ ", "", $_POST['valor']);
$_POST['desconto'] = str_replace(" %", "", $_POST['desconto']);
$_POST['valorpromocao'] = str_replace("R$ ", "", $_POST['valorpromocao']);
$_POST['valordesconto'] = str_replace("R$ ", "", $_POST['valordesconto']);

switch ($tela) {
	case 'oferta':
		switch ($_POST['op']) {
			case 'Inserir':
				$oferta =  new Oferta();
				$ObjCidades = new CidadesOferta();
				$handle = new Upload();
				$oferta->conectar();
				$tipos[0] = ".jpg";
				$tipos[1] = ".png";
				$tipos[2] = ".jpeg";
				$tipos[3] = ".JPG";
				$tipos[4] = ".PNG";
				$tipos[5] = ".JPEG";
								
				if($_SESSION['comercial']){
					$_POST['ativa'] = 3;
				}
				$retorno = $oferta->inserirOferta($_POST);
				if($retorno){
					foreach ($_POST['Regulamento'] as $Dadosregulamentogeral){
							$cidadeOferta['id_regra'] = $Dadosregulamentogeral;
							$cidadeOferta['id_ofertas'] = $retorno;
							$ObjCidades->inserirregraoferta($cidadeOferta);
					}
					//var_dump($_POST['id_cidade_oferta']);die;
					if(empty($_POST['id_cidade_oferta'][0])){
							$cidadeOferta['id_cidade'] = 1;
							$cidadeOferta['id_oferta'] = $retorno;
							$ObjCidades->inserirEdegracaCidade($cidadeOferta);
					}else{
						foreach ($_POST['id_cidade_oferta'] as $DadosCidades){
								$cidadeOferta['id_cidade'] = $DadosCidades;
								$cidadeOferta['id_oferta'] = $retorno;
								$ObjCidades->inserirEdegracaCidade($cidadeOferta);
						}
					}
					
					if($retorno){
						$_SESSION['alert'] = "Inserida com sucesso!";			
					}else{
						$_SESSION['alert'] = "Problemas na inser��o";
					}
					
					if($_SESSION['comercial']){
						//header("Location: ../../comercial/index.php?p=ofertaGrid");
						echo'<script language="JavaScript" type="text/javascript">
	  							window.location = "../index.php?pac='.$pacote.'&tela='.$tela.'Grid";
							</script>';
					}else{
						//header("Location: ../index.php?pac=".$pacote."&tela=".$tela."Grid");
						echo'<script language="JavaScript" type="text/javascript">
	  							window.location = "../index.php?pac='.$pacote.'&tela='.$tela.'Grid";
							</script>';
					}
					
					
					
					
					
					
					
						if(!empty($_FILES['arquivo'])){
							 $up = $handle->UploadArquivo($_FILES['arquivo'],"../uploads/",$tipos);
							if(!$up){
								$_SESSION['alert'] = "ERROR - ".$handle->error;
								//header("Location: ../index.php?pac=$pacote&tela=".$tela."Form&op=Inserir");
								echo"<script>window.location='../index.php?pac=".$pacote."&tela=".$tela."Form&op=Inserir';</script>";
								exit;
							}else{							
								$_POST['id_oferta'] = $retorno;
								$_POST['image'] = date("dmYHis")."_".$_FILES['arquivo']["name"];
								$retornoArquivo = $oferta->inserirOfertaImage($_POST);
							}
						}	
						if(!empty($_FILES['arquivo1'])){
							 $up = $handle->UploadArquivo($_FILES['arquivo1'],"../uploads/",$tipos);
							if(!$up){
								$_SESSION['alert'] = "ERROR - ".$handle->error;
								//header("Location: ../index.php?pac=$pacote&tela=".$tela."Form&op=Inserir");
								echo"<script>window.location='../index.php?pac=".$pacote."&tela=".$tela."Form&op=Inserir';</script>";
								exit;
							}else{							
								$_POST['id_oferta'] = $retorno;
								$_POST['image'] = date("dmYHis")."_".$_FILES['arquivo1']["name"];
								$retornoArquivo = $oferta->inserirOfertaImage($_POST);
							}
						}	
						if(!empty($_FILES['arquivo2'])){
							 $up = $handle->UploadArquivo($_FILES['arquivo2'],"../uploads/",$tipos);
							if(!$up){
								$_SESSION['alert'] = "ERROR - ".$handle->error;
								//header("Location: ../index.php?pac=$pacote&tela=".$tela."Form&op=Inserir");
								echo"<script>window.location='../index.php?pac=".$pacote."&tela=".$tela."Form&op=Inserir';</script>";
								exit;
							}else{							
								$_POST['id_oferta'] = $retorno;
								$_POST['image'] = date("dmYHis")."_".$_FILES['arquivo2']["name"];
								$retornoArquivo = $oferta->inserirOfertaImage($_POST);
							}
						}
				}
				
				
			exit;
			break;
			
			case 'Editar':
				$oferta =  new Oferta();
				$ObjCidades = new CidadesOferta();
				$handle = new Upload();
				$oferta->conectar();
				$tipos[0] = ".jpg";
				$tipos[1] = ".png";
				$tipos[2] = ".jpeg";
				$tipos[3] = ".JPG";
				$tipos[4] = ".PNG";
				$tipos[5] = ".JPEG";
				$retorno = $oferta->editarOferta($_POST,$oferta->anti_injection($_POST['id']));
				if($retorno){
						
						if(!empty($_FILES['arquivo'])){
							 $up = $handle->UploadArquivo($_FILES['arquivo'],"../uploads/",$tipos);
							if(!$up){
								$_SESSION['alert'] = "ERROR - ".$handle->error;
								//header("Location: ../index.php?pac=$pacote&tela=".$tela."Form&op=Inserir");
								echo'<script language="JavaScript" type="text/javascript">
  							window.location = "../index.php?pac='.$pacote.'&tela='.$tela.'Grid";
						</script>';
								exit;
							}else{							
								$_POST['id_oferta'] = $_POST['id'];
								$_POST['image'] = date("dmYHis")."_".$_FILES['arquivo']["name"];
								$retornoArquivo = $oferta->inserirOfertaImage($_POST);
							}
						}	
						if(!empty($_FILES['arquivo1'])){
							 $up = $handle->UploadArquivo($_FILES['arquivo1'],"../uploads/",$tipos);
							if(!$up){
								$_SESSION['alert'] = "ERROR - ".$handle->error;
								//header("Location: ../index.php?pac=$pacote&tela=".$tela."Form&op=Inserir");
								echo'<script language="JavaScript" type="text/javascript">
  							window.location = "../index.php?pac='.$pacote.'&tela='.$tela.'Grid";
						</script>';
								exit;
							}else{							
								$_POST['id_oferta'] = $_POST['id'];
								$_POST['image'] = date("dmYHis")."_".$_FILES['arquivo1']["name"];
								$retornoArquivo = $oferta->inserirOfertaImage($_POST);
							}
						}	
						if(!empty($_FILES['arquivo2'])){
							 $up = $handle->UploadArquivo($_FILES['arquivo2'],"../uploads/",$tipos);
							if(!$up){
								$_SESSION['alert'] = "ERROR - ".$handle->error;
								//header("Location: ../index.php?pac=$pacote&tela=".$tela."Form&op=Inserir");
								echo'<script language="JavaScript" type="text/javascript">
  									window.location = "../index.php?pac='.$pacote.'&tela='.$tela.'Grid";
								</script>';
								exit;
							}else{							
								$_POST['id_oferta'] = $_POST['id'];
								$_POST['image'] = date("dmYHis")."_".$_FILES['arquivo2']["name"];
								$retornoArquivo = $oferta->inserirOfertaImage($_POST);
							}
						}	
				}
				
				$ObjCidades->excluirPechinchaCidade("id_oferta",$oferta->anti_injection($_POST['id']));
				foreach ($_POST['id_cidade_oferta'] as $DadosCidades){
						$cidadeOferta['id_cidade'] = $DadosCidades;
						$cidadeOferta['id_oferta'] = $oferta->anti_injection($_POST['id']);

						$ObjCidades->inserirEdegracaCidade($cidadeOferta);
				}
				
				if($retorno){
					$_SESSION['alert'] = "Editada com sucesso!";			
				}else{
					$_SESSION['alert'] = "Problemas na edi��o";
				}
				
				if($_SESSION['comercial']){
					//header("Location: ../../comercial/index.php?p=ofertaGrid");
					echo'<script language="JavaScript" type="text/javascript">
  							window.location = "../../comercial/index.php?p=ofertaGrid";
						</script>';
				}else{
					//header("Location: ../index.php?pac=".$pacote."&tela=".$tela."Grid");
					echo'<script language="JavaScript" type="text/javascript">
  							window.location = "../index.php?pac='.$pacote.'&tela='.$tela.'Grid";
						</script>';
				}
				
				exit;
			break;
			
			case 'Deletar':				
				$oferta =  new Oferta();
				$ObjCidades = new CidadesOferta();
				$oferta->conectar();
				if(!empty($_POST['id'])){
					foreach ($_POST['id'] as $id){						
						$retorno = $oferta->excluirOferta($oferta->anti_injection($id),'id');
						if($retorno){
							$ObjCidades->excluirPechinchaCidade("id_oferta",$oferta->anti_injection($id));
						}
						$retorno2 = $oferta->excluirOfertaImagem($oferta->anti_injection($id),'id_oferta');
					}								
				}
				if($retorno){
					$_SESSION['alert'] = "Oferta excluida com sucesso!";			
				}else{
					$_SESSION['alert'] = "Problemas na exclus�o";
				}
				//header("Location: ../index.php?pac=$pacote&tela=".$tela."Grid");
				echo'<script language="JavaScript" type="text/javascript">
  							window.location = "../index.php?pac='.$pacote.'&tela='.$tela.'Grid";
						</script>';
				exit;
			break;
			
			case 'desativar':
				
				$oferta =  new Oferta();
				foreach ($_POST['id'] as $id){
					$ofertaresp = $oferta->getOferta2($oferta->anti_injection($id),'id');
					if($ofertaresp['ativa'] == "1"){
						$POST['ativa'] = "0";
					}else if($ofertaresp['ativa'] == "0"){
						$POST['ativa'] = "1";
					}else if($ofertaresp['ativa'] == "2"){
						$POST['ativa'] = "1";
					}
					
					$retorno = $oferta->editarOferta($POST,$oferta->anti_injection($id));
				}
				if($retorno){
					$_SESSION['alert'] = "Oferta ".$texto." com sucesso!";			
				}else{
					$_SESSION['alert'] = "Problemas na opera��o";
				}
				//header("Location: ../index.php?pac=$pacote&tela=".$tela."Grid");
				echo'<script language="JavaScript" type="text/javascript">
  							window.location = "../index.php?pac='.$pacote.'&tela='.$tela.'Grid";
						</script>';
				exit;
			break;
		}//fim cliente
}
?>