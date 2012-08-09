<?php session_start();
require_once("../administrator/models/Base.php");
require_once("../administrator/models/Oferta.php");
require_once("../administrator/models/Funcoes.php");

$objOferta = new Oferta();
$objFuncao = new Funcoes();

$objOferta->conectar();
$id = $objOferta->anti_injection($_SESSION['id']);
$buscarofertas = $objOferta->listarOferta2("and id_empresa =".$id);
?>

<h3 class="titulo"> Listagem de ofertas</h3>
<table class="table" id="listarofertas">
     <?php 
     if($buscarofertas){?>
      <tr class="column1_titulo">
	          <th>Oferta</th>
	          <th>Data </th>
	          <th>Valor</th>
	          <th>Ação</th>
  </tr>
     <?php foreach ($buscarofertas as $dados) { ?>
	     <tr>
	          <td><?php  $titulosemspan = str_replace("[span]","",$dados['titulo']);
	         			 $titulosemspan = str_replace("[/span]","",$titulosemspan);
	          			 echo $titulosemspan;
	          		?>
	          </td>
	          <td><?php echo $objFuncao->formata_data_BR($dados['data_inicio'])?></td>
	          <td><?php echo "R$ ".$dados['valorpromocao']?></td>
	          <td>
	          		<a href="?p=listarclientes&id=<?php echo $dados['id']?>">
	          			<img src="../administrator/img/lupa.png" alt="Visualizar Clientes" width="16" height="16" border="0" title="Visualizar Cliente">
	          		</a>
	          </td>
	     </tr>
     <?php }}else{?>
		Não existe nenhuma promoção
     <?php }?>
</table>