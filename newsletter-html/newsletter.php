<?php
require ("../administrator/models/Base.php");
require ("../administrator/models/Cliente.php");
require ("../administrator/models/Oferta.php");
require ("../administrator/models/Empresa.php");
$objOferta = new Oferta();
$oferta1 = $objOferta->listarOferta(" and ativa = 1 and posicao in (1,2)");
$oferta2 = $objOferta->listarOferta(" and ativa = 1 and posicao not in (1,2)");
function abreviaString($texto, $limite, $tres_p = '...')
{
    $totalCaracteres = 0;
    //Cria um array com todas as palavras do texto
    $vetorPalavras = explode(" ",$texto);
    if(strlen($texto) <= $limite):
        $tres_p = "";
        $novoTexto = $texto;
    else:
        //Começa a criar o novo texto resumido.
        $novoTexto = "";
        //Acrescenta palavra por palavra na string enquanto ela
        //não exceder o tamanho máximo do resumo
        for($i = 0; $i <count($vetorPalavras); $i++):
            $totalCaracteres += strlen(" ".$vetorPalavras[$i]);
            if($totalCaracteres <= $limite)
                $novoTexto .= ' ' . $vetorPalavras[$i];
            else break;
        endfor;
    endif;
    return $novoTexto . $tres_p;
}?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#324e01" align="center">
<tbody>
<tr>
<td align="center"><br />

<table width="600" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td><a href="http://www.edegraca.com.br" target="_blank"><img src="http://www.edegraca.com.br/newsletter-html/images/topo.jpg" width="600" height="123" alt="topo" /></a></td>
  </tr>
  <tr>
  <td align="center">
  <table width="590" style="font-family:'Trebuchet MS', Arial, Helvetica, sans-serif" id="tudo">
  <tr>
  <td><table width="590" border="0" cellspacing="10" cellpadding="0">
    <tr>
    <?php foreach($oferta1['oferta'] as $dados1){?>
    <td valign="top">
		    
	    <table width="275" border="0" cellspacing="0" cellpadding="0" class="promo1">
	      <tr>
	        <td>
	        <table cellspacing="10" width="275">
	        <tr>
	        <td style="color:#3a5403; font-size:13px; font-weight:bold"><?php $ofetatxt = str_replace("[span]","<span>",$dados1["titulo"]);
				$ofetatxt = str_replace("[/span]","</span>",$ofetatxt);
				 echo $ofetatxt;?>
				 </td>
	        </tr>
	        </table>
	        </td>
	      </tr>
	      <tr>
	        <td><img src="http://www.edegraca.com.br/newsletter-html/images/promo-top.jpg" alt="" width="275" height="17" /></td>
	      </tr>
	      <tr>
	        <td><table width="275" border="0" cellspacing="0" cellpadding="0">
	          <tr>
	            <td><img src="http://www.edegraca.com.br/newsletter-html/images/promo-left.jpg" alt="" width="15" height="164" /></td>
	            <td width="237"><?php $dadosimg = $objOferta->getOfertaImagem($dados1['id'],"id_oferta")?><img src="http://www.edegraca.com.br/administrator/uploads/<?php echo $dadosimg['image']?>" alt="" width="237" height="164" /></td>
	            <td><img src="http://www.edegraca.com.br/newsletter-html/images/promo-right.jpg" alt="" width="23" height="164" /></td>
	          </tr>
	        </table></td>
	      </tr>
	      <tr>
	        <td><img src="http://www.edegraca.com.br/newsletter-html/images/promo-bottom.jpg" alt="" width="275" height="12" /></td>
	      </tr>
	      <tr>
	        <td><table width="275" border="0" cellspacing="0" cellpadding="0">
	          <tr>
	            <td width="9"><img src="http://www.edegraca.com.br/newsletter-html/images/space.jpg" alt="" width="9" height="53" /></td>
	            <td style="background:#40590b; border-bottom-left-radius:5px; border-bottom-right-radius:5px; -moz-border-radius-bottomleft:5px; -moz-border-radius-bottomright:5px; -webkit-border-bottom-left-radius:5px;-webkit-border-bottom-right-radius:5px"><table width="246" border="0" cellspacing="0" cellpadding="5">
	  <tr>
	    <td width="87" valign="top"><a href="http://www.edegraca.com.br/index.php?id=<?php echo $dados1['id'];?>&p=<?php echo $dados1['posicao'];?>"><img src="images/btn-veroferta.jpg" width="94" height="49" border="0" /></a></td>
	    <td width="139"><table width="95%" border="0" cellspacing="0" cellpadding="0">
	      <tr>
	        <td align="right" valign="top" style="color:#fff"><span style="color:#a6c613; font-size:12px; font">De R$ <?php echo $dados1['valor'];?> por</span></td>
	      </tr>
	      <tr> <?php $valor = explode(",", $dados1['valorpromocao']);
	                                    	//var_dump($valor);
	                                    	if(empty($valor[0]) || empty($valor[1])){
	                                    		$valor = explode(".", $dados1['valorpromocao']);
	                                    		$inteiro = $valor[0];
	                                    		$decimal = $valor[1];
	                                    	}else{
	                                    		$inteiro = $valor[0];
	                                    		$decimal = $valor[1];
	                                    	}
	                                ?>
	        <td align="right" valign="top" style="color:#fff; font-size:18px">R$<?php echo $inteiro;?>,<sup style="font-size:12px"><?php echo $decimal;?></sup></td>
	      </tr>
	    </table></td>
	  </tr>
	</table>
	</td>
	            <td width="17">&nbsp;</td>
	          </tr>
	        </table></td>
	      </tr>
	      <tr>
	        <td height="11"><img src="http://www.edegraca.com.br/newsletter-html/images/promo-price-bottom.jpg" width="275" height="11" /></td>
	      </tr>
	    </table>
	 </td>
	 <?php } ?>   
  </tr>
