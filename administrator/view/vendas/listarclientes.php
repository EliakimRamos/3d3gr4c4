<?php session_start();
require_once ("models/Oferta.php");
require_once ("models/Funcoes.php");
require_once ("models/Cliente.php");
require_once ("models/OfertaCliente.php");

$objOferta = new Oferta();
$objFuncao = new Funcoes();
$objCliente = new Cliente();
$pechinchas = new OfertaCliente();

$id = $objCliente->anti_injection($_GET['id']);
$resultado = $pechinchas->listarOfertaCliente3("and id_oferta=".$id." and ativo > 0 ");
$oferta = $objOferta->getOferta($id, "id");

$total = count($resultado);
?>

<html>
<head>
<script type="text/javascript"	src="../js/jquery-1.4.2.min.js" charset="iso-8859-1"></script>
<script language="JavaScript" type="text/javascript">
	 $(function(){
		 	$("#botaoImprimir").css("cursor","pointer");
		 	$("#pesquisavoucher").keyup(function(){
		  	 	$.post("view/vendas/buscavoucher.php",{voucher:$("#pesquisavoucher").val(),id:<?php echo $id;?>}, 
		  	 		function(data){
		  	 			$("#consultavoucher").html(data);
		  	 	})
	  	 	});
	  	 	
	  	 	$("#botaoImprimir").click(function(){
	  	 		window.open("view/vendas/imprelacaovouche.php?id=<?php echo $_GET['id']?>","_blank","toolbar=yes, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, copyhistory=yes, width=1200, height=950");
  	 		});
	  	 	
	 })
</script>

	<title>
		Listagem das ofertas
	</title>
	
<style type="text/css">
.ok { color:#000;}
.usou { background-color:#F00; color: #fff;}
</style>
</head>
<body>
<h3 class="titulo">Listagem de clientes aprovados</h3>
<table  border="0" cellpadding="0" cellspacing="0" align="center">
	<tr>
		<td>
			<form action="index.php?p=listarclientes&id="<?php echo $id; ?> name="filtros" method="get">   
	     		<span class="label">N&ordm; do Cupom: &nbsp;</span> 
  				<input type="text" name="voucher" id="pesquisavoucher" value="" />	
     		</form>
     	</td>
		<td>
			<img src="../sis/img/imprimir.png" alt="Imprimir Cupom" name="botaoImprimir" border="0" id="botaoImprimir" title="Imprimir Voucher">
     	</td>
     </tr> 
</table>
<div id="consultavoucher">
<table width="100%" class="table">
	<tr class="column1_titulo">
		<th colspan="3">
		 	<strong> Oferta: </strong><?php echo $oferta['titulo']?>
		</th>
	</tr>
     <?php 
     if($resultado){?>
	     <tr class="column1_titulo">
	          <th><font size="2" face="arial">Cliente</font></th>
	          <th><font size="2" face="arial">Cupom</font></th>
	          <th><font size="2" face="arial">Ação</font></th>
	     </tr>
     <?php foreach ($resultado as $dados) {?>
	     <tr>
	          <td><font size="2" face="arial"><?php echo ucwords(mb_strtolower($dados['nome']));?></font></td>
	          <td><font size="2" face="arial"><?php echo $dados['voucher']?></font></td>
	          <td>	          
	          	<?php if($dados['ativo'] == 1){?>
	          		Ativo
	          	<?php }
	          		 if($dados['ativo'] == 2){?>
	          		<font size="2" face="arial"><?php echo $objOferta->date_transform($dados['data'])?></font>
	          	<?php }?>
	          </td>
	     </tr>
      <?php } ?>
     		<tr>
	         	<td colspan="4"><font size="2" face="arial">Total de Clientes: <?php echo $total?></font></td>
     		</tr>
     	<?php }else{?>
     		<tr>
	         	<td colspan="4"><font size="2" face="arial">Não existe nenhum Cliente nesta promoção.</font></td>
     		</tr>     	
     	<?php }?>
</table>
</div>
</body>
</html>