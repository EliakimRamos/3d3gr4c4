<?php
require_once("models/Base.php");
require_once("models/CidadesOferta.php");

$cidadesofetas = new CidadesOferta();
$cidadesofetasDados = $cidadesofetas->listarCidadesOferta("");
?>
 
<html>
<head>
<meta http-equiv="Content-Language" content="en" />
<meta name="GENERATOR" content="PHPEclipse 1.0" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Email</title>
<link rel="stylesheet" type="text/css" media="screen" href="../public/css_page.css" />  
</head>
<body bgcolor="#FFFFFF" text="#000000" link="#FF9966" vlink="#FF9966" alink="#FFCC99">
<div id="botao">
 
  <form action="exportar.php" method="post" name="formCliente"  id="formCliente">
    <select name="cidade[]" id="cidade"  style="height:200px;" MULTIPLE>
  	  	<?php foreach($cidadesofetasDados as $dadosCidade){?>
    		<option value="<?php echo $dadosCidade['id']?>" <?php if($dadosCidade['id'] == "1"){echo 'selected="selected"';}?>><?php echo $dadosCidade['descricao']?></option>
    	<?php } ?>
  	</select>
  
  	<input type="submit" value="Exportar"/>
   </form>
  
  <!--<a href="exportar.php">Exportar.csv</a>--> 
</div>
<div id="resposta">
</div>
</body>
</html>