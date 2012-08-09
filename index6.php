<?php
session_start();
require ("administrator/models/Base.php");
require ("administrator/models/Cliente.php");
require ("administrator/models/Oferta.php");
require ("administrator/models/Empresa.php");

$objOferta = new Oferta();
$objCliente = new Cliente();
$objEmpresa = new Empresa();
$datahoje = date("Y-m-d");

$objOferta->ativarOferta();
//$objOferta->desativaOferta();	
$objOferta->conectar();

$Novato = false;
	if($objOferta->anti_injection($_GET['idCidade'])){
		$idCidade = $objOferta->anti_injection($_GET['idCidade']);
	}else{
		if($_COOKIE['idCidade']){
			$idCidade = $_COOKIE['idCidade'];
		}else{
			if($_SESSION['Cadastrei']){
				$idCidade = $_SESSION['Cadastrei'];
			}else{			
				$Novato = true;	
				$idCidade = 1;
			}
		}
	}
	
	if(!$Novato){
		setcookie("idCidade", $idCidade, time()+3600*24*7);
	}


	if($objOferta->anti_injection($_GET['id'])){
		$id = $objOferta->anti_injection($_GET['id']);

		$oferta = $objOferta->getOferta($id ,"id");
		if(empty($oferta)){	
			//header("Location: index.php");
			echo"<meta http-equiv='refresh' content='1;URL=http://www.edegraca.com.br/index.php'>"; /*<script language='JavaScript' type='text/javascript'>
  			window.locatio=
		</script>*/
		die;
		}
	}else{
		$filtro = $idCidade." and o.data_final > ".$datahoje." and o.ativa = 1 and o.posicao = 1 ";
		$aux = $objOferta->listarOferta3($filtro);
		$oferta = $aux[0];	
	}		
		
	if(!empty($oferta)){
		$_SESSION['OfertaAtual'] = $oferta["posicao"];	
		$_SESSION['Categoria'] = $oferta['id_categoria'];
		$_SESSION['IdAtual'] = $oferta['id'];
		
		$respImag = $objOferta->listarOfertaImagem(" and id_oferta=".$oferta['id']);
		 
		$empresa = $objEmpresa->getEmpresa($oferta['id_empresa'], "id");
		
		$diain = substr($oferta['data_inicio'], 8,2);
		$mesin = substr($oferta['data_inicio'], 5,2);
		$anoin = substr($oferta['data_inicio'], 0,4);
		
		$dia = substr($oferta['data_final'], 8,2);
		$mes = substr($oferta['data_final'], 5,2);
		$ano = substr($oferta['data_final'], 0,4);
	}
	$_SESSION['qtdBonus'] = 0;
	$objOferta->conectar();
	$Cidades = mysql_query("SELECT * FROM cidade_oferta order by descricao");
if(empty($oferta)){
	echo"<meta http-equiv='refresh' content='1;URL=http://www.edegraca.com.br/cadastro.php'>"; /*<script language='JavaScript' type='text/javascript'>
  			window.locatio=
		</script>*/
		die;
}	
?>
 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta property="fb:app_id" content="{176616725783872}"/>
