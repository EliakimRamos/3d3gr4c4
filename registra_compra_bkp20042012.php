<?php session_start();
require_once ("administrator/models/Base.php");
require_once ("administrator/models/OfertaCliente.php");
require_once ("administrator/models/Cliente.php");
require_once ("administrator/models/Oferta.php");
//++ $_SESSION['qtdcomprak2'];

/*
************************************************************************
Copyright [2011] [PagSeguro Internet Ltda.]

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
************************************************************************
*/

require_once "source/PagSeguroLibrary/PagSeguroLibrary.php";

/**
 * Class with a main method to illustrate the usage of the domain class PagSeguroPaymentRequest
 */
class createPaymentRequest {
	
	public static function main () {
			$objOfertClient = new OfertaCliente();
			$objCliente = new Cliente();
			$objOferta = new Oferta();
			$resCliente = $objCliente->getCliente($_POST['cliente'],'id');
			$id = $objOferta->anti_injection($_POST['item_id_1']);
			$oferta = $objOferta->getOferta($id, "id");
			function sonumeros($entrada){
				//$entrada = str_replace(".", "", $entrada);
				$entrada = str_replace("-", "", $entrada);
				$entrada = str_replace("/", "", $entrada);
				//$entrada = str_replace(",", "", $entrada);
				$entrada = str_replace(" ", "", $entrada);
			
				$saida = $entrada;
				return $saida ;
			}
			
			$i = 1;
			$k = 1;
			$dados = "";
			$quantidade = $_SESSION['qtdcomprak2'];
			if($quantidade == 0){
				$quantidade = 1;
			}
			$venda['nome']="";
			foreach ($_POST['nome'] as $dados) {
						
					if(count($_POST['nome']) == $quantidade){						
						$nome .= $venda['nome'];
						$venda['id_oferta'] = $oferta['id'];
						$venda['id_cliente'] = $_POST['cliente'];
						$venda['voucher'] = substr(md5($nome.$resCliente['nome'].$resCliente['email'].$oferta['titulo'].date('d/m/Y h:i:s').$dados.$k),0,8);
						if(empty($dados)){
							$venda['nome'] = utf8_decode($resCliente['nome']);
						}else{
							$venda['nome'] = utf8_decode($dados);
						}
						$venda['ativo'] = 0;
						$venda['comprou'] = 0;
						$k++;
						
						$utimoid .= $objOfertClient->inserirOfertaCliente($venda)."k";
					}else{
						//echo"<script>history.back(-1);</script>";
					}
				
			}
					
		$securitykey = md5("edegraca compra coletiva 2012");
		if($_SESSION['key_security'] != $securitykey){
			header("location: www.edegraca.com.br");
		}
		
		// Instantiate a new payment request
		$paymentRequest = new PagSeguroPaymentRequest();
		
		// Sets the currency
		$paymentRequest->setCurrency("BRL");
		$paymentRequest->setShippingType(3);
		
		// Add an item for this payment request
		$titulo = str_replace("[span]","",utf8_decode($oferta['titulo']));
		$titulo = str_replace("[/span]","",$titulo);
		//echo number_format($oferta['valorpromocao'],2,".","");
		//number_format($oferta['valorpromocao'],2,".","")
		$valorpromocionalcomponto = str_replace(",",".",$oferta['valorpromocao']);
		$paymentRequest->addItem($oferta['id']." ".$venda['id_cliente']." ".$utimoid,substr($titulo,0,100), $quantidade,$valorpromocionalcomponto);
		
		// Add another item for this payment request
		//$paymentRequest->addItem('0002', 'Notebook rosa',  2,560.00);
		
		// Sets a reference code for this payment request, it is useful to identify this payment in future notifications.
		//$paymentRequest->setReference("REF1234");
		
		// Sets shipping information for this payment request
		/*$CODIGO_SEDEX = PagSeguroShippingType::getCodeByType('SEDEX');
		$paymentRequest->setShippingType($CODIGO_SEDEX);
		$paymentRequest->setShippingAddress('01452002',  'Av. Brig. Faria Lima',  '1384', 'apto. 114', 'Jardim Paulistano', 'S�o Paulo', 'SP', 'BRA');*/
		
		// Sets your customer information.
		
		$paymentRequest->setSender($resCliente['nome'], $resCliente['email']);
		
		$paymentRequest->setRedirectUrl("http://www.edegraca.com.br");
		
		try {
			
			/*
			* #### Crendencials ##### 
			* Substitute the parameters below with your credentials (e-mail and token)
			* You can also get your credentails from a config file. See an example:
			* $credentials = PagSeguroConfig::getAccountCredentials();
			*/			
			$credentials = new PagSeguroAccountCredentials("brunocbarros@edegraca.com.br", "CC2BD13CB16848EDB8787B3013715B87");
			
			
			// Register this payment request in PagSeguro, to obtain the payment URL for redirect your customer.
			$url = $paymentRequest->register($credentials);
			
			self::printPaymentUrl($url);
			
		} catch (PagSeguroServiceException $e) {
			die($e->getMessage());
		}
		
	}
	
	public static function printPaymentUrl($url) {
		if ($url) {
			/*echo utf8_decode("<h2>Criando requisi��o de pagamento</h2>");
			echo "<p>URL do pagamento: <strong>$url</strong></p>";
			echo "<p><a title=\"URL do pagamento\" href=\"$url\">Ir para URL do pagamento.</a></p>";*/
			echo "<script>window.location='".$url."';</script>";
		}
	}
	
}
createPaymentRequest::main();
?>