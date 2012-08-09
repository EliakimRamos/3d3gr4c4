<?php
/*
 * Created on 20/07/2010
 */
 
 require_once("../../models/Base.php");
 require_once("../../models/Paginacao.php");
 require_once("../../models/Contareceber.php");
 require_once('../../models/Login.php');
 require_once('../../models/Cliente.php');
 
 
 $contareceber = new Contareceber();
 $cliente = new Cliente();
 $nomecliente = utf8_decode($_POST['nomecliente']);
 $contarecebe = $contareceber->filtrocliente($nomecliente);
 //var_dump($contarecebe); die; 
 ?>
  <table class="table">
    <tr class="column1_titulo">
      <th>
  			<input type="checkbox" name="selecionatodos"  id="selecionatodos"  />
  	  </th>
  	 	 <th>N&deg; documento</th>	
 		 <th>Cliente</th>
 		 <th>Vencimento</th>
 		 <!--<th>Parcela</th>-->
 		 <th>Forma de Pagamento</th> 		 
 		 <th>Situa&ccedil;&atilde;o</th>
 		<!-- <th>Valor Parcela</th>-->
 		 <th>Valor total Cobrado</th>
 		 <th><?php echo "A&ccedil;&atilde;o";?></th>
    </tr>
    <?php if ($contarecebe==""){
		echo "N&atilde;o existe Conta a Receber";
		exit;
    }?>	
 <?php 
 $total=0;
 foreach($contarecebe as $dados){
 	
 ?>
    <tr>
      <td>
  			<input type="checkbox" name="id[]" class="checkbox" value="<?php echo $dados['id_contareceber'];?>"/>
  
 	 </td>
	      <td><?php echo $dados['numdoc'];?></td>
	      <td><?php  $respcliente = $cliente->getCliente($dados['id_cliente'],'id_cliente'); echo utf8_encode($respcliente['nome'])?></td>
	      <?php

	if (empty ($dados['vencimentoC']) || $dados['vencimentoC'] == "0000-00-00" || !empty ($dados['vencimentP'])) {
		$data_vencimento = $contareceber->date_transform($dados['vencimentP']);
	} else
		if ( !empty ($dados['vencimentoC'])) {
			$data_vencimento = $contareceber->date_transform($dados['vencimentoC']);
		} else {
			$data_vencimento = "Error na data";
		}
?>
		<td><?php echo $data_vencimento;?></td>
		<!--<td><?php echo $dados['numParcela']."/".$dados['qtd_parcela'];?></td>-->
	      <td><?php $respformapg = $contareceber->getFormapg($dados['id_formapg'],'id_formapg'); echo utf8_encode($respformapg['descricao']);?></td>
	      <?php if(empty($dados['statusC'])){
				$status = "0000-00-00";
			  }else {
			  	$status = $dados['statusC'];
			  }?>
	      <td>
	      	<?php $respsituacao = $contareceber->getSituacao($dados['id_situacao'],'id_situacao'); 
	      			echo $respsituacao['descricao'];
	      	?>
	      </td>
	      <?php  	$valorParcela = $dados['valorparcela']; ?>
	      <!--<td>R$ <?php echo number_format($valorParcela,2,',','.');?> -->
	      <?php  	$valor = $dados['valorareceber']; ?>
	      <td>R$ <?php echo number_format($valor,2,',','.');?>
          <?php $total=$total+$valor;?>
          </td><td>
  			
  			<a href="?pac=contareceber&tela=contareceberForm&op=Editar&i=<?php echo $dados['id_contareceber'];?>" id="edit"><img title="Editar" src="img/editar.png" width="31" height="35" border="0"></a> 
  	</td>
   </tr>
<?php }?>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td height="35"><b>Total:</b></td>
      <td>R$ <?php echo number_format($total,2,',','.');?></td>
      <td>&nbsp;</td>
    </tr>