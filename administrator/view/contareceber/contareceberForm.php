<?php

session_start();
require_once ("models/Base.php");
require_once ("models/Contareceber.php");
require_once ("models/Cliente.php");
require_once ("models/Login.php");
$login = new Login();
$login->conectar();
$confirmacao = $login->verificar();
if ($confirmacao == false) {
	?>
<script language="JavaScript" type="text/javascript">
  			window.location="./entrar.php";
</script>

	<?php


}
$valor1 = "";
$valor2 = "";
$id1 = "";
$id2 = "";
$qtd_parcela = "";
$contareceber = new Contareceber();
$cliente = new Cliente();
$dadoscontaReceber = $contareceber->getContareceberNumDoc("", "");

if ($_GET['op'] == 'Editar') {
	$resposta = $contareceber->getContareceber($_GET['i'], 'id_contareceber');
	$respostaCliente = $cliente->getCliente($resposta['id_cliente'], 'id_cliente');
}

$consultacliente = MYSQL_QUERY("SELECT id_cliente,nome from cliente order by nome asc");
echo mysql_error();

$consultaformapg = MYSQL_QUERY("SELECT * from formapg order by descricao asc");
echo mysql_error();

$consultasituacao = MYSQL_QUERY("SELECT * from situacao order by descricao asc");
echo mysql_error();
?>

<!-- Fim da pesquisa -->

<script language="JavaScript">

$(document).ready(function(){
         $("#valorareceber").maskMoney({symbol:"R$",decimal:",",thousands:""});
         $("#situacao").attr("disabled", "disabled");
         <?php if ($_GET['op'] == 'Editar'){ ?>
        	 $("#situacao").removeAttr("disabled");
         <?php }?>
    
	   // CONFIGURA A VALIDACAO DO FORMULARIO
	   $("#formContareceber").validate({
	      rules: {
		    descricao: {required: true},
		    cliente : {required: true},
			situacao : {required: true},
			formapg : {required: true},	   	
			datepicker1 : {required: true},   	
			valorareceber : {required: true}	   	
	      },
	      messages: {
	    	 descricao: {required: 'Campo Obrigatório'},
	    	 cliente: {required: 'Campo Obrigatório'},
	    	 situacao: {required: 'Campo Obrigatório'},
	    	 formapg: {required: 'Campo Obrigatório'},
	    	 datepicker1: {required: 'Campo Obrigatório'},		     	         
	         valorareceber: {required: 'Campo Obrigatório'}
	      }
	      ,submitHandler:function(form) {
	    	  form.submit();		      
	      }
	   });	   
	});
	
		$(function () {	    		        
		     $("#formapg").change(function (){
					if($("#formapg").val()== 1 || $("#formapg").val()== 2){
							if($("#formapg").val()== 1){										
									$.post("view/vendas/cartao.php",{
										formpg:$("#formapg").val(),
										valor : $("#valorareceber").val()										
									},
											function(data){
												$("#parcelacartao").fadeIn("slow");
												$("#parcelacartao").html(data);
											});								  	
										}									  
									  if($("#formapg").val()== 2 ){									  	
											$.post("view/vendas/cheque.php",{
											valor : $("#valorareceber").val(),
											formpg:$("#formapg").val()
										},
										function(data){
											$("#parcelacartao").fadeIn("slow");
											$("#parcelacartao").html(data);
										});
									  }
							}else{
							   $("#parcelacartao").fadeOut("slow");
							}					
					});

		     $("#op").click(function(){
					var pago = false;					
						if($("#formapg").val() == "1" || $("#formapg").val()== "2"){									
									pago = true;
									if( $("#formapg").val() == "1"  && $('input:radio[name=bandeira]:checked').length == 0){
										alert("Insira as informações do Cartão!");
										pago = false;
									}
									
									if( $("#formapg").val() == "2"  && ($("#numerocheque").val() == "" || $("#datepicke").val() == "" || $('input:radio[name=bandeira]:checked').length == 0)){
										alert("Insira as informações do Cheque!");
										pago = false;
									}
						}else{
								if($("#formapg").val() == "3" || $("#formapg").val() == "4"){	
									pago = true;									
								}
			  	 			}

						if(pago == true){
							$("#formContareceber").submit();
		  	 			}
					});
				
				$("#valorareceber").keypress(function (){
					$("#formapg").val("");
					$("#parcelacartao").fadeOut("slow");
					$("#formapg").removeAttr("disabled");
				});
				
	   //Função Autocomplete do campo cliente
	  $("#cliente").autocomplete("view/cliente/pesquisa.php" , {
		  	cacheLength:0,  
			width: 200 
		});
		
	  //Fim da Função Autocomplete do campo cliente
	  $("#cliente").blur(function(){
		  $.post("view/contareceber/clienteslista.php",{
				cliente:$("#cliente").val(),conta:"ok"
			   	},
				function(data){
					$("#resp").html(data);
				});
	  });//fim function 
	  
	});
		
	  function voltarConta(){
			window.location = "?pac=contareceber&tela=contareceberGrid";
		}  
	           		         		
