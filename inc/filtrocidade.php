<?php 
require_once("../administrator/models/Base.php");
require_once("../administrator/models/Cliente.php");
require_once ("../administrator/models/Oferta.php");
$objCliente = new Cliente();
$objOferta = new Oferta();
$letradacidade = $objOferta->anti_injection($_POST['letracidadefiltro']);
$cidadestopolistforletra = $objOferta->listacidadeporletra($letradacidade);
if(!empty($cidadestopolistforletra)){
foreach($cidadestopolistforletra as $dadoscidadeofletras){  ?>
      	<li><a href="<?php echo /*$dadoscidadeofletras->id*/"#";?>" <?php if($dadoscidadeofletras->id == "1"){ ?> class="cidade-ativa" <?php } ?>><?php echo utf8_encode($dadoscidadeofletras->descricao);?></a></li>
<?php }
}else{
	echo"<li>Não há cidasdes com essa letra</li>";
}
 ?>
