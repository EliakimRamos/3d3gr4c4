<?php session_start();
	require_once ("administrator/models/Base.php");
	require_once ("administrator/models/Cliente.php");
	
	$id = $_GET['cliente'];
	
	$objCliente = new Cliente();
	
	if($acharCliente = $objCliente->getCliente($id, "id")){ 
		$acharCliente['receber_news'] = 1;
		$objCliente->editarCliente($acharCliente, $id);
}?>
	
<script>
	alert("<?php echo utf8_encode("E-mail removido !")?>");
	window.location="./index.php";
</script>