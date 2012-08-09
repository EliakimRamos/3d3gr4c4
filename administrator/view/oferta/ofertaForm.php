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
	require_once ("models/Comercial.php");	
} else {
	require_once ("../../models/Base.php");
	require_once ("../../models/Administrador.php");
	require_once ("../../models/Login.php");
	require_once ("../../models/Oferta.php");
	require_once ("../../models/Empresa.php");
	require_once ("../../models/Funcoes.php");
	require_once ("../../models/CidadesOferta.php");
	require_once ("../../models/Comercial.php");
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
$objComercial = new Comercial();
$empresa->conectar();

$lista_empresa = $empresa->listarEmpresa("");
$regrasgerais = $empresa->listaregrasgerais();
$temp = $objComercial->listarComercial2();
$vendedores = $temp['comercial'];
$cidades = mysql_query("SELECT * FROM cidade_oferta order by descricao");

$categorias = mysql_query("SELECT * FROM categoria order by categoria");

if ($_GET['op'] == 'Editar') {
	$id = $oferta->anti_injection($_GET['i']);
	$resposta = $oferta->getOferta2($id, "id");
	$respImag = $oferta->listarOfertaImagem(" and id_oferta=" .$id);
	$ObjCdd = new CidadesOferta();
		
	$CidadesOferta = $ObjCdd->listarCidades(" and id_oferta=".$id);
}
if (!empty ($_POST['nome'])) {
?>
<script>
 		$(function(){
 			$("#nome").val("<?php echo $_POST['nome']?>");	
 		});
		 		
 </script>

	<?php

}
?>
<script>


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
			id_comercial: {required: true},
			valor : {required: true},
			desconto : {required: true},
			valorpromocao : {required: true},
			valordesconto : {required: true},
			qtd_minima : {required: true},
			qtd_maxima : {required: true},			
			data_inicio : {required: true},
			data_final : {required: true},
			data_final : {required: true},
			limite : {required: true},
			regras : {required: true},
			lucro : {required: true},
			descricao : {required: true} 	
	      },
	      messages: {
		     id_cidade_oferta: {required: 'Campo Obrigat�rio'},
		     titulo: {required: 'Campo Obrigat�rio'},
		     id_empresa: {required: 'Campo Obrigat�rio'},
		     id_categoria: {required: 'Campo Obrigat�rio'},
		     posicao: {required: 'Campo Obrigat�rio'},
		     id_comercial: {required: 'Campo Obrigat�rio'},
			 valor: {required: 'Campo Obrigat�rio'},
		     desconto: {required: 'Campo Obrigat�rio'},	         
		     valorpromocao: {required: 'Campo Obrigat�rio'},
	         valordesconto: {required: 'Campo Obrigat�rio'},
	         qtd_minima: {required: 'Campo Obrigat�rio'},
	         qtd_maxima: {required: 'Campo Obrigat�rio'},	         
	         data_inicio: {required: 'Campo Obrigat�rio'},
	         data_final: {required: 'Campo Obrigat�rio'},
	         limite: {required: 'Campo Obrigat�rio'},
	         regras: {required: 'Campo Obrigat�rio'},
	         lucro: {required: 'Campo Obrigat�rio'},
	         descricao: {required: 'Campo Obrigat�rio'}
	      }
	      ,submitHandler:function(form) {
	    	  form.submit();		      
	      }
	   });

	   $("#valor").click(function(){
		   $("#valorpromocao").val("");
		   $("#desconto").val("");
		   $("#valordesconto").val("");
	   });
	  
	   $("#cal_desconto").click(function(){
		   $("#valorpromocao").val("");
		   if($("#desconto").val() > 0 && $("#desconto").val() < 100 ){
			   $.post("view/oferta/CalcularValorPromocao.php",{	
				   valor : $("#valor").val(),
				   desconto :  $("#desconto").val()			   
			 	},
				 function(data){
			 		$("#valorpromocao").val("R$ "+ data);
	
			 		$.post("view/oferta/ValorDesconto.php",{	
			 			   valor_real : $("#valor").val(),
			 			   valor_promo :  $("#valorpromocao").val()			   
					 	},
						 function(data){			 		
					 		$("#valordesconto").val("R$ "+ data);
					 	});		 		
			 	});
		   }else{
				alert("Informe corretamente o valor do Desconto");
		   }
		});
	   
	   $("#cal_valor_promo").click(function(){
			   if($("#valorpromocao").val()){
				   $("#desconto").val("");
				   $.post("view/oferta/CalcularDesconto.php",{	
					   valor : $("#valor").val(),
					   valor_promo :  $("#valorpromocao").val()			   
				 	},
					 function(data){
				 		$("#desconto").val(data);
		
				 		$.post("view/oferta/ValorDesconto.php",{	
				 			   valor_real : $("#valor").val(),
				 			   valor_promo :  $("#valorpromocao").val()			   
						 	},
							 function(data){			 		
						 		$("#valordesconto").val("R$ "+ data);
						 	});		 		
				 	});
			   }else{
					alert("Informe corretamente o Valor da Promoção ");
			   }
		});
		   		   
	   
		 
	});
	
	