</script>
<h3 class="titulo"><?php echo $_GET['op']." "."Conta a receber";?></h3>
<div class="corpo"><span class="mensagem" id="mensagem"> <?php if($_SESSION['alert'] != ""){echo $_SESSION['alert']; $_SESSION['alert'] = ""; ?><script
	type="text/javascript">window.setTimeout("voltarConta()",1500);</script><?php }?></span>
<form class="form_login" id="formContareceber" method="post" action="controllers/contareceber/contareceber.php">
<table align="center" class="tabela_form">
	<input type="hidden" name="id_contareceber"	value="<?php echo $resposta['id_contareceber'];?>" />
	<input type="hidden" name="pacote" value="<?php echo $_GET['pac'];?>" />
	<input type="hidden" name="tela" value="contareceber" />
	<input type="hidden" name="op" value="<?php echo $_GET['op']?>" />
	<tr>
		<td align="right"><label class="label">N&deg; do documento:</label></td>
		<td align="left">
			<input style="border: none" type="text" name="numdoc" id="numdoc" class="input" readonly
			value="<?php if(!empty($resposta['numdoc'])){ echo $resposta['numdoc'];}else{ echo $dadoscontaReceber['numdoc']+1;}?>" />
		</td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="left">&nbsp;</td>
	</tr>
	<tr>
		<td width="133" align="right"><label class="label">Descrição:</label></td>
		<td align="left">
			<input type="text" name="descricao" class="input" value="<?php echo $resposta['descricao']?>" />
		</td>
		<td width="20" align="right">&nbsp;</td>
		<td align="right"><label class="label">Situação:</label></td>
		<td align="left">
			<select name="id_situacao" id="situacao">
				<option value="">Selecione</option>
				<?php while($dados=MYSQL_FETCH_ASSOC($consultasituacao)){?>
				<option value="<?php echo $dados['id_situacao']?>"
						<?php if ($dados['id_situacao']==$resposta['id_situacao'] || $dados['id_situacao'] == 3){ echo 'selected=selected';}?>>
							<?php echo $dados['descricao']?>
				</option>
				<?php } ?>
			</select>
		</td>
	</tr>
	<tr>
		<td align="right"><label class="label"> Cliente:</label></td>

		<td width="141" align="left"><input type="text" id="cliente"
			class="input" value="<?php echo $respostaCliente['nome'];?>" /></td>
		<td>
		<div id='resp'><input type="hidden" name="id_cliente" id="cliente_id"
			class="input" value="<?php echo $respostaCliente['id_cliente'];?>" /></div>
		</td>
		<td align="right"><label class="label">Data do cadastro:</label></td>
		<td align="left"><input type="text" name="data_cad" readonly
			id="datepicker1" class="input"
			value="<?php echo $contareceber->date_transform($resposta['data_cad']);?>" /></td>
		<td align="right">&nbsp;</td>

	</tr>

	<tr>
		<td align="right"><label class="label">Valor cobrado:</label></td>
		<td align="left"><input type="text" name="valorareceber"
			id="valorareceber" class="input"
			value="<?php echo number_format($resposta['valorareceber'],2,',','.')?>" /></td>
		<td align="right">&nbsp;</td>
		<td align="right"><label class="label">Forma de pagamento:</label></td>
		<td align="left"><select name="id_formapg" id="formapg">
			<option value="">Selecione</option>
			<?php while($dados=MYSQL_FETCH_ASSOC($consultaformapg)){?>
			<option value="<?php echo $dados['id_formapg']?>"
			<?php if ($dados['id_formapg']==$resposta['id_formapg']){ echo  'selected=selected';}?>><?php echo $dados['descricao']?></option>
			<?php  } ?>
		</select></td>
	</tr>
	<tr>
		<td colspan="5">
		<div id="resultadoparcela"></div>
		</td>
	</tr>
	<tr id="resp_formapg">
		<td colspan="6">
		<div id="parcelacartao"></div>
		</td>
	</tr>
	<tr>
		<td align="right"><label class="label">Observa&ccedil;&atilde;o:</label></td>
		<td colspan="4" align="left"><textarea name="observacao" wrap="off"
			id="observacao" style="width: 300px; height: 100px;"><?php echo $resposta['observacao'] ;?></textarea></td>
	</tr>
	<tr>
		<td align="right">&nbsp;</td>
		<td align="left">
			<input type="button" name="op" id="op" value="<?php echo $_GET['op']?>" /> 
			<input type="button" name="voltar" id="voltar" value="Voltar" onClick="javaScript:history.back();" />
		</td>
		<td align="left">&nbsp;</td>
		<td align="left">&nbsp;</td>
		<td align="left">&nbsp;</td>
	</tr>
</table>
</form>

</div>
</body>

</html>
