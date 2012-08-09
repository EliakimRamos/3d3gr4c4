<?php session_start();
require ("administrator/models/Base.php");
require ("administrator/models/Cliente.php");
require ("administrator/models/Oferta.php");
require ("administrator/models/OfertaCliente.php");
require ("administrator/models/Empresa.php");
require ("administrator/models/Agendahotel.php");
require ("administrator/models/Login.php");

$objLogin = new Login();
$confirmacao = $objLogin->verificarCliente(); 

if($confirmacao == false){

	$_SESSION['url_compra'] = $_SERVER["REQUEST_URI"];
	//header("location:./login.php");
	//echo"<meta http-equiv='refresh' content='1;URL=http://www.edegraca.com.br/login.php'>";
	echo"<script>window.location='login.php';</script>";
	die;
	
}

$objOferta = new Oferta();
$objOfertaCliente = new OfertaCliente();
$objCliente = new Cliente();
$objEmpresa = new Empresa();
$objAgendaHotel = new Agendahotel();

$datahoje = date("Y-m-d");
$id = $objOferta->anti_injection($_GET['oferta']);
$cliente = $objCliente->getCliente($_SESSION['idclientek'], "id");
$oferta = $objOferta->getOferta($id, "id");
$vagasHotel = $objAgendaHotel->listarAgendahotel(" where id_hotel = ".$id);

if($oferta['ativa'] == 0){
	@header("location:./index.php");
	echo"<script>window.location='./index.php';</script>";	
}

$_SESSION['key_security'] = md5("edegraca compra coletiva 2012");

$empresa = $objEmpresa->getEmpresa($oferta['id_empresa'], "id");

$total = $objOferta->qtdVendida($id);

function sonumeros($entrada){
	$entrada = str_replace(".", "", $entrada);
	$entrada = str_replace("-", "", $entrada);
	$entrada = str_replace("/", "", $entrada);
	$entrada = str_replace(",", "", $entrada);
	$entrada = str_replace(" ", "", $entrada);

	$saida = $entrada;
	return $saida ;
}

$_SESSION['limite'] = $oferta['limite']-1;
$_SESSION['qtdcomprak'] = 1;
$_SESSION['qtdcomprak2'] = 0;
$i = 0;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include('inc/header.php'); ?>
<script src="js/jquery.maskedinput-1.1.2.pack.js" type="text/javascript"></script>

<script language="javascript" type="text/javascript">
	$(function () {	 
				i = 0;			
			$("#addcompra").click(function(){
				i++;
				$.post("addvalor.php",{qtd:1,valor:<?php $valor = str_replace(",", ".", $oferta['valorpromocao']); echo $valor; ?>},function(date){
					
					if($.trim(date)!= ""){
						$("#compraredegraca").append($.trim('<input type="text"  class="input textfield" name="nome[]"><label class="valorsec"><?php  echo "<strong>R$ ". str_replace(".",",",$oferta['valorpromocao'])."</strong>"?></label><div onclick="javascript:remover();"  class="remcompra" border="0"> </div><br />'));
						$("#total").html("<strong class='comprar-preco'>Valor Total: R$ "+ date +"</strong>");
						$("#total2").html("<strong class='comprar-preco'>Valor Total: R$ "+ date +"</strong>");
						$("#qtd").val(<?php echo $_SESSION['qtd']?>);
					}else{
						alert("<?php echo utf8_encode("Limite de Compra de : ").$oferta['limite'] ?>")
					}
				});			
	});

});

	function remover() {		
		$.post("addvalor.php",{qtd:-1,valor:<?php $valor = str_replace(",", ".", $oferta['valorpromocao']); echo $valor;  ?>},				
		function(date){
			$("#total").html("<strong class='comprar-preco'>Valor Total: R$ "+ date +"</strong>");
			$("#total2").html("<strong class='comprar-preco'>Valor Total: R$ "+ date +"</strong>");
			$('#compraredegraca input:last').remove();
			$('#compraredegraca label:last').remove();
			$('#compraredegraca img:last').remove();
			$('#compraredegraca div:last').remove();
			$('#compraredegraca br:last').remove();
			$("#qtd").val(<?php echo $_SESSION['qtd']?>);
		});
}

function validanome(){
		if($.trim($("#nome").val()) == ""){
			alert("digite um nome!");
			return false;
		}

		return true;
	
}
</script>
<script> 
 	//mascara de campos
 $(document).ready(function(){
 	$("#telefone").mask("(99) 9999-9999"); 
	$("#cpf").mask("999.999.999-99");

	$("#comprarbtn2").click(function(){
		$("#nomecliente").submit();
   }); 
 
 });
	
</script>




</head>

