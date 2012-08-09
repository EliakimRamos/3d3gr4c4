<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>É de Graça - Administrativo</title>

<link rel="stylesheet" type="text/css" href="style/edegraca-sis.css"/>
</head>

<body>

<div id="topo"><div class="wrap">
<div id="logo"></div>
<div id="topo-login">
<span>Olá, <strong>André de Holanda</strong></span>
<div id="btn-sair"><a href="#"></a></div>
</div>
</div>
</div> <!--fim div topo-->

<div id="menucontainer">
<div id="menu">
	<ul>
    
    	<li><a href="#">Administrador</a>
        <ul>
            <li><a href="#">Listar</a></li>
            <li><a href="#">Cadastrar</a></li>
            
          </ul>
        </li>
    	
    	
    	<li><a href="#">Comercial</a>
        <ul>
            <li><a href="#">Listar</a></li>
            <li><a href="#">Cadastrar</a></li>
 
          </ul>
        </li>
    	<li><a href="#">Empresa</a>
          <ul>
            <li><a href="#">Listar</a></li>
            <li><a href="#">Cadastrar</a></li>
            
          </ul>
        </li>
   	  	<li><a href="#">Ofertas</a>
          <ul>
            <li><a href="#">Listar</a></li>
            <li><a href="#">Cadastrar</a></li>
            <li><a href="#">Agendar</a></li>
            
          </ul>
        </li>
        <li><a href="#">Cliente</a>
         <ul>
            <li><a href="#">Listar</a></li>
            <li><a href="#">Email</a></li>
            <li><a href="#">Cadastrar</a></li>
 
          </ul>
        
        </li>
    	<li><a href="#">Compradores</a>
         <ul>
         		<li><a href="#">Cadastrar</a></li>
         </ul>
        </li>
     </ul> 
</div> 
<!--fim div menu-->
</div><!-- fim div menucontainer-->