<meta name="keywords" content="é de , Rodízio, Carne, Graça, oferta, desconto, promoção, Recife, boi preto, churascaria, graça, graca." />
<?php include('inc/header.php'); ?>
   <script language="JavaScript" type="text/javascript">
						<?php 
								$timestamp1 = mktime("23","59","59",$mes,$dia,$ano);
								$timestamp2 = mktime(date('H'),date("i"),date('s'),date('m'),date("d"),date('Y'));
								$resultado = $timestamp1 - $timestamp2;
								
						?>
						var numTicks = 0;
						var secondsTil = <?php echo $resultado;?>
						
						var intervalid = startClock();

						function startClock() {
							return setInterval(tick, 1000);
						}
						
						function tick() {
							var seconds = secondsTil--;
							if (seconds < 0) {
								seconds = 0;
							}
							var dias = Math.floor(seconds /86400);
							
							var hours = Math.floor(seconds / 3600) - (dias * 24);
							seconds -= Math.floor(seconds / 3600) * 3600;
							var minutes = Math.floor(seconds / 60);
							seconds -= minutes * 60;

							var StrTime = dias.toString();
							if(dias < 10)
							{
								StrTime = "0"+ StrTime;
							}
							document.getElementById("dias").innerHTML = StrTime;
							

							var StrTime = hours.toString();
							if(hours < 10)
							{
								StrTime = "0"+ StrTime;
							}
							document.getElementById("horas").innerHTML = StrTime;
							StrTime = minutes.toString();
							if(minutes < 10)
							{
								StrTime = "0"+ StrTime;
							}
							 document.getElementById("minutos").innerHTML = StrTime;
							
							StrTime = seconds.toString();
							if(seconds < 10)
							{
								StrTime = "0"+ StrTime;
							}
							 document.getElementById("segundos").innerHTML = StrTime;        
						 
							if (numTicks++ > 500 || secondsTil == 0) {
								if (window.location.href.lastIndexOf('?') > -1) {
									window.location.href = window.location.href;
									clearInterval(intervalid);
								} else {
									window.location.href = window.location.href;
									clearInterval(intervalid);
								}
							}
						}
					</script>

</head>

<body>
<?php include('inc/topo.php'); ?>
<div id="main">
<div id="main-left">
	<h1><?php $ofetatxt = str_replace("[span]","<span>",$oferta['titulo']);
				$ofetatxt = str_replace("[/span]","</span>",$ofetatxt);
				 echo $ofetatxt; ?> </h1>
    
    <div id="off-top">
    	<div><?php
                  	$ofertadesc = explode(",",$oferta['desconto']);
                  	if(empty($ofertadesc[0]) || empty($ofertadesc[1])){
                  		$ofertadesc = explode(".",$oferta['desconto']);
                  	}
                    echo $ofertadesc[0]."%";?> OFF
        </div>
    </div>
    <div id="slice-up"></div>
    <div id="container-promo-dia">
    <div id="container-left">
   		<div id="off-bottom">
   		<?php /*$oferta['valorpromocao'] = str_replace(".",",",$oferta['valorpromocao']);*/
	                                    	$valor = explode(",", $oferta['valorpromocao']);
	                                    	//var_dump($valor);
	                                    	if(empty($valor[0]) || empty($valor[1])){
	                                    		$valor = explode(".", $oferta['valorpromocao']);
	                                    		$inteiro = $valor[0];
	                                    		$decimal = $valor[1];
	                                    	}else{
	                                    		$inteiro = $valor[0];
	                                    		$decimal = $valor[1];
	                                    	}
	                                    	
	     ?> 
   			<div>R$ <?php echo $inteiro;?>,<sup><?php echo $decimal;?></sup></div>
   		</div> 
        <div id="tempo-container"> 
        <div id="tempo-restante"> 
        tempo restante para a compra
       </div> 
        <div class="relogio-todo">
        <div class="relogio-col">
        	<div class="relogio" id="dias"> 01</div>
            dias
        </div>
        <div class="relogio-col">
        	<div class="relogio" id="horas"> 01</div>
            horas
        </div>
        <div class="relogio-col">
        	<div class="relogio" id="minutos"> 01</div>
            min
        </div>
        <div class="relogio-col">
        	<div class="relogio" id="segundos"> 01</div>
            seg
        </div>
        
        </div>
        </div> <!-- div tempo-container -->
        <div id="preco-economia">
        	<div id="preco-normal">
        			preço normal: <span><?php 
	                                    	$valor = explode(",", $oferta['valor']);
	                                    	//var_dump($valor);
	                                    	if(empty($valor[0]) || empty($valor[1])){
	                                    		$valor = explode(".", $oferta['valor']);
	                                    		$inteiro = $valor[0];
	                                    		$decimal = $valor[1];
	                                    	}else{
	                                    		$inteiro = $valor[0];
	                                    		$decimal = $valor[1];
	                                    	}
	                                     	echo "R$ ".$inteiro.",".$decimal;
	                                    ?>
	                              </span>
        	</div>
            <div id="economia">
        			economia de: <span>R$ <?php
	                                    	$valor = explode(",", $oferta['valordesconto']);
	                                    	//var_dump($valor);
	                                    	if(empty($valor[0]) || empty($valor[1])){
	                                    		$valor = explode(".", $oferta['valordesconto']);
	                                    		$inteiro = $valor[0];
	                                    		$decimal = $valor[1];
	                                    	}else{
	                                    		$inteiro = $valor[0];
	                                    		$decimal = $valor[1];
	                                    	}
	                                     	echo "R$ ".$inteiro.",".$decimal;
	                                      ?>
	                             </span>
        	</div>
            
        </div>
        <div class="off-separador"></div>
        <div class="promo-status">Oferta Ativada</div>
       <div class="off-separador"></div> 
       <div class="qtd-pessoas"><?php 
									echo $objOferta->qtdVendida($oferta['id']);	
	                             ?></div>
       <div class="pessoas-compraram">Pessoas já compraram</div>
       <div class="btn-comprar"><a href="tela-comprar.php?oferta=<?php echo $oferta['id']; ?>"></a>	</div>
       
        
     </div> <!--container-left -->
     <div id="container-right">
     <div id="container-foto">
     <?php foreach($respImag as $dados){?>
     	<img src="administrator/uploads/<?php echo $dados['image'] ?>" width="532" height="369" alt="promocao1" />
     <?php } ?> 
     </div>
     <div id="redes-sociais">
     <div class="twitter-promo-principal"><a href="#"></a></div>
     <div class="fb-like" data-href="http://www.facebook.com/edegraca.com.br" data-send="false" data-layout="button_count" data-width="450" data-show-faces="false"></div>-->
     </div> <!--fim redes-sociais-->
     
         
     </div>    
     <!--container-right-->
   
    
    
    
    </div> <!--fim container-promo-dia -->
    <div id="slice-down"></div>
    
    
    <div class="contorno-meio">
    <div class="contorno-col-1">
    <h2> Descrição:</h2>
    <?php 
		    echo nl2br($oferta['descricao']);
    ?>
    </div>	
    <div class="contorno-col-2"><h2> Regras: </h2> 
    	<?php	echo nl2br($oferta['regras']);?>
    </div>
    
    </div><!-- contorno-meio -->
    
    <div class="contorno-meio">
    <h2> Informa&ccedil;&otilde;es:</h2>
     <strong><?php echo nl2br($empresa['nome'])?></strong> <br/>
	         <?php echo nl2br($empresa['descricao'])?>
    </div>
