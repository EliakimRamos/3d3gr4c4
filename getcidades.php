<?php
require ("administrator/models/Base.php");
require ("administrator/models/Cliente.php");
$objCliente = new Cliente();
$idestados = $objCliente->anti_injection($_POST['cod_estado']);
$cidadesofuflist = $objCliente->getCidadedouf($idestados);
if(!empty($cidadesofuflist)){
	foreach($cidadesofuflist as $dadoscidadesofuf){
		?>
		<option value="<?php echo $dadoscidadesofuf->cidade_codigo; ?>"><?php echo utf8_encode($dadoscidadesofuf->cidade_descricao); ?></option>
		<?php
	}
}
?>
