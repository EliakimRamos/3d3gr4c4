<?php session_start();

 require_once("models/Base.php");
 require_once("models/Paginacao.php");
 require_once("models/Oferta.php");
 require_once('models/Login.php');
 
 	$login = new Login();
 	$objOfertas = new Oferta();
	$confirmacao = $login->verificar();
	if($confirmacao == false){?>
<script language="JavaScript" type="text/javascript">window.location = '../../entrar.php';</script>
<?php	die;	} 

 $ofertaresult = $objOfertas->listarOferta2("and ativa = 3");
?>
<div id="main">
<h1>Links Das ofertas Que vão entrar no site</h1>

<div id="consultaCliente">
<table width="100%" class="table">
    <tbody><tr class="column1_titulo">
 		 <th>Link</th>	 
    </tr>
 <?php 
  
 if(!empty($ofertaresult)){
	 foreach($ofertaresult as $dados){
	 	?>
	    
	     <tr>
	       <td>
	       		<a href="http://edegraca.com.br/index.php?id=<?php echo $dados['id'];?>" target="_blank" style="FONT-SIZE: 14px; text-decoration:none; color:#91D120; border:dotted 1; FONT-FAMILY: Lucida Sans">
	       			<?php  $ofetatxt = str_replace("[span]","<span>",$dados['titulo']);
							$ofetatxt = str_replace("[/span]","</span>",$ofetatxt);echo $login->anti_injection($ofetatxt);
					?>
				</a>
			</td>	  
	    </tr>
   <?php  } 
   }else{
   ?>
    <tr>
       <td>
       		Não há ofertas cadastradas para entrar no site
		</td>	  
    </tr>
     <?php 
     }     
     ?>      
  </tbody>
  </table>
</div> <!-- fim div consultacliente -->
</div> <!--fim div main-->