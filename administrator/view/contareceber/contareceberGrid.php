<?php
session_start();

require_once ("models/Base.php");
require_once ("models/Paginacao.php");
require_once ("models/Contareceber.php");
require_once ('models/Login.php');
require_once ('models/Cliente.php');

$login = new Login();
$confirmacao = $login->verificar();
if ($confirmacao == false) {
?>
		<script language="JavaScript" type="text/javascript">
  			window.location="./entrar.php";
		</script>
 <?php


}
$contareceber = new Contareceber();
$cliente = new Cliente();

$filtro = "";

if (empty ($_GET['inicial']) && empty ($_GET['final']) && $_GET['id_formapg'] == "" && $_GET['id_situacao'] == "") {
	$filtro .= " and month(c.vencimento) = month(now()) ";
}

if (($_GET["inicial"] != "") and ($_GET["final"] != "")) {
	$filtro = $filtro . " and c.vencimento between '" . $contareceber->date_transform($_GET['inicial']) . "' and '" . $contareceber->date_transform($_GET['final']) . "'";
}
if ($_GET[id_situacao] != "") {
	$filtro = $filtro . " and c.id_situacao=" . $_GET[id_situacao] ;
}
if ($_GET[id_formapg] != "") {
	$filtro = $filtro . " and id_formapg=" . $_GET[id_formapg] . " ";
}
$qtd = 20;

$resposta = $contareceber->listarContareceber($filtro, $qtd);
$contarecebe = $resposta['contareceber'];
$paginacao = $resposta['paginacao'];

$consultacliente = MYSQL_QUERY("SELECT id_cliente,nome from cliente order by nome asc");
echo mysql_error();

$consultaformapg = MYSQL_QUERY("SELECT * from formapg order by descricao asc");
echo mysql_error();

$consultasituacao = MYSQL_QUERY("SELECT * from situacao order by descricao asc");
echo mysql_error();

?>

<script language="JavaScript" type="text/javascript">
  $(function (){
  	 $("#botaoInserir").click(function(){
  	 	window.location="?pac=contareceber&tela=contareceberForm&op=Inserir";
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
  	 				$("#formContareceber").submit();
  	 			}
  	 		}else{
  	 			alert("Selecione um registro para ser excluido");
  	 		}  	 	
  	 }); 
  	 
  	 $("#botaoImprimir").click(function (){
  	 	window.open("view/contareceber/imprimir_receber.php?inicial=<?php echo $_GET['inicial']?>&final=<?php echo $_GET['final']?>&id_formapg=<?php echo $_GET['id_formapg']?>&id_situacao=<?php echo $_GET['id_situacao']?>&id_filial=<?php echo $_GET['id_filial']?>","_blank","toolbar=yes, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, copyhistory=yes, width=1200, height=950");
  	 });
  	$("#filtrocliente").keyup(function(){
  	 	$.post("view/contareceber/busca_cliente.php",{nomecliente:$("#filtrocliente").val()}, 
  	 		function(data){
  	 			$("#consulta_Cliente").html(data);
  	 	})
  	 });
  });
</script>
   
<div class="titulo">Contas a Receber</div><br>
<div class="corpo">
<div id="filtros">
  <table  border="0" cellpadding="0" cellspacing="5" align="center">
<form action="index.php?pac=contareceber&tela=contareceberGrid" name="filtros" method="get"> 
<input type="hidden" name="tela" value="contareceberGrid" />
<input type="hidden" name="pac" value="contareceber" />
  
   
    <tr>
      <td><span class="label">Digite nome do cliente:&nbsp;</span></td> 
	  <td><input type="text" name="filtro_cliente" id="filtrocliente" value="" /></td>	 	
      <td><span class="label">Data inicial:</span></td>
      <td><input type="text" name="inicial" readonly id="datepicker" class="inputsize" value="" style="width:50px;"/></td>
      <td><span class="label">Data final:</span></td>
      <td><input type="text" name="final" readonly id="datepicker1" class="inputsize" value="" style="width:50px;"/></td>
      <td><span class="label">Pagamento:</span></td>
      <td><select class="selectsize" name="id_formapg" id="formapg" style="width:100px;">
        <option value="">Selecione</option>
        <?php while($dados=MYSQL_FETCH_ASSOC($consultaformapg)){?>
        <option value="<?php echo $dados['id_formapg']?>"<?php if ($dados['id_formapg']==$resposta['id_formapg']){ echo 'selected=selected';}?>><?php echo $dados['descricao']?></option>
        <?php  } ?>
      </select></td>
      <td><span class="label">Situa&ccedil;&atilde;o:</span></td>
      <td><select class="selectsize" name="id_situacao" id="situacao" style="width:80px;">
        <option value="">Selecione</option>
        <?php while($dados=MYSQL_FETCH_ASSOC($consultasituacao)){?>
        <option value="<?php echo $dados['id_situacao']?>"<?php if ($dados['id_situacao']==$resposta['id_situacao']){ echo 'selected=selected';}?>><?php echo $dados['descricao']?></option>
        <?php } ?>
      </select></td>
      <td><input name="submit" type="submit" value="Pesquisar"></td>
    </tr>
    </form> 
  </table>
