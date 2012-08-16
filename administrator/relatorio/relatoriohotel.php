<?php session_start();

 require_once("../models/Base.php");
 require_once("../models/Paginacao.php");
 require_once("../models/Cliente.php");
 require_once('../models/Login.php');
 
 	$login = new Login();
	$confirmacao = $login->verificar();
	if($confirmacao == false){?>
<script language="JavaScript" type="text/javascript">window.location = '../entrar.php';</script>
<?php	die;	} 

 $login->conectar();
 $sql = "SELECT c.nome, c.email, o.titulo,o.id as idhoteloferta, oc.ativo, oc.comprou, oc.id as idclihotel FROM cliente AS c INNER JOIN oferta_cliente AS oc ON ( c.id = oc.id_cliente ) INNER JOIN oferta AS o ON ( oc.id_oferta = o.id )
WHERE oc.ativo =1 AND oc.comprou =1 AND o.id IN ( 108, 137, 126, 127, 119, 120 ) ";
$query = mysql_query($sql);

function estaagendado($idclientehotel){
	$sql2="select * from agenda_hotel where id_cliente = ".$idclientehotel;
	$query2 =mysql_query($sql2);
	$dados = mysql_fetch_object($query2);
	if(!empty($dados)){
		return "agendado";
	} else{
		return "naoagendado";
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>&Eacute de gra&ccedil;a - Administrativo</title>
<link rel="stylesheet" type="text/css" href="../style/edegraca-sis.css"/>
<!--<link rel="stylesheet" type="text/css" media="screen" href="style/css_page.css" />-->
<link rel="stylesheet" type="text/css" media="screen" href="../style/ui.tabs.css" />
<link type="text/css" href="../style/galeria.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" media="all" href="../style/jScrollPane.css" />
<style>
.agendado {
	background-color: #06679B ;
}

.naoagendado {
	background-color:#A00704;
}

.semsistema{
	background-color: #382F04;
}

</style>

</head>
<body>
<div id="main">
<h1>Relatorio de Hotel</h1>

<div id="consultaCliente">
<table width="100%" class="table">
    <tbody><tr class="column1_titulo">
 		 <th>Nome</th>
 		 <th>E-mail</th>
 		 <th>titulo</th>
 		 
    </tr>
     <?php 
 while($dados = mysql_fetch_object($query)){
 	?>
    
     <tr <?php if($dados->idhoteloferta == "137"){ echo "class= ".estaagendado($dados->idclihotel);}else{echo"class='semsistema'";}?>>
       <td><?php echo ucwords(strtolower($dados->nome));?></td>
	  
	  <td><?php echo $dados->email;?></td>
	  <td><?php  $ofetatxt = str_replace("[span]","<span>",$dados->titulo);
				$ofetatxt = str_replace("[/span]","</span>",$ofetatxt);echo $login->anti_injection($ofetatxt);?></td>
	  
    </tr>
     <?php } ?>      
  </tbody>
  </table>
</div> <!-- fim div consultacliente -->
</div> <!--fim div main-->

</body>
</html>