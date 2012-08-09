<?php session_start();
require_once("../sis/models/Base.php");
require_once("../sis/models/Oferta.php");
require_once("../sis/models/Funcoes.php");

$objOferta = new Oferta();
$objFuncao = new Funcoes();

$objOferta->conectar();
$id = $objOferta->anti_injection($_SESSION['id']);
$buscarofertas = $objOferta->listarOferta2("");
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd"> 
<html>  
	<head> 
		<meta http-equiv="content-type" content="text/html; charset=utf-8" /> 
		
		<title>Listagem das Empresas</title>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/jquery-ui.min.js"></script>
		<script type="text/javascript" src="../js/preloader/Preloader.js"></script>

		<style type="text/css">

			#container {
				display: none;			
			}
		</style>
			
		<script type="text/javascript">
			$.Preloader(
				{
					barColor     : "#fff",
					overlayColor : "#000",
					barHeight    : "10px",
					siteHolder   : "#container"	
				}
			);
		</script>
		
		<link rel="stylesheet" type="text/css" media="all"	href="../js/tabela/jquery-ui-1.8.4.custom.css" />
		<link rel="stylesheet" type="text/css" media="all"	href="../js/tabela/page.css" />
		<link rel="stylesheet" type="text/css" media="all"	href="../js/tabela/table_jui.css" />
	
		<script type="text/javascript" language="javascript" src="../js/tabela/jquery.dataTables.min.js"></script> 
		<script type="text/javascript" charset="utf-8"> 			
			$(document).ready(function() {
				oTable = $('#example').dataTable({
					"bJQueryUI": true,
					"sPaginationType": "full_numbers"
				});
			} );			
</script>
</head>
<body>
<div class="titulo">Listagem das Ofertas</div>
<div class="corpo">
		<table cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="100%">
    		<thead>
				<tr>		
					<th>Oferta</th>
 		            <td class="topoTabela">Data</td>
			        <td class="topoTabela">Valor</td>
					<td class="topoTabela">Ação</td>
				</tr>
			</thead>
			<tbody>
     		<?php 
     			if($buscarofertas){
     				foreach ($buscarofertas as $dados) { ?>
			     <tr>
			          <td><?php echo $dados['titulo']?></td>
			          <td><?php echo $objFuncao->formata_data_BR($dados['data_inicio'])?></td>
			          <td><?php echo "R$ ".$dados['valorpromocao']?></td>
			          <td>
			          		<a href="?pac=vendas&tela=listarclientes&id=<?php echo $dados['id']?>">
			          			<img src="img/lupa.png" alt="Visualizar Clientes" width="16" height="16" border="0" title="Visualizar Cliente">
			          		</a>
			          </td>
			     </tr>
     		<?php } }?>
     		</tbody>     		
		</table>
</div>
</body>
</html>