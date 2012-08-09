<?php
session_start();
require ("administrator/models/Base.php");
require ("administrator/models/Cliente.php");
require ("administrator/models/Oferta.php");
require ("administrator/models/Empresa.php");
require ("administrator/models/OfertaCliente.php");
require ("administrator/models/Paginacao.php");

if(!$_SESSION['cliente']){
	echo"<script>window.location='login.php'</script>";
	die;
}
$objCliente = new Cliente();
$objofertacliente = new OfertaCliente();
$objOferta = new Oferta();
$objEmpresa = new Empresa();
$cliente = $objCliente->getCliente($_SESSION['idclientek'],'id');
$qtdCupons = $objCliente->getqtdCupons($_SESSION['idclientek']);

$getkeys = array_keys($_GET);
switch($getkeys[0]){
	case "disponiveis":
			$filtrodecupons = " and id_cliente=".$_SESSION['idclientek']." and comprou = 1 and ativo = 1";
			break;
	case "Utilizados":
			$filtrodecupons = " and id_cliente=".$_SESSION['idclientek']." and ativo = 2";
			break;
	case "Expirados":
			$filtrodecupons = " and id_cliente=".$_SESSION['idclientek']." and data_validade < '".date("Y-m-d")."' and ativo = 1";
			break;
	default:
			$filtrodecupons = " and id_cliente=".$_SESSION['idclientek']." and comprou <> 0";
			
}

	

$listaofertas1 = $objofertacliente->listarOfertaCliente($filtrodecupons,"10");
$listaofertas = $listaofertas1['ofertacliente'];
$paginacao = $listaofertas1['paginacao'];
//$datavalidade = "";
$totaleconomizado = 0;
                 if(!empty($listaofertas)){
					foreach ($listaofertas as $dados1){	
						if($dados1['comprou'] == 1 && $dados1['ativo'] == 1){		
						 	$valordesconto = $objOferta->getOferta($dados1['id_oferta'],"id");
						 	//$datavalidade = $valordesconto['data_validade'];
						 	$totaleconomizado = $totaleconomizado + $valordesconto['valordesconto'];
						}	
					}
                 }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include('inc/header.php'); ?>
<script language="JavaScript" type="text/javascript">
  function popupvoucher(idpro,idoferta){
		window.open("cupom.php?id="+idpro+"&id_oferta="+idoferta,"_blank","toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=yes, width=700, height=600");
	}
	
	function utilizado(){}
</script>
  
</head>

<body>
<?php include('inc/topo.php'); ?>
<div id="main">
<div id="main-left">
	
    <?php $menu = "cupons"  ?>
   <?php include('inc/menu-minhaconta.php'); ?>
   
    <div class="contorno-meio">
    <h4>Meus Cupons</h4>
    <ul class="lista-tipo-cupom">
    	<li><a href="minha-conta-cupons.php">Todos</a></li>
        <li><a href="?disponiveis">Disponíveis</a></li>
        <li><a href="?Utilizados">Utilizados</a></li>
        <!--<li><a href="?Expirados&">Expirados</a></li>-->
    </ul>
   <table width="730" border="0" cellspacing="0" cellpadding="0" class="meus-cupons">
  <tr>
    <th scope="col" width="120"><span>Cupom</span></th>
    <th scope="col" width="250"><span>Detalhes</span></th>
    <th scope="col" width="100"><span>Validade</span></th>
    <th scope="col" width="120"><span>Utilizador</span></th>
  </tr>
  <?php if(!empty($listaofertas)){
  		foreach($listaofertas as $dados){ 
							$ofertaatual = $objOferta->getOferta($dados['id_oferta'], "id");
							$empresaatual = $objEmpresa->getEmpresa($ofertaatual['id_empresa'], "id");
							$imagens = $objOferta->getOfertaImagem($dados['id_oferta'],'id_oferta');
							//<?php if($dados['ativo'] == 2 || $ofertaatual['data_validade'] < date("Y-m-d") && $dados['ativo'] == 1){ echo"style='background:none;cursor: default;'";}
 ?>
  <tr>
    <td><span><?php echo utf8_encode($empresaatual['nome_fantasia'])?></span>
      <img src="administrator/uploads/<?php echo $imagens['image'];?>" width="57" height="35" alt="foto-cupom" /></td>
    <td><?php $arrayli = array('<li>',"</li>","<ul>","</ul>","<l>","</l>","[span]","[/span]"); echo str_replace($arrayli,"",substr($objOferta->anti_injection($ofertaatual['titulo']),0,83));?> 
     		<div class="btn-imprimir" onclick="javascript:popupvoucher(<?php echo $dados['id']; ?>,<?php echo $ofertaatual['id'];?>)"></div>
     </td>
    <td><?php echo $objOferta->date_transform($ofertaatual['data_validade']);?>
    	<div class="btn-ja-utilizei" onclick="javascript:utilizado()" <?php if($dados['ativo'] == 2 || $ofertaatual['data_validade'] < date("Y-m-d") && $dados['ativo'] == 1){ echo"style='background:none;'";}?>></div><?php if($dados['ativo'] == 2){ ?> <span>Utilizado</span><?php } ?><?php if($ofertaatual['data_validade'] < date("Y-m-d") && $dados['ativo'] == 1){ ?> <span>Expirado</span><?php } ?>
    </td>
    <td><?php echo utf8_encode($dados['nome']); ?></td>
  </tr>
  <?php } 
  }
  ?>  
</table>
    
<div class="pagination">

				 	<p class="counter">
				Resultado de 
  	<?php if($paginacao->TotalDeElementos == '0'){echo '0';}
  	else{
  		if($paginacao->Inicial == 0){echo '1';}
  		else{
  			echo $paginacao->Inicial;}}
  	?> a 
  	<?php if(($paginacao->Inicial+$paginacao->NumeroRegistroPagina) > $paginacao->TotalDeElementos){
  			echo $paginacao->TotalDeElementos;}
  		else{echo ($paginacao->Inicial+$paginacao->NumeroRegistroPagina);}
  	?> de 
  	<?php echo $paginacao->TotalDeElementos;?>
  	 registros.</p>
		<?php echo $paginacao->MontarPaginacao($paginacao->PaginaAtual, $paginacao->UltimaPagina) ?>
		<!--<ul><li class="pagination-start"><span class="pagenav">Início</span></li><li class="pagination-prev"><span class="pagenav">Ant</span></li><li><span class="pagenav">1</span></li><li><a title="2" href="#" class="pagenav">2</a></li><li><a title="3" href="#" class="pagenav">3</a></li><li><a title="4" href="#" class="pagenav">4</a></li><li class="pagination-next"><a title="Próx" href="#" class="pagenav">Próx</a></li><li class="pagination-end"><a title="Fim" href="#" class="pagenav">Fim</a></li></ul>-->	
        
        </div>

  
	</div> <!-- fim contorno-meio -->
    
    
    
    
    
</div> <!-- fim div main-left-->

<?php include('inc/direita-promocoes.php'); ?>
</div><!-- fim div main-->
<?php include('inc/footer.php'); ?> 
</body>
</html>