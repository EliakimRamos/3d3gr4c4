<?php
session_start();
require ("administrator/models/Base.php");
require ("administrator/models/Cliente.php");
require ("administrator/models/Oferta.php");
require ("administrator/models/Empresa.php");
require ("administrator/models/OfertaCliente.php");
if(!$_SESSION['cliente']){
	echo"<script>window.location='login.php'</script>";
	die;
}
$objCliente = new Cliente();
$objofertacliente = new OfertaCliente();
$objOferta = new Oferta();
$cliente = $objCliente->getCliente($_SESSION['idclientek'],'id');
$qtdCupons = $objCliente->getqtdCupons($_SESSION['idclientek']);
$listaofertas = $objofertacliente->listarOfertaCliente2(" and id_cliente=".$_SESSION['idclientek']." and comprou <> 0");
$totaleconomizado = 0;
					if(!empty($listaofertas)){
						foreach ($listaofertas as $dados1){	
							if($dados1['comprou'] == 1 && $dados1['ativo'] == 1){		
							 	$valordesconto = $objOferta->getOferta($dados1['id_oferta'],"id");
							 	$totaleconomizado = $totaleconomizado + $valordesconto['valordesconto'];
							}	
						}
					}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include('inc/header.php'); ?>
<script>
	$(function(){
		$("#atualizar-senha").click(function(){
			$("#form_senha").submit();
		});
		$("#atualizar-dados").click(function(){
			$("#form-dados").submit();
		});
		
	});
	$(document).ready(function(){
				// CONFIGURA A VALIDACAO DO FORMULARIO
				$("#form_senha").validate({
					rules: {
						senha : {required: true},
						novasenha2 : {required: true, equalTo: "#senha"},
						senhaantiga : {required: true}
					},
					messages: {
						senha: {required: 'Campo Obrigatório'},
						novasenha2: {required: 'Campo Obrigatório', equalTo: "As Senhas tem que ser Id&ecirc;nticas"},
						senhaantiga: {required: 'Campo Obrigatório'}
					}
					,submitHandler:function(form) {
						form.submit();
					}
				});
				$("#form-dados").validate({
					rules: {
						nome : {required: true},
						email : {required: true, email: true},
						data_nascimento:{required: true}
					},
					messages: {
						nome: {required: 'Campo Obrigatório'},
						email: {required: 'Campo Obrigatório', email: 'E-mail Inválido'},
						data_nascimento: {required: 'Campo Obrigatório'}
					}
					,submitHandler:function(form) {
						form.submit();
					}
				});
				
			});
</script>
</head>

<body>
<?php include('inc/topo.php'); ?>
<div id="main">
<div id="main-left">
	
    <?php $menu = "dados"  ?>
   <?php include('inc/menu-minhaconta.php'); ?>
   
    <div class="contorno-meio">
    <h4>Dados Cadastrais</h4>
    <form action="administrator/controllers/Cliente.php" method="post" id="form-dados">
     <input type="hidden" name="id" value="<?php  echo $cliente["id"]; ?>"/>
     <input type="hidden" name="op" value="Editar"/>
     <input type="hidden" name="tela" value="cliente"/>
     
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabelas">
  <tr>
    <td><legend>Nome:</legend>
<input tabindex="1" name="nome" id="nome" type="text" class="textfield" value="<?php echo $cliente["nome"]; ?>"/></td>
<td><legend>Data de Nascimento:</legend>
<input tabindex="2" name="data_nascimento" id="data_nascimento" type="text" class="textfield" value="<?php echo $objCliente->date_transform($cliente["data_nascimento"]); ?>"/></td>
  </tr>
  <tr>
    <td><legend>E-mail:</legend>
<input tabindex="3" name="email" id="email" type="text" class="textfield" value="<?php echo $cliente["email"]; ?>"/></td>
    <td><legend>Cidade:</legend><select name="7" class="styled-select">
					<option value="1">Recife</option>
					<option value="2">João Pessoa</option>
					<option value="3">Natal</option>
			</select></td>
  </tr>
  <tr>
    <td><legend>Telefone:</legend>
<input tabindex="4" name="fone" id="fone" type="text" class="textfield" value="<?php echo $cliente["fone"]; ?>"/></td>
    <td><legend>Sexo:</legend>
      <table width="200">
        <tr>
          <td><label>
            <input type="radio" name="Sexo" value="Masculino" id="Sexo_0" />
            Masculino</label></td>
        </tr>
        <tr>
          <td><label>
            <input type="radio" name="Sexo" value="Feminino" id="Sexo_1" />
            Feminino</label></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td><input name="aceito receber" type="checkbox" value="Aceito receber" checked="checked" />
    Aceito receber promoções no meu e-mail.</td>
    <td><div class="btn-atualizar" id="atualizar-dados"></div></td>
  </tr>
</table>
 </form> <br />
<br />
<form action="administrator/controllers/Cliente.php" id="form_senha" method="post">
  <input type="hidden" name="op" value="Editar"/>	
  <input type="hidden" name="id" value="<?php  echo $cliente["id"]; ?>"/>
  <input type="hidden" name="tela" value="cliente"/>
  <input type="hidden" name="nome" value="<?php echo $cliente["nome"]; ?>"/>
  
  
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabelas">
  <tr>
    <td><legend>Nova Senha:</legend>
<input name="senha" id="senha" type="password" class="textfield"/></td>
    <td><legend>Repita Nova Senha:</legend>
<input name="novasenha2" id="novasenha2" type="password" class="textfield"/></td>
  </tr>
  <tr>
    <td><legend>Senha Antiga:</legend>
<input name="senhaantiga" id="senhaantiga" type="password" class="textfield"/></td>
    <td><div class="btn-atualizar" id="atualizar-senha"></div></td>
  </tr>
</table>

</form>
	</div> <!-- fim contorno-meio -->
 
</div> <!-- fim div main-left-->

<?php include('inc/direita-promocoes.php'); ?>
</div><!-- fim div main-->
<?php include('inc/footer.php'); ?> 



</body>
</html>