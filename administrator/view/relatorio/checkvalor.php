<?php
require_once('models/Base.php');
require_once('models/Oferta.php');

$oferta = new Oferta();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd"> 
<html>  
	<head> 
		<meta http-equiv="content-type" content="text/html; charset=utf-8" /> 
		
		<title>Listagem das Empresas</title>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/jquery-ui.min.js"></script>
		

		<style type="text/css">

			#container {
				display: none;			
			}
		</style>		
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
<div class="titulo">Relat�rio Fraude</div>
<div class="corpo">
		<table cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="100%">
    		<thead>
				<tr>		
					<th>Oferta</th>
					<td class="topoTabela">Valor da Promo��o</td>				
					<td class="topoTabela">Valor da Fraude</td>		
					<th>Nome do Fraudador</th>
					<th>Id Fraudador</th>
					<td class="topoTabela">Id Transa��es</td>	
				</tr>
			</thead>
			<tbody>
				<?php
					$dadosofertapag = $oferta->listarOfertaPagSeguro("");
					foreach($dadosofertapag as $dadospg){
						$idoferta = explode(" ",$dadospg['items_id']);
						
						$dadosOferta = $oferta->getOferta2($idoferta[0],"id");
						
						if(str_replace(",",".",$dadosOferta['valorpromocao']) != str_replace(",",".",$dadospg['grossAmount'])){
							?>
							<tr>
								<td> <?php echo $dadosOferta['items'];?></td>
								<td> <?php echo $dadosOferta['valorpromocao'];?></td>
								<td> <?php echo $dadospg['grossAmount'];?></td>
								<td> <?php echo $dadospg['sender'];?></td>
								<td> <?php echo $idoferta[1];?></td>
								<td> <?php echo $dadospg['code'];?></td>
							</tr>
						<?php } } ?>
			</tbody>
	</table>
</div>
</body>
</html>