<?php session_start();
	
	$qtd = $_POST['qtd'];
	$valor = $_POST['valor'];
	
	if($qtd == 1){
		if($_SESSION['limite'] == 0){
			
		}else{
			--$_SESSION['limite'];			
			++$_SESSION['qtdcomprak'];
			//var_dump($_SESSION['qtdcomprak']);
			 $valortotal += $valor * $_SESSION['qtdcomprak'];
			 //$valortotal += $valor;
			echo number_format($valortotal,2,",",".");
		//die;			
			$_SESSION['qtdcomprak2'] = $_SESSION['qtdcomprak'];
		}
	}else{
		++$_SESSION['limite'];
		--$_SESSION['qtdcomprak'];
		//var_dump($_SESSION['qtdcomprak']); 
		 echo number_format(($valor * $_SESSION['qtdcomprak']),2,",",".");
		$_SESSION['qtdcomprak2'] = $_SESSION['qtdcomprak'];
	}
?>