</script>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>É de Graça - Administrativo</title>

<link rel="stylesheet" type="text/css" href="style/edegraca-sis.css"/>

<script type="text/javascript" src="tinymce/jscripts/tiny_mce/tiny_mce.js"></script>

<script type="text/javascript" language="javascript">
tinyMCE.init({
        
        mode : "exact",
        elements : "tynemce-titulo,tynemce-descricao,tynemce-regras",
		theme : "advanced",
		plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave,visualblocks",

		// Theme options
		theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft,visualblocks",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Example content CSS (should be your site CSS)
		content_css : "css/content.css",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",

		// Style formats
		style_formats : [
			{title : 'Bold text', inline : 'strong'},
			{title : 'Marcacao text', inline : 'span', styles : {color : '#9F0'}},
			{title : 'Red header', block : 'h1', styles : {color : '#ff0000'}},
			{title : 'Example 1', inline : 'span', classes : 'example1'},
			{title : 'Example 2', inline : 'span', classes : 'example2'},
			{title : 'Table styles'},
			{title : 'Table row 1', selector : 'tr', classes : 'tablerow1'}
		],

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}

		
});

</script>

<div id="main">
<h1>Cadastrar / Editar Oferta</h1>
<span class="mensagem" id="mensagem"> <?php if($_SESSION['alert'] != ""){echo $_SESSION['alert']; $_SESSION['alert'] = "";}?></span>
<form class="form_login" id="formOferta" method="post" enctype="multipart/form-data" action="controllers/Oferta.php">
			<input type="hidden" name="id" value="<?php echo $resposta['id'];?>" /> 
			<input type="hidden" name="pac" value="oferta" /> 			
			<input type="hidden" name="tela" value="oferta" />
