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

  		$pagSeguro = 0;
  		$Cancelados = 0;
  
      				$dadospagseguro = $oferta->listarOfertaPagSeguro(" and ProdID like '".$cliente->anti_injection($_POST['id_oferta'])."%' ");
      				/*and StatusTransacao in ('Aprovado','Completo') */
      				foreach($dadospagseguro as $dadospag){
	      				 
	      				 if($dadospag['StatusTransacao'] == 'Aprovado' || $dadospag['StatusTransacao'] == 'Completo'){
	      				 	$pagSeguro = $pagSeguro + $dadospag['ProdQuantidade'];
      					}
      					if($dadospag['StatusTransacao'] == 'Cancelado'){
      						$Cancelados = $Cancelados + $dadospag['ProdQuantidade'];
      					}
	      				
	      			 } ?>
  
  <div>
  		Aprovados : <?php echo $pagSeguro;?>
  		Cancelados : <?php echo $Cancelados;?>
  </div>
  