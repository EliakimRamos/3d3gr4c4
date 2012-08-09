<?php
session_start();

if (!empty ($_GET['tela'])) {
	require_once ("models/Base.php");
	require_once ("models/Administrador.php");
	require_once ("models/Login.php");
	require_once ("models/Oferta.php");
	require_once ("models/Empresa.php");
	require_once ("models/Funcoes.php");
	require_once ("models/CidadesOferta.php");	
} else {
	require_once ("../../models/Base.php");
	require_once ("../../models/Administrador.php");
	require_once ("../../models/Login.php");
	require_once ("../../models/Oferta.php");
	require_once ("../../models/Empresa.php");
	require_once ("../../models/Funcoes.php");
	require_once ("../../models/CidadesOferta.php");
	$_GET['op'] = "Inserir";
}

$login = new Login();
$confirmacao = $login->verificar();
if($confirmacao == false){
	header("location:../../entrar.php");	
}

$oferta = new Oferta();
$funcao = new Funcoes();
$empresa = new Empresa();
$empresa->conectar();

$lista_empresa = $empresa->listarEmpresa("");
$cidades = mysql_query("SELECT * FROM cidade_oferta order by descricao");
$categorias = mysql_query("SELECT * FROM categoria order by categoria");
$id = $oferta->anti_injection($_GET['i']);
$resposta = $oferta->getOferta2($id, "id");
?>
<script>
$(function(){ 
	$(".datepicker").datepicker({
		 showButtonPanel: true
		  });
	$("#valor").maskMoney({symbol:"R$",decimal:",",thousands:"."}); 
	$("#valorpromocao").maskMoney({symbol:"R$",decimal:",",thousands:"."}); 
		
		$("#valor").focusin(function(){
			$("#desconto").val("");
			$("#valordesconto").val("");
			$("#valorpromocao").val("");
		});

		$("#desconto").focusin(function(){
			$("#valor").val($("#valor").val().replace("R$",""));
			$("#valor").val($("#valor").val().replace(" ",""));
			$("#desconto").val("");
			$("#valordesconto").val("");
			$("#valorpromocao").val("");
		});	
	});	

$(document).ready(function(){ 
	var temp =0;
	//$("#desconto").attr("disabled","disabled");
	   $("#formOferta").validate({
	      rules: {
		    id_cidade_oferta : {required: true},
		    titulo: {required: true},
		   	id_empresa: {required: true},
		   	id_categoria: {required: true},
		   	posicao: {required: true},
			valor : {required: true},
			desconto : {required: true},
			valorpromocao : {required: true},
			valordesconto : {required: true},
			qtd_minima : {required: true},
			qtd_maxima : {required: true},			
			limite : {required: true},
			regras : {required: true},
			lucro : {required: true},
			descricao : {required: true} 	
	      },
	      messages: {
		     id_cidade_oferta: {required: 'Campo Obrigatório'},
		     titulo: {required: 'Campo Obrigatório'},
		     id_empresa: {required: 'Campo Obrigatório'},
		     id_categoria: {required: 'Campo Obrigatório'},
		     posicao: {required: 'Campo Obrigatório'},
		     valor: {required: 'Campo Obrigatório'},
		     desconto: {required: 'Campo Obrigatório'},	         
		     valorpromocao: {required: 'Campo Obrigatório'},
	         valordesconto: {required: 'Campo Obrigatório'},
	         qtd_minima: {required: 'Campo Obrigatório'},
	         qtd_maxima: {required: 'Campo Obrigatório'},	         	         
	         limite: {required: 'Campo Obrigatório'},
	         regras: {required: 'Campo Obrigatório'},
	         lucro: {required: 'Campo Obrigatório'},
	         descricao: {required: 'Campo Obrigatório'}
	      }
	      ,submitHandler:function(form) {
	    	  form.submit();		      
	      }
	   });

	   
	   $("#valor").blur(function(){			
			$("#desconto").removeAttr('disabled');
	   });
		
	   $("#desconto").blur(function(){
		   valor = $("#valor").val();
		   //valor = valor.replace(".",".");
		   valor = valor.replace(",",".");
		   desconto =  $("#desconto").val();
		   $("#desconto").val(desconto.replace(",","."));
		   valor = valor.replace("R$","");
		   valor = parseFloat(valor);
		   
		   temp = (valor / 100 ) * $("#desconto").val() ;
		   temp = Math.round(temp*100)/100 ;
		   		   
		   valorpromocao = parseFloat(valor) - parseFloat(temp);
		   valorpromocao = Math.round(valorpromocao*100)/100 ;
		   
		   /* inserir os R$*/
		   $("#valor").val("R$ "+ $("#valor").val());
		   $("#desconto").val($("#desconto").val() + " %");
		   $("#valorpromocao").val("R$ "+ valorpromocao);		   
		   $("#valordesconto").val("R$ "+ temp);
		});
	   $("#valorpromocao").blur(function(){
		   
		   valor = $("#valor").val();
		   valor = valor.replace(",",".");
		   valorpromocao = $("#valorpromocao").val();
		   valorpromocao = valorpromocao.replace(",",".");
		  valordesconto = (valor - valorpromocao)
		   valorpromocao = (valorpromocao * 100);
		   
		   desconto = (100 - (valorpromocao / valor));
		   
		   $("#desconto").val(desconto + " %");
		   $("#valordesconto").val("R$ "+ valordesconto);
		   		   
		});
	   
		   $("#uploadify").uploadify({
			'uploader'       : 'js/uploadify.swf',
			'script'         : 'js/uploadify.php',
			'cancelImg'      : 'img/cancel.png',
			'folder'         : 'uploads',
			'queueID'        : 'fileQueue',
			'fileExt'		 : '*.jpg;',
			'fileDesc'		 :'*.jpg;',
			'auto'           : true,
			'multi'          : true
		});
	   
	});
	
	
