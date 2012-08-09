<?php
session_start();
require ("administrator/models/Base.php");
require ("administrator/models/Cliente.php");
require ("administrator/models/Oferta.php");
require ("administrator/models/Empresa.php");
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
	
    
    
    <div class="contorno-meio">
    <h2> Como COMPRAR:</h2>
    <p>Se cadastre  no site</p>
    <ol>
      <li>Caso já  tenha cadastro, faça seu login.</li>
      <li>Ler  atentamente a descrição e as regras da promoção que pretende comprar.</li>
      <li>Clicar no  botão<strong> <br />
        </strong>
        <div class="btn-comprar"><a href="#"></a></div>
        da oferta desejada. (É  necessário estar logado para efetuar uma compra).</li>
      <li>Preencher o  campo com o nome da pessoa que vai utilizar o cupom.</li>
      <li>Caso queira  comprar mais cupons, adicione-os clicando no botão <br />
        <div id="addcompra"></div>
        <br />
         Preencher também o nome das pessoas que irão  utilizar os cupons extras.</li>
      <li>Após  confirmar os nomes clique em<br />
        <br />
        <div class="btn-comprar"><a href="#"></a></div>
        Você será direcionado ao site do  PagSeguro para efetuar seu pagamento.</li>
      <li>Preencha  todos os campos solicitados.</li>
      <li>Escolha a  forma de pagamento.</li>
      <ol>
        <li>Nas compras  realizadas no Boleto Bancário, os cupons só estarão disponíveis após a sua  compensação, que ocorrerá até 3 dias úteis.</li>
        <li>Por questões de segurança ao utilizar cartão de  crédito, informe com antecedência a operadora, caso o valor da compra seja  elevado. </li>
        <li>O comprovante de pagamento do PagSeguro não terá  validade no estabelecimento. Siga as instruções a seguir.</li>
      </ol>
    </ol>
    <p>&nbsp;</p>
    <h2>Como Imprimir Seu Cupom?</h2>
    <ol>
      <li>Clique em  Login. Insira seus dados corretamente. Clique em Enviar.</li>
      <li>Clique em  Minha Conta</li>
      <li>Clique em Meus  Cupons. Será listado todos os cupons adquiridos.</li>
      <li>Clicar no  botão imprimir. </li>
    </ol>
    </div>
    
    
    
    
    
</div> <!-- fim div main-left-->

<?php include('inc/direita-promocoes.php'); ?>
</div><!-- fim div main-->
<?php include('inc/footer.php'); ?> 



</body>
</html>