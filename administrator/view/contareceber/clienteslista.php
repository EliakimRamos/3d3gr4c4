<?php session_start();
header('Content-Type: text/html; charset=iso-8859-1',true);
require('../../models/Base.php');
require('../../models/Cliente.php');
require('../../models/Pedido.php');

$cliente = new Cliente();
$pedido = new Pedido();

if($_POST['cliente']!='' && $_POST['cliente']!="Cliente n&atilde;o Cadastrado!!"){
$resposta1 = $cliente->listarClientes2(" and nome = '".$_POST['cliente']."'");
if($resposta1){
$_POST['valor_total'] = 0;
$_POST['obsevacao'] = "";
if($_POST['conta']){
foreach($resposta1 as $dadosResposta){
	echo "<input type='hidden' name='id_cliente' value='".$dadosResposta["id_cliente"]."' />";
}
}else{
 
foreach($resposta1 as $dadosResposta){
	$resposta['nome'] = $dadosResposta["nome"];
	$resposta['telefone'] = $dadosResposta["telefone"];
	$resposta['cidade'] = $dadosResposta["cidade"];
	$resposta['estado'] = $dadosResposta["estado"];
	$resposta['id_cliente'] = $dadosResposta["id"];
}
$_POST['id_cliente'] = $resposta['id_cliente'];
$inserir = $pedido->inserirPedido($_POST);
$html = "<table border='0' cellspacing='0' cellpading='0' width='100%'>
					   <tr bgcolor='#DBE4E8'>
						  <th>Nome</th>
						  <th>Telefone</th>
						  <th>Cidade</th>
						  <th>Estado</th>		  
					   </tr>";


			$conteudo.= "<tr bgcolor='#DBE4E8'>
							
							<td>".$resposta['nome']."</td>
							<td>".$resposta['telefone']."</td>
							<td>".$resposta['cidade']."</td>
							<td>".$resposta['estado']."</td>
						 </tr>
						 <input name='idCliente' id='idCliente' type='hidden' value='".$resposta['id_cliente']."' />
						 ";
			

		$html.=$conteudo;
		$html.="</table>";
		echo $html;	
}
}else{
	echo"Cliente Não cadastrado";
}
}else{
	echo "Cliente não Cadastrado!!";
}	

$_SESSION['id_pedido'] =$inserir;
	   
?>
