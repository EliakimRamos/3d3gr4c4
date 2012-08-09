<?php session_start();

require ("../sis/models/Oferta.php");
require ("../sis/models/Funcoes.php");
require ("../sis/models/Cliente.php");
require ("../sis/models/OfertaCliente.php");

$objOferta = new Oferta();
$objFuncao = new Funcoes();
$objCliente = new Cliente();
$pechinchas = new OfertaCliente();

$id = $_GET['id'];
$resultado = $pechinchas->listarOfertaCliente2("and id_oferta=".$id." and ativo = 1");
$oferta = $objOferta->getOferta($id, "id");

$total = count($resultado);
?>

<html>
<head>
<script type="text/javascript"	src="../js/jquery-1.4.2.min.js" charset="iso-8859-1"></script>
<script language="JavaScript" type="text/javascript">
	 function confirmar(id){
		if(confirm("Deseja Confirmar a Venda?")){
		 	$.post("confirmar.php",{ id:id })	 		
			setTimeout("location.reload(true)", 1000);
		}
	 }
	 
	 $(function(){
		 	$("#pesquisavoucher").keyup(function(){
		  	 	$.post("buscavoucher.php",{voucher:$("#pesquisavoucher").val(),id:<?php echo $id;?>}, 
		  	 		function(data){
		  	 			$("#consultavoucher").html(data);
		  	 	})
	  	 	});
	 })
</script>

	<title>
		Listagem das ofertas
	</title>
	
<style type="text/css">
.ok { bacground: #ccc; color:#5DA7D8;}
.usou { bacground: #9A1616; color:#9A1616;}
</style>
</head>
<body>
<table  border="0" cellpadding="0" cellspacing="0" align="center">
	<tr>
		<td>
			<form action="index.php?p=listarclientes&id="<?php echo $id; ?> name="filtros" method="get">   
	     		<span class="label">N&ordm; do Cupom: &nbsp;</span> 
  				<input type="text" name="voucher" id="pesquisavoucher" value="" />	
     		</form>
     	</td>
     </tr> 
</table>
<div id="consultavoucher">
<table class="table">
     <?php 
     if($resultado){?>
	     <tr class="column1_titulo">
	          <th>Cliente </th>
	          <th>Voucher</th>
	          <th>Ação</th>
	     </tr>
     <?php foreach ($resultado as $dados) {?>
	     <tr <?php if($dados['ativo'] == 1){
	     	 echo "class='ok'";
	     }else{
	     	echo "class='usou'";
	     }
	     	?>	     
	     >
	          <td><?php echo ucwords(strtolower($dados['nome']));?></td>
	          <td><?php echo $dados['voucher']?></td>
	          <td>	          
	          	<?php if($dados['ativo'] == 1){?>
	          		<a href=javascript:confirmar(<?php echo $dados['id']?>)>
	          			<img src="../sis/img/aberto.gif" alt="Confirmar Venda" title="Confirmar Venda" border="0">
	          		</a>
	          	<?php }?>
	          </td>
	     </tr>
      <?php } ?>
     		<tr>
	         	<td colspan="4">Total de Clientes: <?php echo $total?></td>
     		</tr>
     	<?php }else{?>
     		<tr>
	         	<td colspan="4">Não existe nenhum Cliente nesta promoção.</td>
     		</tr>     	
     	<?php }?>
</table>
</div>
</body>
</html>