</div>
<div id="botoes">
    <a class="dcontexto"><div id="botaoInserir"><span>Inserir</span></div></a>
    <a class="dcontexto"><div id="botaoExcluir"><span>Excluir</span></div></a>
    <a class="dcontexto"><div id="botaoImprimir"><span>Imprimir</span></div></a>
</div>
<span style="color:red; margin-top:19px;"><?php if($_SESSION['alert'] != ""){echo $_SESSION['alert']; $_SESSION['alert'] = "";}?></span>
 <div id="consulta_Cliente"> 
  <table class="table">
<form action="controllers/contareceber/contareceber.php" method="post" id="formContareceber" >
  <input type="hidden" name="op" value="Deletar"/>
  <input type="hidden" name="tela" value="contareceber" />
  <input type="hidden" name="pacote" value="contareceber" />

    <tr class="column1_titulo">
      <th>
  			<input type="checkbox" name="selecionatodos"  id="selecionatodos"  />
  	  </th>
  		
  		<th>N&deg; documento</th>	
 		 <th>Cliente</th>
 		 <th>Vencimento</th>
 		 <!--<th>Parcela</th> -->
 		 <th>Forma de Pagamento</th> 		 
 		 <th>Situa&ccedil;&atilde;o</th>
 		 <!--<th>Valor Parcela</th> -->
 		 <th>Valor total Cobrado</th>
 		 <th><?php echo "A&ccedil;&atilde;o";?></th>
    </tr>
    <?php


if ($contarecebe == "") {
	echo "Neste mês não existe Contas a Receber";
	exit;
}
?>	
 <?php


$total = 0;
foreach ($contarecebe as $dados) {
	
?>
    <tr>
      <td>
  			<input type="checkbox" name="id[]" class="checkbox" value="<?php echo $dados['id_contareceber'];?>"/>
  
 	 </td>
	      <td><?php echo $dados['numdoc'];?></td>
	      <td><?php  $respcliente = $cliente->getCliente($dados['id_cliente'],'id_cliente'); echo $respcliente['nome']?></td>
	      <?php

	if (empty ($dados['vencimentoC']) || $dados['vencimentoC'] == "0000-00-00" || !empty ($dados['vencimentP'])) {
		$data_vencimento = $contareceber->date_transform($dados['vencimentP']);
	} else
		if ( !empty ($dados['vencimentoC'])) {
			$data_vencimento = $contareceber->date_transform($dados['vencimentoC']);
		} else {
			$data_vencimento = "Error na data";
		}
?>
		<td><?php echo $data_vencimento;?></td>
		<!--<td><?php echo $dados['numParcela']."/".$dados['qtd_parcela'];?></td> -->
	      <td><?php $respformapg = $contareceber->getFormapg($dados['id_formapg'],'id_formapg'); echo $respformapg['descricao'];?></td>
	      <?php if(empty($dados['statusC'])){
				$status = "0000-00-00";
			  }else {
			  	$status = $dados['statusC'];
			  }?>
	      <td>
	      	<?php $respsituacao = $contareceber->getSituacao($dados['id_situacao'],'id_situacao'); 
	      			echo $respsituacao['descricao'];
	      	?>
	      </td>
	      <?php  	$valorParcela = $dados['valorparcela']; ?>
	     <!-- <td>R$ <?php echo number_format($valorParcela,2,',','.');?>-->
	      <?php  	$valor = $dados['valorareceber']; ?>
	      <td>R$ <?php echo number_format($valor,2,',','.');?>
          <?php $total=$total+$valor;?>
          </td>
          <td>  			
  			<a href="?pac=contareceber&tela=contareceberForm&op=Editar&i=<?php echo $dados['id_contareceber'];?>" id="edit">
  				<img title="Editar" src="img/editar.png" width="31" height="35" border="0">
  			</a> 
  		  </td>
   </tr>
<?php }?>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td height="35"><b>Total:</b></td>
      <td>R$ <?php echo number_format($total,2,',','.');?></td>
      <td>&nbsp;</td>
      
    </tr>
</form>
  </table>
      	<div id="paginacao">
  	<div style="float:left">Resultado de 
  	<?php


	if ($paginacao->TotalDeElementos == '0') {
		echo '0';
	} else {
		if ($paginacao->Inicial == 0) {
			echo '1';
		} else {
			echo $paginacao->Inicial;
		}
	}
?> a 
  	<?php


	if (($paginacao->Inicial + $paginacao->NumeroRegistroPagina) > $paginacao->TotalDeElementos) {
		echo $paginacao->TotalDeElementos;
	} else {
		echo ($paginacao->Inicial + $paginacao->NumeroRegistroPagina);
	}
?> de 
  	<?php echo $paginacao->TotalDeElementos;?>
  	 registros.</div>
  	 <div style="float:right">Página: <?php echo $paginacao->MontarPaginacao($paginacao->PaginaAtual, $paginacao->UltimaPagina) ?></div>
  	 </div>
  	 </div>
</div>