</script>
<link href="style/default.css" rel="stylesheet" type="text/css" />
<link href="style/uploadify.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/swfobject.js"></script>
<script type="text/javascript" src="js/jquery.uploadify.v2.1.0.min.js"></script>

<h3 class="titulo">Copiar Oferta</h3>
<div class="corpo"><span class="mensagem" id="mensagem"> <?php if($_SESSION['alert'] != ""){echo $_SESSION['alert']; $_SESSION['alert'] = "";}?>
</span>

<div id='buscarcep' style="display: none"></div>
<form class="form_login" id="formOferta" method="post" enctype="multipart/form-data" action="controllers/Oferta.php" >
<table align="center">
	<tr>
		<td align="right"><label class="label">Titulo:*</label></td>
		<td  align="left">
  				<input type="text" name="titulo" class="input" value="<?php echo $resposta['titulo'];?>"/>
  		</td>
  		<td>
  			<label> Posição: 
  				<select name="posicao" id="posicao" style="width: 130px;">
  					<option value="" selected="selected"> Selecione a Posição</option>
  					<option value="1" <?php if($resposta['posicao'] == 1){ echo 'selected="selected"';}?>> Posição Destaque </option>
  					<option value="2" <?php if($resposta['posicao'] == 2){ echo 'selected="selected"';}?>> Bônus 1</option>
  					<option value="3" <?php if($resposta['posicao'] == 3){ echo 'selected="selected"';}?>> Bônus 2</option>
  					<option value="4" <?php if($resposta['posicao'] == 4){ echo 'selected="selected"';}?>> Bônus 3</option>  				
  					<option value="5" <?php if($resposta['posicao'] == 5){ echo 'selected="selected"';}?>> Bônus 4</option>  				
  					<option value="6" <?php if($resposta['posicao'] == 6){ echo 'selected="selected"';}?>> Bônus 5</option>  					  				
  				</select>
  			</label>
  		</td>
    
	</tr>
	<tr>
		<td align="right">
			<input type="hidden" name="pac" value="oferta" /> 			
			<input type="hidden" name="tela" value="oferta" />			 
			<label class="label">Cidades:*</label>
		</td>
		<td align="left">
			<select name="id_cidade_oferta[]" id="id_cidade_oferta" multiple="multiple" style= "height: 150px";>
					<?php
						while ($lista_cidades = mysql_fetch_assoc($cidades)) {							
					?>
							<option value="<?php echo $lista_cidades['id']?>"
								<?php
									if(!empty($CidadesOferta)){
									 	foreach ($CidadesOferta as $CidadesSelecionadas){ 
											if ($lista_cidades['id']== $CidadesSelecionadas['id_cidade']){
												echo 'selected=selected';
											}
									 	}
									}?>
							>
							<?php echo $lista_cidades['descricao']?>							
						</option>
					<?php  } ?>
			</select>		
		</td>
		
		<td align="right"><label class="label">Empresa:*</label></td>
		<td align="left" colspan="2">
			<select name="id_empresa" id="id_empresa">
						<option value="" selected="selected">Selecione</option>
					<?php foreach($lista_empresa as $dados){?>
						<option value="<?php echo $dados['id']?>"
							<?php if ($dados['id']==$resposta['id_empresa']){ echo 'selected=selected';}?>><?php echo $dados['nome']?></option>
					<?php  } ?>
			</select>
		</td>
	</tr>

	<tr align="right">
		<td>
			<label class="label">Valor Real:*</label>
		</td>
		<td align="left">
			<input type="text" id="valor" name="valor" class="input" value="<?php echo number_format($resposta['valor'],2,",","")?>"/>
		</td>
		<td>
			<label class="label">% Desconto:*</label>
		</td>
		<td align="left" colspan="2">
			<input type="text" id="desconto" name="desconto" class="input" value="<?php echo $resposta['desconto']?>"/>
		</td>
	</tr>

	<tr align="right">
		<td>
			<label class="label">Valor Promocional:*</label>
		</td>
		<td align="left">
			<input type="text" id="valorpromocao" name="valorpromocao" class="input"  value="<?php echo $resposta['valorpromocao']?>"/>
		</td>
		<td>
			<label class="label">Valor do Desconto:*</label>
		</td>
		<td align="left" colspan="2">
			<input type="text" id="valordesconto" name="valordesconto" readonly="readonly" class="input" value="<?php echo $resposta['valordesconto']?>"/>
		</td>
	</tr>
	
	<tr align="right">
		<td>
			<label class="label">Mínimo:*</label>
		</td>
		
		<td align="left">
			<input type="text" id="qtd_minima" name="qtd_minima" class="input" value="<?php echo $resposta['qtd_minima']?>" />
		</td>
		
		<td>
			<label class="label">Máximo:*</label>
		</td>
		
		<td align="left" colspan="2">
			<input type="text" id="qtd_maxima" name="qtd_maxima" class="input" value="<?php echo $resposta['qtd_maxima']?>"/>
		</td>
	</tr>
	
	<tr align="right">
		<td><label class="label">Inicio:*</label></td>
		<td align="left">
			<input type="text" name="data_inicio" readonly="readonly"
			class="datepicker" value="<?php echo $funcao->formata_data_BR($resposta['data_inicio'])?>" style="width: 80px;" />
		</td>
		<td>
			<label class="label">Final:</label>
		</td>
		<td align="left" colspan="2">
			<input type="text" name="data_final" readonly="readonly"
			class="datepicker" value="<?php echo $funcao->formata_data_BR($resposta['data_final'])?>" style="width: 80px;" />
		</td>
	</tr>
	
	<tr align="right">
		<td><label class="label">Limite de presente:*</label></td>
		<td align="left">
			<input type="text" id="limite" name="limite" value="<?php echo $resposta['limite'] ?>"/>
		</td>	
		
		<td align="right"><label class="label">Categoria:*</label></td>
		<td align="left">
			<select name="id_categoria" id="id_categoria">
						<option value="" selected="selected">Selecione</option>
					<?php
						while ($lista_categoria = mysql_fetch_assoc($categorias)) {
					?>
						<option value="<?php echo $lista_categoria['id']?>"
							<?php if ($lista_categoria['id']==$resposta['id_categoria']){ echo 'selected=selected';}?>>
								<?php echo $lista_categoria['categoria']?>
						</option>
					<?php  } ?>
			</select>	
		</td>	
	</tr>
	<tr align="right">
		<td><label class="label">Validade do Cupom:*</label></td>
		<td align="left">
			<input type="text" name="data_validade" readonly="readonly"
			class="datepicker" value="<?php echo $funcao->formata_data_BR($resposta['data_validade'])?>" style="width: 80px;" />
		</td>
		
		<td><label class="label">Percentual Acordado:*</label></td>
		<td align="left">
			<input type="text" id="lucro" name="lucro" value="<?php echo $resposta['lucro'] ?>"/>
		</td>
	</tr>
	<tr>
		<td >
			<input type="file" name="uploadify" maxlength="2" accept="gif|jpg" id="uploadify" />
		</td>
		<td colspan="4">
			<div id="fileQueue"></div>
		</td>
	</tr>
	<tr>
		<td colspan="5">
			<div id="imagens">
					<?php

						if (!empty($respImag)) {
							foreach($respImag as $dados){
								if(file_exists("uploads/".$dados['image'])){	
							?>
									<img src="uploads/<?php echo $dados['image'] ?>" width="100px" height="100px">
									<img src="img/excluir.gif" border="0" id="excluir" title="Excluir Imagem" style="cursor:pointer" onclick="javascript:apagarfoto('<?php echo $dados['id_oferta_image']?>');" />
							
							<?php
								}
							}
						}else if($_SESSION['images']){
							?>
							<img src="uploads/<?php echo $_SESSION['images'] ?>" >
							<?php
						}
					?>
			</div>
		</td>
	</tr>
	<tr>
		<td align="left" colspan="6">
			<label class="label">Descrição:</label>
		</td>
	</tr>
	
	<tr>
		<td align="center" colspan="6">
			<textarea rows="5" cols="59" name="descricao" id="descricao"><?php echo $resposta['descricao']?></textarea>
		</td>
	</tr>
	<tr>
		<td align="left" colspan="6">
			<label class="label">Regulamento:</label>
		</td>
	</tr>
	
	<tr>
		<td align="center" colspan="6">
			<textarea rows="5" cols="59" name="regras" id="regras"><?php echo $resposta['regras']?></textarea>
		</td>
	</tr>
	
	<tr>
		<td align="center" colspan="6">
			<input type="submit" name="op" id="op" value="Inserir" />
		</td>
	</tr>
</table>
</form>
</div>
<script language="JavaScript" type="text/javascript">
  function apagarfoto(idfoto){
  	$.post("view/oferta/apagafoto.php",{idOfertaImagem:idfoto},
  			function(data){
  				$("#imagens").html(data);
  			}
  	);
  }
</script>
  