<?php session_start();

 require_once("models/Base.php");
 require_once("models/Paginacao.php");
 require_once("models/Cliente.php");
 require_once('models/Login.php');
 
 	$login = new Login();
	$confirmacao = $login->verificar();
	if($confirmacao == false){

		header("location:../../entrar.php");
	
	}

 $cliente = new Cliente();
 $filtro = "";
 $qtd = 10;
 
 $resposta = $cliente->listarClientes($filtro,$qtd);
 $clientes = $resposta['cliente'];
 $paginacao = $resposta['paginacao'];
?>
 
<script language="JavaScript" type="text/javascript">
  $(function (){
  	 $("#botaoInserir").click(function(){
  	 	window.location="?pac=cliente&tela=clienteForm&op=Inserir";
  	 });
  	 
  	 $("#selecionatodos").click(function(){
  	 		
  	 		if(this.checked == true){
  	 			$(":checkbox").attr("checked","checked");
  	 		}else{
  	 			$(":checkbox").attr("checked","");
  	 		}
  	 });
  	 
  	$("#botaoExcluir").click(function(){	 		
  	 	if($("input[type=checkbox]:checked").length != 0){
  	 			if(confirm("Deseja realmente excluir esse registro?")){
  	 				$("#formCliente").submit();  	 			
  	 			}
  	 		}else{
  	 			alert("Selecione um registro para ser excluido");
  	 		}  	 	
  	 })

  	$("#pesquisacliente").keyup(function(){
  	 	$.post("view/cliente/buscacliente.php",{nome:$("#pesquisacliente").val()}, 
  	 		function(data){
  	 			$("#consultaCliente").html(data);
  	 	})
  	 });
  });
</script>

<div class="titulo">Listagem de Clientes</div>
	<div class="corpo" >
		<div id="filtroCliente">
	  		<table  border="0" cellpadding="0" cellspacing="0" align="center">
				<tr>
					<td>
						<form action="index.php?pac=cliente&tela=clienteGrid" name="filtros" method="get">   
				     		<span class="label">Digite Nome do Cliente:</span> 
			  				<input type="text" name="cliente" id="pesquisacliente" value="" />	
			     		</form>
			     	</td>
			     </tr> 
	   		</table>
	 	</div>
		<div id="botoes">
		    <a class="dcontexto"><div id="botaoInserir" title="Inserir"><span>Inserir</span></div></a>		
		    <?php if($_SESSION['nivel'] == 1){?>
				<a class="dcontexto">
					<div id="botaoExcluir" title="Excluir"><span>Excluir</span></div>
				</a>
			<?php }?>
		</div>
<span style="color:red; margin-top:19px;"id="mensagem"><?php if($_SESSION['alert'] != ""){echo $_SESSION['alert']; $_SESSION['alert'] = "";}?></span>
 <div id="consultaCliente">
  <table class="table">

<form action="controllers/Cliente.php" method="post" id="formCliente" >
  <input type="hidden" name="op" value="Deletar"/>
  <input type="hidden" name="tela" value="cliente" />
  <input type="hidden" name="pac" value="cliente" />
    <tr class="column1_titulo">
      <th>
  			<input type="checkbox" name="selecionatodos"  id="selecionatodos"  />
  	  </th>  
 		 <th>Nome</th>
 		 <th>SMS</th>
 		 <th>Newsletter</th>
 		 <th>E-mail</th>
 		 <th>Celular</th>
		 <th>Ação</th>
    </tr>
 <?php 
 if($clientes){
 	foreach($clientes as $dados){
 		
 	?>
    <tr>
      <td>
  			<input type="checkbox" name="id[]" class="checkbox" value="<?php echo $dados['id'];?>"/>  
 	 </td>
      <td><?php echo ucwords(strtolower($dados['nome']));?></td>
	  <td><?php if($dados['receber_sms'] == 0){
	  			echo "Sim";
	  		}else{
	  			echo "Não";
 			}?>
	  </td>
	  <td><?php if($dados['receber_news'] == 0){
	  			echo "Sim";
	  		}else{
	  			echo "Não";
 			}?>
	  </td>	  
	  <td><?php echo $dados['email'];?></td>
	  <td><?php echo $dados['celular'];?></td>
	  <td>	
  			<?php if($_SESSION['nivel'] == 1){?>			
  				<a href="?pac=cliente&tela=clienteForm&op=Editar&i=<?php echo $dados['id'];?>" id="edit"><img title="Editar" src="img/editar.png" width="31" height="35" border="0"></a>
  			<?php }?> 
  	  </td>
    </tr>
   <?php }
 }
   ?>
   </form>
  </table>
 
 <div id="paginacao">
  	<div style="float:left">Resultado de 
  	<?php if($paginacao->TotalDeElementos == '0'){echo '0';}
  	else{
  		if($paginacao->Inicial == 0){echo '1';}
  		else{
  			echo $paginacao->Inicial;}}
  	?> a 
  	<?php if(($paginacao->Inicial+$paginacao->NumeroRegistroPagina) > $paginacao->TotalDeElementos){
  			echo $paginacao->TotalDeElementos;}
  		else{echo ($paginacao->Inicial+$paginacao->NumeroRegistroPagina);}
  	?> de 
  	<?php echo $paginacao->TotalDeElementos;?>
  	 registros.</div>
  	 <div style="float:right">Página: <?php echo $paginacao->MontarPaginacao($paginacao->PaginaAtual, $paginacao->UltimaPagina) ?></div>
  	 </div>
  	 </div>
</div>