<?php
$parcela = $_POST['parcela'];
$valor = $_POST['valor'];
//$valor[] = $_POST['valor'];
$entrada= $_POST['entrada'];
$idparcela = $_POST["idparcela"];
$formapg = $_POST["formapg"];
//var_dump($_POST);die;
	if($entrada != ""){
		$valor = str_replace(",",".",$valor);
		$entrada = str_replace(",",".",$entrada);
		//var_dump(floatval($valor));die;
		$valor = floatval($valor) - floatval($entrada);
		
		}
	if (!empty($parcela)){
		$valor = $valor / $parcela;
		}
	else{
		echo "";
		}

$conteudo = ''; //$idparcela
	if($parcela > 100){
		echo "Você não pode dividir";
	}else{
		for ($i = 1; $i <= $parcela; $i++) {
    		$conteudo .=$i."&deg;"." "." Parcela&nbsp;&nbsp;<input type='text' class='valor' id='".$i."' value='".number_format($valor,2,",","")."' onblur='javascript:recalcular(".$i.")' name='valor_parcela[]'/>";
    		$conteudo .="<input type='hidden' class='idparcela2' value='".$idparcela."' name='id_parcela[]' />"; 
			if($formapg == 3){
				$conteudo .="Banco: <input type='text' value='".$banco."' name='' />";
				$conteudo .="N&uacute;mero: <input type='text' value='".$numcheque."' name=''/>";
				$conteudo .="Vencimento: <input type='text' class='datepicke' value='".$vencheque."' name=''/><br>";
			}else{
				$conteudo .="<br>";
			}
		}
		$conteudo.="<input type='hidden' name='qtd_parcela' value='$parcela' />";
  	echo $conteudo;
	}
?>
<script language="JavaScript" type="text/javascript">
   $(".valor").maskMoney({decimal:",",thousands:""});
   
   
   function recalcular(idvalorparcela){
   		var entrada = <?php echo $entrada?>;
   		var valor_receber = parseFloat($("#valorareceber").val());
   		var parcela = <?php echo $parcela?>;
   		var valor_recalculado = "";
   		
   		valor_recalculado = (valor_receber - entrada);
   		
   		valor_recalculado = valor_recalculado - parseFloat($("#"+idvalorparcela).val());
   		valor_recalculado = valor_recalculado/ (parcela - 1);
   		idvalorparcela = idvalorparcela+1;
   		//alert(valor_recalculado);
   		$("#idvalorparcela").val(valor_recalculado);
   		
   }
   
   $(function(){
	
	$('.datepicke').datepicker({
			changeMonth: true,
			changeYear: true
		});
});
</script>  
