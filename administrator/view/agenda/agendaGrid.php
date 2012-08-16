<?php
session_start();

require_once("models/Base.php");
require_once("models/Paginacao.php");
require_once("models/Login.php");
require_once("models/Agendahotel.php");

$objlogin = new Login();
$confirmacao = $objlogin->verificar();
if($confirmacao == false){

	header("location:../../entrar.php");
}

$objAgenda = new Agendahotel();

$resposta = $objAgenda->listarAgendahotel2();
$varAgenda = $resposta['agenda'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>É de Graça - Administrativo</title>

<link rel="stylesheet" type="text/css" href="style/edegraca-sis.css"/>
</head>

<body>

<div id="main">
<h1>Datas para Agendamento</h1>
<!--<div id="filtroCliente">
	  		
						<form action="index.php?pac=cliente&amp;tela=clienteGrid" name="filtros" method="get">   
				     		<span class="label">Digite Nome do Cliente:</span> 
			  				<input type="text" name="pesquisa" id="pesquisa" value="" class="pesquisa round5px">	
                            
                            <div id="btns-editores">
                        <div class="btn-desativar"></div><div class="btn-apagar"></div><div class="btn-inserir"></div>
                        
                        </div>
			     		</form>
                        
                        
                        
</div>-->

<table width="100%" class="table">

<form action="controllers/Agendahotel.php" method="post" id="formAgenda"></form>
  <input type="hidden" name="op" value="Deletar">
  <input type="hidden" name="tela" value="agenda">
  <input type="hidden" name="pac" value="agenda">
    <tbody><tr class="column1_titulo">
      <th>
  			<input type="checkbox" name="selecionatodos" id="selecionatodos">
  	  </th>  
 		 <th>Data de Entrada</th>
 		 <th>Data de Saida</th>
 		 <th>Status</th>
 		 <th>Hotel</th>
 		 <th>Cliente</th>
		 <th>Ação</th>
    </tr>
     <tr>
      <td>
  			<input type="checkbox" name="id[]" class="checkbox" value="6060">  
 	 </td>
      <td>A</td>
	  <td>Não	  </td>
	  <td>Sim	  </td>	  
	  <td>arthuh@gmail.com</td>
	  <td>(81) 8888-8888</td>
	  <td>	
  				<div class="btn-editar">		
  				<a href="?pac=cliente&amp;tela=clienteForm&amp;op=Editar&amp;i=6060" id="edit"></a></div>
  			 
  	  </td>
    </tr>
       <tr>
      <td>
  			<input type="checkbox" name="id[]" class="checkbox" value="5883">  
 	 </td>
      <td>Aída</td>
	  <td>Sim	  </td>
	  <td>Sim	  </td>	  
	  <td>aidaalcoforado@hotmail.com</td>
	  <td>(81) 8775-5541</td>
	  <td><div class="btn-editar"> <a href="?pac=cliente&amp;tela=clienteForm&amp;op=Editar&amp;i=6060" id="edit2"></a></div></td>
    </tr>
       <tr>
      <td>
  			<input type="checkbox" name="id[]" class="checkbox" value="5051">  
 	 </td>
      <td>Abdon De Arruda Ricardo</td>
	  <td>Não	  </td>
	  <td>Sim	  </td>	  
	  <td>abdonarruda@hotmail.com</td>
	  <td>(81) 9292-2201</td>
	  <td><div class="btn-editar"> <a href="?pac=cliente&amp;tela=clienteForm&amp;op=Editar&amp;i=6060" id="edit3"></a></div></td>
    </tr>
       <tr>
      <td>
  			<input type="checkbox" name="id[]" class="checkbox" value="6440">  
 	 </td>
      <td>Abelardo Jose Vareda Lapenda Filho</td>
	  <td>Sim	  </td>
	  <td>Sim	  </td>	  
	  <td>abelardo.lapenda@ati.pe.gov.br</td>
	  <td>(81) 9812-3254</td>
	  <td><div class="btn-editar"> <a href="?pac=cliente&amp;tela=clienteForm&amp;op=Editar&amp;i=6060" id="edit4"></a></div></td>
    </tr>
       <tr>
      <td>
  			<input type="checkbox" name="id[]" class="checkbox" value="5747">  
 	 </td>
      <td>Aberides Nicéas De Albuquerque Neto</td>
	  <td>Não	  </td>
	  <td>Sim	  </td>	  
	  <td>netoniceas@yahoo.com.br</td>
	  <td>(81) 9635-7734</td>
	  <td><div class="btn-editar"> <a href="?pac=cliente&amp;tela=clienteForm&amp;op=Editar&amp;i=6060" id="edit5"></a></div></td>
    </tr>
       <tr>
      <td>
  			<input type="checkbox" name="id[]" class="checkbox" value="883">  
 	 </td>
      <td>Abilio Guedes Mariz</td>
	  <td>Não	  </td>
	  <td>Sim	  </td>	  
	  <td>abiliogm@oi.com.br</td>
	  <td>(81) 9679-0478</td>
	  <td><div class="btn-editar"> <a href="?pac=cliente&amp;tela=clienteForm&amp;op=Editar&amp;i=6060" id="edit6"></a></div></td>
    </tr>
       <tr>
      <td>
  			<input type="checkbox" name="id[]" class="checkbox" value="4916">  
 	 </td>
      <td>Abinael</td>
	  <td>Sim	  </td>
	  <td>Sim	  </td>	  
	  <td>abinael_ufrpe@yahoo.com.br</td>
	  <td>(81) 8640-6126</td>
	  <td><div class="btn-editar"> <a href="?pac=cliente&amp;tela=clienteForm&amp;op=Editar&amp;i=6060" id="edit7"></a></div></td>
    </tr>
       <tr>
      <td>
  			<input type="checkbox" name="id[]" class="checkbox" value="2802">  
 	 </td>
      <td>Abner Christiano</td>
	  <td>Sim	  </td>
	  <td>Sim	  </td>	  
	  <td>abnerchristiano@hotmail.com</td>
	  <td>(81) 8712-2778</td>
	  <td><div class="btn-editar"> <a href="?pac=cliente&amp;tela=clienteForm&amp;op=Editar&amp;i=6060" id="edit8"></a></div></td>
    </tr>
       <tr>
      <td>
  			<input type="checkbox" name="id[]" class="checkbox" value="4210">  
 	 </td>
      <td>Abraao Lincoln</td>
	  <td>Não	  </td>
	  <td>Sim	  </td>	  
	  <td>lincoln30h@gmail.com</td>
	  <td>(81) 8821-2889</td>
	  <td><div class="btn-editar"> <a href="?pac=cliente&amp;tela=clienteForm&amp;op=Editar&amp;i=6060" id="edit9"></a></div></td>
    </tr>
       <tr>
      <td>
  			<input type="checkbox" name="id[]" class="checkbox" value="2644">  
 	 </td>
      <td>Abrao Krym</td>
	  <td>Não	  </td>
	  <td>Sim	  </td>	  
	  <td>krym@uol.com.br</td>
	  <td>(81) 9913-1010</td>
	  <td><div class="btn-editar"> <a href="?pac=cliente&amp;tela=clienteForm&amp;op=Editar&amp;i=6060" id="edit10"></a></div></td>
    </tr>
      
  </tbody></table>

</div> <!--fim div main-->

</body>
</html>