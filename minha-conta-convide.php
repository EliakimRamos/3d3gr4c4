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

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include('inc/header.php'); ?>
</head>

<body>
<?php include('inc/topo.php'); ?>
<div id="main">
<div id="main-left">
	
    <?php $menu = "convide"  ?>
   <?php include('inc/menu-minhaconta.php'); ?>
   
    <div class="contorno-meio">
    <h4>Convide Amigos</h4>
    <form action="#">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabelas">
  <tr>
    <td><legend>Copie e Cole para seus amigos:</legend>
<input tabindex="1" name="codigouser" id="codigouser" type="text" class="textfield" value="http://www.edegraca.com.br/132909daasde" readonly="readonly" /></td>
    <td>             </td>
  </tr>
</table>
 </form> <br />
<br />
<h4>Convidar informando o E-mail dos Amigos.</h4>
<form>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabelas">
  <tr>
    <td><legend>Nome:</legend>
<input name="nome" id="nome" type="text" class="textfield"/></td>
    <td><legend>Email:</legend>
<input name="email" id="email" type="text" class="textfield"/></td>
  </tr>
  <tr>
    <td><legend></legend>
      <p>&nbsp;</p></td>
    <td><div class="btn-enviar"></div></td>
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