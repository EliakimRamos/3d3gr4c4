<?php
	
require_once("../../models/Base.php");
require_once("../../models/Paginacao.php");
require_once("../../models/Login.php");
require_once("../../models/Oferta.php");
require_once("../../models/OfertaCliente.php");
require_once("../../models/Funcoes.php");
require_once("../../models/Empresa.php"); 
require_once("../../models/Cliente.php"); 

$login = new Login();
$oferta = new Oferta();
$cliente = new Cliente();
$ofertaCliente = new OfertaCliente();
$fucoes = new Funcoes();
$empresa = new Empresa();

$dadosOfClie = $ofertaCliente->listarOfertaCliente3(" and id_oferta = ".$cliente->anti_injection($_POST['id_oferta'])." and ativo in (1,2) and id_cliente > 0 and comprou = 1");


?>

  <table>
    <tr>
      <th>Nome no cupom</th><th>cupom</th><th>Cliente</th><th>Origem</th>
    </tr>
  <?php $promocao = 0;
  		$pagSeguro = 0;
  		foreach($dadosOfClie as $dadosOfertaCliente){
  	?>
    <tr>
      <td><?php echo utf8_encode($dadosOfertaCliente['nome']); ?> </td>
      <td><?php echo $dadosOfertaCliente['voucher'] ?> </td>
      <td>
      		<?php 
      			 $dadosClie = $cliente->getCliente($dadosOfertaCliente['id_cliente'],"id");
      			echo utf8_encode($dadosClie["nome"]);
      		?> 
      </td>
      <td>
      		<?php 
      				$dadospagseguro = $oferta->listarOfertaPagSeguro(" and ProdID like '".$dadosOfertaCliente['id_oferta']." ".$dadosOfertaCliente['id_cliente']."%'");
      				if(!empty ($dadospagseguro[0]["ProdID"])){
      					echo "PagSeguro";
      					$pagSeguro++;
      				} else{
      					echo "<span style='color:red'>Promocao</span>";
      					$promocao++;
      				}
      		?> 
      </td>
      
    </tr>
  <?php } ?>
  </table>
  <div>
  		 <?php echo utf8_encode("promoção: "). $promocao;?><br/>
  		PagSeguro : <?php echo $pagSeguro;?>
  </div>
  