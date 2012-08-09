<?php
require_once ("administrator/models/Base.php");
require_once ("administrator/models/Oferta.php");
require_once ("administrator/models/OfertaCliente.php");

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

class NotificationListener  {

    public static function main() {
				
    	$code = (isset($_POST['notificationCode']) && trim($_POST['notificationCode']) !== ""  ? trim($_POST['notificationCode']) : null);
    	$type = (isset($_POST['notificationType']) && trim($_POST['notificationType']) !== ""  ? trim($_POST['notificationType']) : null);
    	
    	if ( $code && $type ) {
			
    		$notificationType = new PagSeguroNotificationType($type);
    		$strType = $notificationType->getTypeFromValue();
    		
			
			switch($strType) {
				
				case 'TRANSACTION':
					self::TransactionNotification($code);
					break;
				
				default:
					LogPagSeguro::error("Unknown notification type [".$notificationType->getValue()."]");
					
			}

			self::printLog($strType);
			
		} else {
			
			LogPagSeguro::error("Invalid notification parameters.");
			self::printLog();
			
		}
		
    }
    
    
    private static function TransactionNotification($notificationCode) {
		
		/*
		* #### Crendencials ##### 
		* Substitute the parameters below with your credentials (e-mail and token)
		* You can also get your credentails from a config file. See an example:
		* $credentials = PagSeguroConfig::getAccountCredentials();
		*/
    	
    	
    	$credentials = new PagSeguroAccountCredentials("brunocbarros@edegraca.com.br", "CC2BD13CB16848EDB8787B3013715B87");
		try {
    		$transaction = PagSeguroNotificationService::checkTransaction($credentials, $notificationCode);
    		$objOferta = new Oferta();
    		$objOfertClient = new OfertaCliente();	
    		
    		$retornopag['date'] = $transaction->getDate();
    		$retornopag['lastEventDate'] = $transaction->getLastEventDate();
    		$retornopag['code'] = $transaction->getCode();
    		$retornopag['reference'] = $transaction->getReference();
    		$retornopag['type'] = $transaction->getType()->getValue();
    		$status = $transaction->getStatus();
    		$retornopag['status'] = $status->getTypeFromValue();
    		$retornopag['status_code'] = $status->getValue();
    		$payment = $transaction->getPaymentMethod();
    		$codepaymet = $payment->getCode();
    		$retornopag['paymentMethod'] = $codepaymet->getTypeFromValue();
    		$retornopag['grossAmount'] = $transaction->getGrossAmount();
    		$retornopag['discountAmount'] = $transaction->getDiscountAmount();
    		$retornopag['feeAmount'] = $transaction->getFeeAmount();
    		$retornopag['netAmount'] = $transaction->getNetAmount();
    		$retornopag['extraAmount'] = $transaction->getExtraAmount();
    		$retornopag['installmentCount'] = $transaction->getInstallmentCount();
    		$itens = $transaction->getItems();
    		foreach($itens as $key=>$item){
    			$retornopag['items'] = $item->getDescription()." ".$item->getQuantity()." ".$item->getAmount();
    			$retornopag['items_id'] = $item->getId();
    			$retornopag['item_qtd'] = $item->getQuantity();
    			
    		}
    		$retornopag['sender'] = $transaction->getSender()->getName()." ".$transaction->getSender()->getEmail();
    		$retornopag['shipping'] = $transaction->getShipping()->getCost();
    		 $existetrans = $objOferta->listarTranspag("where code like '%".$transaction->getCode()."%'");
    		mail('eliakim.ramos@edegraca.com.br', 'arrey trans', $existetrans['code']);
    		 if(!empty($existetrans['code'])){
    		 	$restposta = $objOferta->editarPagseguro($retornopag,$transaction->getCode());
    		 	
    		 }else{
    		 	$resposta = $objOferta->InserirPagseguro($retornopag);
    		 	
    		 }
    		switch($status->getValue()){
    			case 3:
    				$aux = explode(" ", $retornopag['items_id']);
					$oferta = $aux[0];
					$cliente = $aux[1];
					$compras = $aux[2];
					
    				$idcompras = explode("k",$compras);
					
				foreach($idcompras as $id){
					if($id){
						$retorno = $objOfertClient->getOfertaCliente("and id=".$id);
	    		 	    $retorno['ativo'] = 1;
						$retorno['comprou'] = 1;				
						$objOfertClient->editarOfertaCliente($retorno,$retorno['id']);
					}
	    		 }
    				break;
    		}
    		
    		 /*if($status->getValue() == 1){
					$idcompras = explode("k",$retornopag['items_id']);
					mail('eliakim.ramos@edegraca.com.br', 'inseriu', $idcompras);
				foreach($idcompras as $id){
					if($id){
						$retorno = $objPechincha->getOfertaCliente("and id=".$id);
	    		 	    $retorno['ativo'] = 1;
						$retorno['comprou'] = 1;				
						$objOfertClient->editarOfertaCliente($retorno,$retorno['id']);
					}
	    		 }
    		 }*/
    		
    		
    	} catch (PagSeguroServiceException $e) {
    		die($e->getMessage());
    	}
    	
    }
    
    
    private static function printLog($strType = null) {
    	$count = 4;
    	echo "<h2>Receive notifications</h2>";
    	if($strType) { 
    		echo "<h4>notifcationType: $strType</h4>";
    	}
    	echo "<p>Last <strong>$count</strong> items in <strong>log file:</strong></p><hr>";
    	echo LogPagSeguro::getHtml($count);
    }
	
}
NotificationListener::main();
?>