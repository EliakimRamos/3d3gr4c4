<?php session_start();
require_once("administrator/models/Base.php");
require_once("administrator/models/Cliente.php");
require_once ("administrator/models/Oferta.php");
$objCliente = new Cliente();
$cidadeslist = $objCliente->listaEstado();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>&Eacute; de Gra&ccedil;a</title>

<?php include('inc/header.php'); ?>
	<link rel="stylesheet" type="text/css" href="css/edegraga.css"/>
	<!--<script type="text/javascript" src="js/jquery-1.4.2.min.js"	charset="iso-8859-1"></script>-->
	<script language="JavaScript" type="text/javascript"	src="js/jquery.readonly.js"></script>
	<script language="JavaScript" type="text/javascript"	src="js/jquery.maskedinput-1.1.2.pack.js"></script>
	<script language="JavaScript" type="text/javascript"	src="js/jquery.validate.js"></script>
	<script language="JavaScript" type="text/javascript">
  		$(document).ready(function(){
				// CONFIGURA A VALIDACAO DO FORMULARIO
				$("#cadastro").validate({
					rules: {
						nome : {required: true},
						email : {required: true, email: true},
						confemail:{required: true, email: true, equalTo:"#email"},
						senha : {required: true},
						confsenha : {required: true, equalTo: "#senha"},
						captcha : {required: true}
					},
					messages: {
						nome: {required: 'Campo Obrigatório'},
						email: {required: 'Campo Obrigatório', email: 'E-mail Inválido'},
						confemail: { required:"Campo Obrigatório", email: 'E-mail Inválido', equalTo:"Os E-mails tem que ser Identicos"},
						senha: {required: 'Campo Obrigatório'},
						confsenha: {required: 'Campo Obrigatório', equalTo: "As Senhas tem que ser Id&ecirc;nticas"},
						captcha: {required: 'Campo Obrigatório'}
					}
					,submitHandler:function(form) {
						form.submit();
					}
				});
				$("#btncadastrar").click(function(){
					$("#cadastro").submit();
				});
				$("#email").blur(function(){
					$.post("verificaemail.php",{email: $("#email").val()},
							function(date){
								
								if($.trim(date) != ""){
									var newdados = date.split('*');
									$("#confemail").val(newdados[0]);
									$("#cod_estado").val(newdados[1]);
									$("#cod_cidade").val(newdados[2]);
								}
							}
					);
				});
				$("#nome").blur(function(){
					$.post("verifica2nome.php",{nomecompleto:$("#nome").val()},
							function(data){
								$("#mensagem").html(data);
								if(data !=""){
									alert(data);
								}
							})
				});
				
				$.post("getcidades.php",{cod_estado:$("#cod_estado").val()},
			      function(data){
			      		$("#cod_cidade").html(data);
			      });


			$("#cod_estado").change(function(){
					$.post("getcidades.php",{cod_estado:$("#cod_estado").val()},
					      function(data){
					      		$("#cod_cidade").html(data);
					      });
				}); 
				
			});  		
	</script>  
</head>

<body>
<?php include('inc/topo.php'); ?>
<div id="main">
<div class="main">
<div class="padding10">
<span  id="mensagem" style="color: #FFFFFF; display: block; font-size: 12px; padding: 0 0 5px;">
	<?php echo $_SESSION['alert']; $_SESSION['alert'] = "";?>
</span>
  <form action="administrator/controllers/Cliente.php" method="post" name="cadastro" id="cadastro">
  <input type="hidden" name="pac" value="cliente" /> 
  <input type="hidden" name="op" id="op" value="Inserir" /> 
  <input type="hidden" name="tela" value="cliente" />
  <input type="hidden" name="id" id="id" value="" />
  
  <div id="form-col-1">
  <legend>Nome e Sobrenome:</legend>
<input tabindex="1" name="nome" id="nome" type="text" class="textfield"/> 
<legend>Confirmação de E-mail:</legend>
<input tabindex="3" name="confemail" id="confemail" type="text" class="textfield" value="<?php echo $_SESSION['emailprecadastro'];?>"/>
<legend>Confirmação de Senha:</legend>
<input tabindex="5" name="confsenha" id="confsenha" type="password" class="textfield"/>
<label>Escolha sua Cidade:</label>
  <br />
  <select name="cidade" id="cod_cidade" style="display: inline-block; " class="form-modal-select radius5">
    <option value="">Selecione</option>
    
  </select>
</div>
  <div id="form-col-2"><legend>E-mail:</legend>
<input tabindex="2" name="email" id="email" type="text" class="textfield" value="<?php echo $_SESSION['emailprecadastro'];?>"/> 
<legend>Senha:</legend>
<input tabindex="4" name="senha" id="senha" type="password" class="textfield"/>
<label>Estado:</label>
  <br />
  <select name="estado" id="cod_estado" class="form-modal-select estado radius5">
    <option value="0">Selecione</option>
    <?php foreach($cidadeslist as $dadoscidade){ ?>
    		<option value="<?php echo $dadoscidade->uf_codigo;?>" <?php if($dadoscidade->uf_codigo == $_SESSION['estadoprecadastro']){ echo "selected=selected";}?>><?php echo $dadoscidade->uf_sigla;?></option>
    <?php } ?>
  </select>
<legend>Digite o código abaixo:</legend>
<img src="administrator/view/captcha/captcha.class.php" id="captcha3" width="150" height="32" title="Validação" alt="Validação">
<div style="float:right; margin-right:11px; padding-bottom:25px;">
<a href="#atualizar" onClick="javascript: document.getElementById('captcha3').src = 'administrator/view/captcha/captcha.class.php?' + Math.random() ">
<img src="administrator/view/captcha/images/update.png" name="captcha" width="18" height="18" border="0" align="left" id="captcha2"></a>
<input tabindex="6" name="captcha" id="captcha" type="text" class="textfield"/>
</div></br>
</div>
<input type="checkbox" id="newsletter" name="receber_news" value="sim" checked="checked"><label class="label01"> Aceito receber newsletter das promoções</label><br />
<input type="checkbox" id="oktermo" name="oktermo" value="sim" checked="checked"><label class="label01"> Li e aceito os <a href="termosuso.php" target="_blank">termos de uso</a></label><br /><br />
<div class="btn-cadastrar" id="btncadastrar"><a href="#"></a></div>
</form>
</div>
</div>
</div><!-- fim div main-->
<?php include('inc/footer.php'); ?> 
</body>
</html>