<table width="100%" border="0" id="tabela-inserir-oferta">
  <tr>
    <td height="0"> <legend>Título:*</legend>
    <textarea rows="3" cols="9" name="titulo" class="textarea round5px" id="tynemce-titulo"><?php echo $resposta['titulo'];?></textarea></td>
    </tr>
  <tr>
    <td height="0"><table width="100%" border="0">
      <tr>
        <td width="32%"><legend class="label">Cidades:*</legend>
          <select name="id_cidade_oferta[]" id="id_cidade_oferta" multiple="multiple" style="height: 145px" class="round5px">
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
							<?php echo utf8_encode($lista_cidades['descricao']);?>							
						</option>
					<?php  } ?>
          </select></td>
        <td width="68%"><legend> Comercial:</legend>
          <select name="id_comercial" id="id_comercial" style="width: 150px;" class="round5px">
            <option value="" selected="selected"> Selecione o Vendedor</option>
           <?php foreach ($vendedores as $info_ven){?>
  						<option value="<?php echo $info_ven['id']?>" <?php if($resposta['id_comercial'] == $info_ven['id']){ echo 'selected="selected"';}?> > 
  							<?php echo $info_ven['nome']?>
  						</option>
  				<?php }?>  		
          </select>
          
          <legend> Posição:</legend>
          <select name="posicao" id="posicao" style="width: 130px;" class="round5px">
            <option value="" selected="selected"> Selecione a Posição</option>
               		<option value="1" <?php if($resposta['posicao'] == 1){ echo 'selected="selected"';}?>> Posição Destaque </option>
  					<option value="2" <?php if($resposta['posicao'] == 2){ echo 'selected="selected"';}?>> Bónus 1</option>
  					<option value="3" <?php if($resposta['posicao'] == 3){ echo 'selected="selected"';}?>> Bónus 2</option>
  					<option value="4" <?php if($resposta['posicao'] == 4){ echo 'selected="selected"';}?>> Bónus 3</option>  				
  					<option value="5" <?php if($resposta['posicao'] == 5){ echo 'selected="selected"';}?>> Bónus 4</option>  				
  					<option value="6" <?php if($resposta['posicao'] == 6){ echo 'selected="selected"';}?>> Bónus 5</option>  					  				
  					<option value="7" <?php if($resposta['posicao'] == 7){ echo 'selected="selected"';}?>> Bónus 6</option>  					  				
  					<option value="8" <?php if($resposta['posicao'] == 8){ echo 'selected="selected"';}?>> Bónus 7</option>  					  				
  					<option value="9" <?php if($resposta['posicao'] == 9){ echo 'selected="selected"';}?>> Bónus 8</option>  					  				
  					<option value="10" <?php if($resposta['posicao'] == 10){ echo 'selected="selected"';}?>> Bónus 9</option>  					  				
  					<option value="11" <?php if($resposta['posicao'] == 11){ echo 'selected="selected"';}?>> Bónus 10</option>  					  				
  					<option value="12" <?php if($resposta['posicao'] == 12){ echo 'selected="selected"';}?>> Bónus 11</option> 
          </select>
          <br />
          
          <legend class="label">Empresa:*</legend>
          <select name="id_empresa" id="id_empresa">
            <option value="" selected="selected">Selecione</option>
            	<?php foreach($lista_empresa as $dados){?>
						<option value="<?php echo $dados['id']?>"
							<?php if ($dados['id']==$resposta['id_empresa']){ echo 'selected=selected';}?>><?php echo utf8_decode($dados['nome']);?></option>
					<?php  } ?>
          </select></td>
      </tr>
    </table></td>
    </tr>
  <tr>
    <td></td>
    </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="25%"><label>Valor Real:*</label>      <input type="text" id="valor" name="valor" class="textfield" value="<?php echo number_format($resposta['valor'],2,",","")?>" /></td>
        <td width="25%"><label>% Desconto*</label><input type="text" id="desconto" name="desconto" class="textfield" value="<?php echo $resposta['desconto']?>" />
          <img src="img/Add-icon_peq.png" id="cal_desconto" title="Calcular Valores" alt="Calcular Valores" border="0" style="cursor:pointer;" /></td>
        <td width="25%"><label>Valor Promocional</label><input type="text" id="valorpromocao" name="valorpromocao" class="textfield" value="<?php echo $resposta['valorpromocao']?>" />
          <img src="img/Add-icon_peq.png" id="cal_valor_promo" title="Calcular Valores" alt="Calcular Valores" border="0" style="cursor:pointer;" /></td>
        <td width="25%"><label class="label">Valor do Desconto:*</label>          <input type="text" id="valordesconto" name="valordesconto" readonly="readonly" class="textfield" value="<?php echo $resposta['valordesconto']?>" /></td>
      </tr>
      <tr>
        <td><label class="label">Mínimo:*</label>
          <input type="text" id="qtd_minima" name="qtd_minima" class="textfield" value="<?php echo $resposta['qtd_minima']?>" /></td>
        <td><label class="label">Máximo:*</label>
          <input type="text" id="qtd_maxima" name="qtd_maxima" class="textfield" value="<?php echo $resposta['qtd_maxima']?>" /></td>
        <td><label class="label">Início:*</label>
          <input type="text" name="data_inicio" readonly="readonly" class="textfield" id="diainicil" value="<?php echo $funcao->formata_data_BR($resposta['data_inicio'])?>" /></td>
        <td><label class="label">Final:</label>
          <input type="text" name="data_final" readonly="readonly" class="textfield" value="<?php echo $funcao->formata_data_BR($resposta['data_final'])?>"id="datafim" /></td>
      </tr>
      <tr>
        <td><label class="label">Limite de presente:*</label>
          <input name="limite" type="text" class="textfield" id="limite" value="<?php echo $resposta['limite'] ?>" /></td>
        <td><label class="label">Categoria:*</label>
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
          </select></td>
        <td><label class="label">Validade do Cupom:*</label>
          <input type="text" name="data_validade" readonly="readonly" class="textfield" value="<?php echo $funcao->formata_data_BR($resposta['data_validade'])?>" id="data_validade" /></td>
        <td><label class="label">Percentual Acordado:*</label>
          <input name="lucro" type="text" class="textfield" id="lucro" value="<?php echo $resposta['lucro'] ?>" /></td>
      </tr>
    </table></td>
    </tr>
  <tr>
    <td>