<body>
<?php include('inc/topo.php'); ?>
<div id="main">
<div id="main-left">
	
   
    
    <div class="contorno-meio">
    <h2> Descrição:</h2>
    <h3><?php $ofetatxt = str_replace("[span]","<span>",$oferta['titulo']);
				$ofetatxt = str_replace("[/span]","</span>",$ofetatxt);
				 echo utf8_encode($ofetatxt); ?></h3><br /><br />
    <form id="nomecliente" action="registra_compra.php" method="post" onsubmit="return validanome();">
	                                      	 	<label class="label"> 
	                                      	 		<strong>Nome da pessoa que vai utilizar o Cupom</strong>	
                                           		</label>
                                           		<br />
  											
	   											<input type="text" class="input textfield" id="nome" name="nome[]">  <strong class="comprar-preco">R$ <?php $valor = str_replace(",", ".", $oferta['valorpromocao']); echo $valor; ?></strong>
	   											<input type="hidden" name="cliente" value="<?php echo $cliente['id']; ?>">
	   										 	<div id="compraredegraca">	</div>
												<div id="addcompra"></div>
												 <div>
                                                 <p><br />
												   <br />
												   <label id="total">
												     Valor Total:<span> R$ 
											         <?php $valor = str_replace(",", ".", $oferta['valorpromocao']); echo $valor;  ?>
												       </span>                                                    
											       </label>
												   <br /><br />
												   <label class="label">
												     Clicando em comprar você será redirecionado para o Pagseguro. Informe seus dados e forma de pagamento. Após confirmação de pagamento seu cupom estará disponível em sua conta. Para maiores esclarecimentos, acesse o suporte On-line.</label>
												   <input type="hidden" name="item_id_1" value="<?php echo $oferta['id']; ?> ">
												   <input type="hidden" name="item_frete_1" value="000"> 
												   <br />
	    </p>
        </div>
        <h2>Agendamento:<br />
        </h2>
        <p>Preencha os campos abaixo e escolha a melhor data para sua  pré-reserva. <strong class="verdelimao">ATENÇÃO</strong> a pré-reserva ficará disponível por no máximo 4 dias,  voltando a ficar disponível após esse prazo, caso não seja confirmado o  pagamento. Caso confirmado junto ao PagSeguro, sua reserva será efetivada de  fato. Há ainda possibilidade de alterar a data da reserva na &quot;Minha  Conta&quot; apenas no caso de haver vagas para outra data.</p>
<table width="100%" border="0">
          <tr>
            <td width="50%"><label class="label2">Telefone:</label>
            <input type="text" class="input textfield" id="telefone" name="telefone" /></td>
            <td width="50%"><label class="label2">CPF:</label>
                                                <input type="text" class="input textfield" id="cpf" name="cpf" /></td>
          </tr>
        </table>
        <h2>          <br />
        </h2>
        <table width="731" border="0" class="tabela-agendamento">
       
          <tr>
            <th width="100" scope="col">Status</th>
            <th width="200" scope="col">Entrada</th>
            <th width="200" scope="col">Saída</th>
            <th width="20" scope="col">Escolha</th>
          </tr>
          <?php 
          	$classspan = "";
          	$classtr = "";
          	$statusReseva = "";
          	foreach ($vagasHotel as $dadosvagasHotel){
          		
          			switch ($dadosvagasHotel['status']){
          				case 0:
          					$classspan = "";
          					$classtr ="tr-livre";
          					$statusReseva = "Livre";
          				break;
          				case 1:
          					$classspan = "reservado";
          					$classtr = "tr-reservado";
          					$statusReseva ="RESERVADO";
          				break;
          				case 2:
          					$classspan = "ocupado";
          					$classtr = "tr-ocupado";
          					$statusReseva = "OCUPADO";
          				break;
          			}
          ?>
          <tr class="<?php echo $classtr;?>">
            <td><span class="<?php echo $classspan;?>"><?php echo $statusReseva;?></span></td>
            <td><?php echo $objAgendaHotel->date_transform($dadosvagasHotel['data_entrada']);?></td>
            <td><?php echo $objAgendaHotel->date_transform($dadosvagasHotel['data_saida']);?></td>
            <td><?php if($statusReseva == "Livre"){?> <input value="<?php echo $dadosvagasHotel['id'];?>" type="checkbox" name="id[]" id="check001"/><?php } ?></td>
          </tr>
          <?php }?>
        </table>
        <h2>          <br />
        </h2>
        <div>
          <p><br />
            <br />
            <label id="total2"> Valor Total:<span> R$
              <?php $valor = str_replace(",", ".", $oferta['valorpromocao']); echo $valor;  ?>
            </span> </label>
            <br />
            <br />
            <label class="label"> Clicando em comprar você será redirecionado para o Pagseguro. Informe seus dados e forma de pagamento. Após confirmação de pagamento seu cupom estará disponível em sua conta. Para maiores esclarecimentos, acesse o suporte On-line.</label>
            <input type="hidden" name="item_id_2" value="<?php echo $oferta['id']; ?> " />
            <input type="hidden" name="item_frete_2" value="000" />
            <br />
          </p>
        </div>
        <h2>&nbsp; </h2>
        <div class="btn-comprar-2" id="comprarbtn2"><a href="#"></a></div><br />
										</form>
    </div>
</div> <!-- fim div main-left-->

<?php include('inc/direita-promocoes.php'); ?>
</div><!-- fim div main-->
<?php include('inc/footer.php'); ?> 
</body>
</html>