</table>
<br />
<table width="100%" border="0" cellspacing="10" cellpadding="0">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <?php $contador = 1;
      			foreach($oferta2['oferta'] as $dados2){
				      if($contador == 1){
	?>		      
				    	<tr>
				     <?php }?>
				          <td><table width="178" border="0" cellspacing="0" cellpadding="0" class="promopequena">
				            <tr>
				              <td><span style="color:#3a5403; font-size:11px; font-weight:bold"><?php $ofetatxt = str_replace("[span]","<span>",$dados2["titulo"]);
				$ofetatxt = str_replace("[/span]","</span>",$ofetatxt);
				 echo abreviaString($ofetatxt,110);?><br />
				              </span></td>
				            </tr>
				            <tr>
				              <td><img src="http://www.edegraca.com.br/newsletter-html/images/p-top.jpg" alt="" width="178" height="15" /></td>
				            </tr>
				            <tr>
				              <td><table width="178" border="0" cellspacing="0" cellpadding="0">
				                <tr>
				                  <td width="15"><img src="http://www.edegraca.com.br/newsletter-html/images/p-left.jpg" alt="" width="15" height="101" /></td>
				                  <?php $respimagem = $objOferta->getOfertaImagem($dados2['id'],"id_oferta");?>
				                  <td><img src="http://www.edegraca.com.br/administrator/uploads/<?php echo $respimagem['image']?>" alt="" width="145" height="101" /></td>
				                  <td width="18"><img src="http://www.edegraca.com.br/newsletter-html/images/p-right.jpg" alt="" width="18" height="101" /></td>
				                </tr>
				              </table></td>
				            </tr>
				            <tr>
				              <td height="7"><img src="http://www.edegraca.com.br/newsletter-html/images/p-bottom.jpg" alt="" width="178" height="7" /></td>
				            </tr>
				            <tr>
				              <td height="5"></td>
				            </tr>
				            <tr>
				              <td><table width="178" border="0" cellspacing="0" cellpadding="0">
				                <tr>
				                  <td><img src="http://www.edegraca.com.br/newsletter-html/images/p-preco-up.jpg" alt="" width="178" height="6" /></td>
				                </tr>
				                <tr>
				                  <td><table width="178" border="0" cellspacing="0" cellpadding="0">
				                    <tr>
				                      <td>&nbsp;</td>
				                      <td width="159" bgcolor="#446008"><table width="100%" border="0" cellspacing="5" cellpadding="0">
				                        <tr>
				                          <td width="42%"><a href="http://www.edegraca.com.br/index.php?id=<?php echo $dados2['id'];?>&p=<?php echo $dados2['posicao'];?>"><img src="http://www.edegraca.com.br/newsletter-html/images/btn-ver.jpg" alt="" width="60" height="34" hspace="0" vspace="0" border="0" /></a></td>
				                          <td width="58%" align="right" valign="middle" style="color:#fff; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; font-size:15px"><span style=" font-size:11px" >De <?php echo $dados2['valor'];?> por<br />
				                            </span>
						                            <?php $valor = explode(",", $dados2['valorpromocao']);
			                                    	//var_dump($valor);
			                                    	if(empty($valor[0]) || empty($valor[1])){
			                                    		$valor = explode(".", $dados2['valorpromocao']);
			                                    		$inteiro = $valor[0];
			                                    		$decimal = $valor[1];
			                                    	}else{
			                                    		$inteiro = $valor[0];
			                                    		$decimal = $valor[1];
			                                    	}
			                                    ?>
				                            <span style="color:#bde105">R$ <?php echo $inteiro;?>,<span style=" margin:0 0 3px 0; font-size:12px"><?php echo $decimal;?></span></span><br />
				                            </td>
				                        </tr>
				                      </table></td>
				                      <td>&nbsp;</td>
				                    </tr>
				                  </table></td>
				                </tr>
				                <tr>
				                  <td><img src="http://www.edegraca.com.br/newsletter-html/images/p-preco-down.jpg" alt="" width="178" height="25" /></td>
				                </tr>
				              </table></td>
				            </tr>
				          </table></td>
				      
				  <?php if($contador == 3){?>
				  </tr>
		<?php 	
					$contador =0;
						}
				$contador++;
      			}
      	?>
      	</tr>
			</table></td>
</table></td>
  </tr>
  </table>
  
  </td>
  </tr>
  
  <tr>
  <td><a href="http://www.edegraca.com.br" target="_blank"><img src="images/footer.jpg" width="600" height="112" alt="footer" /></a></td>
  </tr>
  
</table>



</td>

</tr>
<tbody>
</tbody>

</table>
</body>
</html>