<table align="center">
      <tbody>
        <tr>
          <td><input type="file" id="arquivo" name="arquivo" value="" /></td>
          <td><input type="file" id="arquivo1" name="arquivo1" value="" /></td>
          <td><input type="file" id="arquivo2" name="arquivo2" value="" /></td>
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
      </tbody>
    </table></td>
  </tr>
  <tr>
    <td><label class="label">Palavras-Chave:</label>
      <textarea name="Palavras-Chave" cols="59" rows="1" class="textarea" id="Palavras-Chave" value="<?php echo $resposta['palavras-chave'] ?>"></textarea></td>
  </tr>
  <tr>
    <td><label class="label">Descrição:</label>
      <textarea name="descricao" cols="59" rows="15" class="textarea" id="tynemce-descricao"><?php echo $resposta['descricao']?></textarea></td>
  </tr>
  <tr>
    <td><label class="label">Regras da Promoção:</label>
      <p>
       <?php 
       	  if(!empty($regrasgerais)){ 
       			foreach($regrasgerais  as $dadosresultregrasgerais){
       ?>
				        <label>
				          <input name="Regulamento[]" type="checkbox" id="Regulamento_0" value="<?php echo $dadosresultregrasgerais->id;?>" checked="checked" />
				          <?php echo utf8_encode($dadosresultregrasgerais->regra);?>
				          </label>
         <?php 	} 
       		}
         ?>
        <!-- <label>
          <input name="Regulamento" type="checkbox" id="Regulamento_1" value="Cupom não cumulativo para outras promoções;" checked="checked" />
          </label>
        <label>
          <input name="Regulamento" type="checkbox" id="Regulamento_2" value="Deverá ser apresentado no estabelecimento o cupom IMPRESSO encontrado na “Minha Conta”. Esse estará disponível apenas após a autorização do pagamento junto ao PagSeguro. Outros comprovantes, incluindo o do PagSeguro não terão validade alguma no estabelecimento." checked="checked" />
          </label> -->
      </p>
      <textarea name="regras" cols="59" rows="15" class="textarea" id="tynemce-regras"><?php echo $resposta['regras']?></textarea></td>
  </tr>
  <tr>
    <td align="center"><input type="submit" name="op" id="op" value="<?php echo $_GET['op'];?>" /></td>
  </tr>
</table>
</form>

</div> <!--fim div main-->
<script language="JavaScript" type="text/javascript">
  function apagarfoto(idfoto){
  	$.post("view/oferta/apagafoto.php",{idOfertaImagem:idfoto},
  			function(data){
  				$("#imagens").html(data);
  			}
  	);
  }
  
  $(function(){ 
	$("#datafim").datepicker({
		 showButtonPanel: true
	});
	
	$("#diainicil").datepicker({
		 showButtonPanel: true
	});
	
	$("#data_validade").datepicker({
		 showButtonPanel: true
	});
	
		$("#valor").maskMoney({symbol:"R$",decimal:",",thousands:"."}); 
		$("#valorpromocao").maskMoney({symbol:"R$",decimal:",",thousands:"."}); 	
});	
</script>