<div id="main">
<h1>Cadastrar / Editar Oferta</h1>
<form class="form_login" id="formOferta" method="post" enctype="multipart/form-data" action="controllers/Oferta.php">
<table width="100%" border="0" id="tabela-inserir-oferta">
  <tr>
    <td width="50%" height="0">
    <legend>Título:*</legend>
    <textarea rows="3" cols="9" name="titulo" class="textarea round5px" id="titulo"></textarea></td>
    <td width="50%" valign="top"><table width="100%" border="0">
      <tr>
        <td width="32%"><legend class="label">Cidades:*</legend>
            <select name="id_cidade_oferta[]" id="id_cidade_oferta" multiple="multiple" style="height: 145px" class="round5px">
              <option value="10"> Aracaju </option>
              <option value="5"> Belo Horizonte </option>
              <option value="12"> Brasília </option>
              <option value="3"> Fortaleza </option>
              <option value="15"> Goiânia </option>
              <option value="6"> João Pessoa </option>
              <option value="7"> Maceió </option>
              <option value="11"> Natal </option>
              <option value="14"> Porto Alegre </option>
              <option value="1"> Recife </option>
              <option value="13"> Rio de Janeiro </option>
              <option value="2"> Salvador </option>
              <option value="4"> São Luiz </option>
              <option value="9"> São Paulo </option>
              <option value="8"> Teresina </option>
            </select></td>
        <td width="68%"><legend> Posição:</legend>
            <select name="posicao" id="posicao" style="width: 130px;" class="round5px">
              <option value="" selected="selected"> Selecione a Posição</option>
              <option value="1"> Posição Destaque </option>
              <option value="2"> Bônus 1</option>
              <option value="3"> Bônus 2</option>
              <option value="4"> Bônus 3</option>
              <option value="5"> Bônus 4</option>
              <option value="6"> Bônus 5</option>
            </select>
            <br />
            <legend> Comercial:</legend>
              <select name="id_comercial" id="id_comercial" style="width: 150px;" class="round5px">
                <option value="" selected="selected"> Selecione o Vendedor</option>
                <option value="6"> bruno barros </option>
              </select>
              <legend class="label">Empresa:*</legend>
      <select name="id_empresa" id="id_empresa">
        <option value="" selected="selected">Selecione</option>
        <option value="11">Picanha do Futuro</option>
        <option value="51">Ancorar Flat resort </option>
        <option value="53">Spettus Boa viagem</option>
        <option value="54">Boi Preto</option>
        <option value="55">Guaimundo Bar e Restaurante</option>
      </select>
            </td>
      </tr>
    </table>
      </td>
  </tr>
  <tr>
    <td>
      
    </td>
    <td><input type="hidden" name="id" value="" />
      <input type="hidden" name="pac" value="oferta" />
      <input type="hidden" name="tela" value="oferta" />
      </td>
  </tr>
  <tr>
    <td colspan="2"><table width="100%" border="0">
      <tr>
        <td width="25%"><label>Valor Real:*</label>      <input type="text" id="valor" name="valor" class="textfield" value="0,00" /></td>
        <td width="25%"><label>% Desconto*</label><input type="text" id="desconto" name="desconto" class="textfield" value="" />
          <img src="img/Add-icon_peq.png" id="cal_desconto" title="Calcular Valores" alt="Calcular Valores" border="0" style="cursor:pointer;" /></td>
        <td width="25%"><label>Valor Promocional</label><input type="text" id="valorpromocao" name="valorpromocao" class="textfield" value="" />
          <img src="img/Add-icon_peq.png" id="cal_valor_promo" title="Calcular Valores" alt="Calcular Valores" border="0" style="cursor:pointer;" /></td>
        <td width="25%"><label class="label">Valor do Desconto:*</label>          <input type="text" id="valordesconto" name="valordesconto" readonly="readonly" class="textfield" value="" /></td>
      </tr>
      <tr>
        <td><label class="label">Mínimo:*</label>
          <input type="text" id="qtd_minima" name="qtd_minima" class="textfield" value="" /></td>
        <td><label class="label">Máximo:*</label>
          <input type="text" id="qtd_maxima" name="qtd_maxima" class="textfield" value="" /></td>
        <td><label class="label">Início:*</label>
          <input type="text" name="data_inicio" readonly="readonly" class="textfield" id="diainicil" value="//" /></td>
        <td><label class="label">Final:</label>
          <input type="text" name="data_final" readonly="readonly" class="textfield" value="//"id="dp1334151660315" /></td>
      </tr>
      <tr>
        <td><label class="label">Limite de presente:*</label>
          <input name="limite" type="text" class="textfield" id="limite" value="" /></td>
        <td><label class="label">Categoria:*</label>
          <select name="id_categoria" id="id_categoria">
            <option value="" selected="selected">Selecione</option>
            <option value="1"> Bar </option>
            <option value="2"> Beleza </option>
            <option value="3"> Cultura </option>
            <option value="4"> Curso </option>
            <option value="5"> Esporte </option>
            <option value="6"> Eventos </option>
            <option value="8"> Fashion </option>
            <option value="11"> Gastronomia </option>
            <option value="10"> Loja </option>
            <option value="9"> ServiÃ§o </option>
            <option value="7"> Turismo </option>
          </select></td>
        <td><label class="label">Validade do Cupom:*</label>
          <input type="text" name="data_validade" readonly="readonly" class="textfield" value="//" id="dp1334151660316" /></td>
        <td><label class="label">Percentual Acordado:*</label>
          <input name="lucro" type="text" class="textfield" id="lucro" value="" /></td>
      </tr>
    </table></td>
    </tr>
  <tr>
    <td colspan="2"><table align="center">
      <tbody>
        <tr>
          <td><input type="file" id="arquivo" name="arquivo" value="" /></td>
          <td><input type="file" id="arquivo1" name="arquivo1" value="" /></td>
          <td><input type="file" id="arquivo2" name="arquivo2" value="" /></td>
        </tr>
      </tbody>
    </table></td>
  </tr>
  <tr>
    <td colspan="2"><label class="label">Descrição:</label>
      <textarea name="descricao" cols="59" rows="15" class="textarea" id="descricao"></textarea></td>
  </tr>
  <tr>
    <td colspan="2"><label class="label">Regulamento:</label>
      <textarea name="regras" cols="59" rows="15" class="textarea" id="regras"></textarea></td>
  </tr>
  <tr>
    <td colspan="2" align="center"><input type="submit" name="op" id="op" value="Inserir" /></td>
  </tr>
</table>
</form>

</div> <!--fim div main-->

</body>
</html>