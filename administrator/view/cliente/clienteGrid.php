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

  	$("#pesquisa").keyup(function(){
  	 	$.post("view/cliente/buscacliente.php",{nome:$("#pesquisacliente").val()}, 
  	 		function(data){
  	 			$("#consultaCliente").html(data);
  	 	})
  	 });
  });
</script>

<div id="main">
<h1>Listagem de Clientes</h1>
<div id="filtroCliente">
	  		
						<form action="index.php?pac=cliente&amp;tela=clienteGrid" name="filtros" method="get">   
				     		<span class="label">Digite Nome do Cliente:</span> 
			  				<input type="text" name="pesquisa" id="pesquisa" value="" class="pesquisa round5px">	
                            
                            <div id="btns-editores">
                        		<?php if($_SESSION['nivelAdmin'] == 1){?>
                        		   <div class="btn-apagar" id="botaoExcluir"></div>
                        		<?php }?>
                        		<div class="btn-inserir" id="botaoInserir"></div>
                        
                        	</div>
			     		</form>
                        
                        
                        
 </div>
 <br/>
 <br/>
 <br/>
<div id="consultaCliente">
<table width="100%" class="table">
<span style="color:red; margin-top:19px;"id="mensagem"><?php if($_SESSION['alert'] != ""){echo $_SESSION['alert']; $_SESSION['alert'] = "";}?></span>
<form action="controllers/Cliente.php" method="post" id="formCliente">
  <input type="hidden" name="op" value="Deletar">
  <input type="hidden" name="tela" value="cliente">
  <input type="hidden" name="pac" value="cliente">
    <tbody><tr class="column1_titulo">
      <th>
  			<input type="checkbox" name="selecionatodos" id="selecionatodos">
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
  			<input type="checkbox" name="id[]" class="checkbox" value="<?php echo $dados['id'];?>">  
 	 </td>
      <td><?php echo ucwords(strtolower($dados['nome']));?></td>
	  <td>
	  <?php if($dados['receber_sms'] == 0){
	  			echo "Sim";
	  		}else{
	  			echo "N&atilde;o";
 			}?>
 		</td>
	  <td>
	  <?php if($dados['receber_news'] == 0){
	  			echo "Sim";
	  		}else{
	  			echo "N&atilde;o";
 			}?>  
 	  </td>	  
	  <td><?php echo $dados['email'];?></td>
	  <td><?php echo $dados['celular'];?></td>
	  <td>	
  				<div class="btn-editar">		
  				<?php if($_SESSION['nivelAdmin'] == 1){?>			
  					<a href="?pac=cliente&tela=clienteForm&op=Editar&i=<?php echo $dados['id'];?>" id="edit"></a>
  				<?php }?> 
  			</div>
  			 
  	  </td>
    </tr>
     <?php }
 }
   ?>      
  </tbody>
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
				  	 registros.
		</div>
  	 <div style="float:right">P�gina: <?php echo $paginacao->MontarPaginacao($paginacao->PaginaAtual, $paginacao->UltimaPagina) ?></div>
  	 </div>
</div> <!-- fim div consultacliente -->
</div> <!--fim div main-->