<?php
	require_once ("../models/Base.php");
	require_once ("../models/Cliente.php");
	$cliente = new Cliente();
	$cliente->conectar();
		
	$cep = $cliente->anti_injection($_POST['cep']);
	$cep = str_replace("-", '', $cep);
	var_dump($cep);
	
	$endereco = mysql_query("select endereco_logradouro, bairro_codigo FROM endereco where endereco_cep =". $cep);
	$endereco =  mysql_fetch_array($endereco);
	echo mysql_error();

	if($endereco){
		$bairro = mysql_query ("select cidade_codigo, bairro_descricao FROM bairro where bairro_codigo =". $endereco['bairro_codigo']);
		$bairro =  mysql_fetch_array($bairro);
		echo mysql_error();
		echo "select uf_codigo, cidade_descricao FROM cidade where cidade_codigo =". $bairro['cidade_codigo'];
		$cidade = mysql_query ("select uf_codigo, cidade_descricao FROM cidade where cidade_codigo =". $bairro['cidade_codigo']);
		$cidade =  mysql_fetch_array($cidade);
		var_dump($cidade);
		echo mysql_error();
	}else{
		$cidade = mysql_query ("select uf_codigo, cidade_descricao FROM cidade where cidade_cep =". $cep);
		$cidade =  mysql_fetch_array($cidade);
		echo mysql_error();
	}
	var_dump($cidade);die;
	echo "select uf_descricao FROM uf where uf_codigo = ".$cidade['uf_codigo'];
	$estado = mysql_query("select uf_descricao FROM uf where uf_codigo = ".$cidade['uf_codigo']);
	$estado =  mysql_fetch_array($estado);
    echo mysql_error();	
	$resposta['estado'] = $estado['uf_descricao'];
	$resposta['cidade'] = $cidade['cidade_descricao'];
	$resposta['bairro'] = $bairro['bairro_descricao'];
	$resposta['endereco'] = $endereco['endereco_logradouro'];
	
if($resposta){	?>
 		<input type="hidden" id="estado1" name="estado1" class="input" value="<?php echo utf8_encode($resposta['estado'])?>" />
  	    <input type="hidden" id="cidade1" name="cidade1" class="input" value="<?php echo utf8_encode($resposta['cidade'])?>" />
       	<input type="hidden" id="bairro1" name="bairro1" class="input" value="<?php echo utf8_encode($resposta['bairro'])?>" />
  	    <input type="hidden" id="endereco1" name="endereco1" class="input" value="<?php echo  utf8_encode($resposta['endereco'])?>" />
  
	<?php }else{ ?>
		<input type="hidden" id="erro" name="erro" class="input" value="CEP Inv�lido"/>
	<?php } ?>
