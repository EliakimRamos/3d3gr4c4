<?php session_start();
require_once("models/Base.php");
require_once("models/Paginacao.php");
require_once("models/Contapagar.php");
require_once('models/Login.php');

$login = new Login();
$confirmacao = $login->verificar();
if($confirmacao == false){
	?>
<script language="JavaScript" type="text/javascript">
  			window.location="./entrar.php";
		</script>
	<?php
}
$contapagar = new Contapagar();
$qtd = 10;

if (empty ($contapagar->anti_injection($_GET['inicial'])) && empty ($contapagar->anti_injection($_GET['final'])) && $contapagar->anti_injection($_GET['id_formapg']) == "" && $contapagar->anti_injection($_GET['status']) == "") {
	$filtro .= " and month(vencimento) = month(now()) ";
}

if (($contapagar->anti_injection($_GET["inicial"])!="") and ($contapagar->anti_injection($_GET["final"])!="")){
	$filtro = $filtro. " and vencimento between '".$contapagar->date_transform($contapagar->anti_injection($_GET['inicial']))."' and '".$contapagar->date_transform($contapagar->anti_injection($_GET['final']))."'";
}

$resposta = $contapagar->listarContapagarpag($filtro, $qtd);
$contapg = $resposta['contapagar'];
$paginacao = $resposta['paginacao'];

?>
<script language="JavaScript" type="text/javascript">
  $(function (){
  	 $("#botaoInserir").click(function(){
  	 	window.location="?pac=contapagar&tela=contapagarForm&op=Inserir";
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
  	 				$("#formContapagar").submit();
  	 			}
  	 		}else{
  	 			alert("Selecione um registro para ser excluido");
  	 		}  	 	
  	 });
 	$("#botaoImprimir").click(function(){
 		window.open("view/contapagar/imprimir_pagar.php?inicial=<?php echo $contapagar->anti_injection($_GET['inicial'])?>&final=<?php echo $contapagar->anti_injection($_GET['final'])?>&id_formapg=<?php echo $contapagar->anti_injection($_GET['id_formapg'])?>&status=<?php echo $contapagar->anti_injection($_GET['status'])?>&id_filial=<?php echo $contapagar->anti_injection($_GET['id_filial'])?>","_blank","toolbar=yes, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, copyhistory=yes, width=1200, height=950");
 	 }); 
  });
</script>

<div class="titulo">Contas a pagar</div>
<div class="corpo">
<div id="filtros">
<table border="0" cellpadding="0" cellspacing="5" align="center">
	<form action="index.php?pac=contapagar&tela=contapagarGrid"	name="filtros" method="get">
		<input type="hidden" name="tela" value="contapagarGrid" />
		<input type="hidden" name="pac"	value="contapagar" />
	<tr>		
		<td><span class="label">Data inicial:</span></td>
		<td><input type="text" name="inicial" readonly id="datepicker"
			class="inputsize" value="" style="width: 50px;" /></td>
		<td><span class="label">Data final:</span></td>
		<td><input type="text" name="final" readonly id="datepicker1"
			class="inputsize" value="" style="width: 50px;" /></td>		
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
<span style="color: red; margin-top: 19px;"><?php if($_SESSION['alert'] != ""){echo $_SESSION['alert']; $_SESSION['alert'] = "";}?></span>
<div id="consultaBeneficiado">
<table class="table">
	<form action="controllers/contapagar.php" method="post" id="formContapagar">
		<input type="hidden" name="op" value="Deletar" />
		<input type="hidden" name="tela" value="contapagar" /> 
		<input type="hidden" name="pacote" value="contapagar" />

	<tr class="column1_titulo">
			<th><input type="checkbox" name="selecionatodos" id="selecionatodos" />
		</th>
		<th>Beneficiado</th>
		<th>Emissão</th>
		<th>Vencimento</th>
		<th>Valor</th>
		<th><?php echo "A&ccedil;&atilde;o";?></th>
	</tr>

	<?php
	$total=0;
	if($contapg){
		foreach($contapg as $dados){?>
		<tr>
			<td>
				<input type="checkbox" name="id[]" class="checkbox"	value="<?php echo $dados['id_contapagar'];?>" />
			</td>	
			<td><?php  echo $dados['beneficiado'];?></td>
			<td><?php echo $contapagar->date_transform($dados['emissao']);?></td>
			<td><?php echo $contapagar->date_transform($dados['vencimento']);?></td>		
			<td>R$ <?php $total += $dados['valor'];
					echo number_format($dados['valor'],2,',','.');?> 
			</td>
			<td>
				<a href="?pac=contapagar&tela=contapagarForm&op=Editar&i=<?php echo $dados['id_contapagar'];?>"	id="edit">
					<img title="Editar" src="img/editar.png" width="31"	height="35" border="0">
				</a>
			</td>
		</tr>
	<?php }}?>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>		
		<td>&nbsp;</td>
		<td><b>Total:</b></td>
		<td>R$&nbsp;<?php echo number_format($total,2,',','.');?></td>
		<td>&nbsp;</td>		
	</tr>

</table>
</div>
<div id="paginacao">
	<div style="float: left">
	Resultado de <?php if($paginacao->TotalDeElementos == '0'){
			echo '0';
	}else{
		if($paginacao->Inicial == 0){
			echo '1';
		}else{
			echo $paginacao->Inicial;
			}
		}
		
	?> a <?php if(($paginacao->Inicial+$paginacao->NumeroRegistroPagina) > $paginacao->TotalDeElementos){
			echo $paginacao->TotalDeElementos;
		}else{
			echo ($paginacao->Inicial+$paginacao->NumeroRegistroPagina);
		}?> de <?php echo $paginacao->TotalDeElementos;?> 
		registros.
	</div>
	<div style="float: right">
		Página: <?php echo $paginacao->MontarPaginacao($paginacao->PaginaAtual, $paginacao->UltimaPagina) ?>
	</div>
</div>
</div>