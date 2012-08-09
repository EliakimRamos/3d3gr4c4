<?php session_start();

require_once("models/Base.php");
require_once("models/Paginacao.php");
require_once("models/Login.php");
require_once("models/Oferta.php");
require_once("models/Funcoes.php");
require_once("models/Empresa.php"); 

$login = new Login();
$oferta = new Oferta();
$fucoes = new Funcoes();
$empresa = new Empresa();
$confirmacao = $login->verificar();
if($confirmacao == false){
	header("location:../../entrar.php");	
}
$dadosOfertas = $oferta->listarOferta3("");
?>
<h3 class="titulo">Relatório</h3>
<div class="corpo"><span class="mensagem" id="mensagem"> <?php if($_SESSION['alert'] != ""){echo $_SESSION['alert']; $_SESSION['alert'] = "";}?></span>

<table align="center">
	<tr>	
			<td align="right">
				<label class="label">Promoção: </label>
			</td>
			<td align="left">
				
				  <select id="oferta" name="id_fornecedor" style="width:300px">
				    <option value="">Selecione Promoção</option>
				    <?php 
				    	foreach($dadosOfertas as $dadosOfert){
				    	?>
				    		<option value="<?php echo $dadosOfert['id']?>"> <?php echo $dadosOfert['titulo'] ?></option>
				    	<?php
				    	}
				    
				    ?>
				  </select>
  
			</td>
	</tr>
   <tr>
   		<td colspan="2">
   			<div id="lista"></div>
   		</td>
   </tr>
</table>

<br>

</div>
<script language="JavaScript" type="text/javascript">
  $(function(){
  		$("#oferta").change(function(){
  			
  			$.post("view/relatorio/listagemPag.php",{id_oferta:$("#oferta").val()},function(data){
  							$("#lista").html(data);
  			})
  		})
  });
</script>
  