<?php
		if ($empresa['num']!="0"){
		$endMapa=$empresa['endereco'].",".$empresa['num'].",".$empresa['bairro'].",".$empresa['cidade'].",PE,".$empresa['cep'];
		$endMapa= str_replace(" ", "+", $endMapa);
		
?> 
    
    <div class="contorno-meio">
    	<h2>Localização:</h2>
        
        <iframe width="731" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=pt-br&amp;geocode=&amp;q=<?php echo $empresa['latitude']?>,<?php echo $empresa['longitude']?>+(<?php echo $endMapa?>)&amp;ie=UTF8&amp;z=14&amp;t=m&amp;ll=<?php echo $empresa['latitude']?>,<?php echo $empresa['longitude']?>&amp;output=embed"></iframe><br /></div>
        
    
        
    <?php }?>
    
    <div class="contorno-meio">
    <div class="fb-like-box" data-href="http://www.facebook.com/edegraca.com.br" data-width="731" data-height="200" data-show-faces="true" data-stream="false" data-header="true"></div>
    </div>
    
    
    <div class="contorno-meio">
    <div class="fb-comments" data-href="http://www.edegraca.com.br/index.php" data-num-posts="2" data-width="731"></div> 
    </div>
    
</div> <!-- fim div main-left-->

<?php include('inc/direita-promocoes.php'); ?>
</div><!-- fim div main-->
<?php include('inc/footer.php'); ?> 



</body>
</html>