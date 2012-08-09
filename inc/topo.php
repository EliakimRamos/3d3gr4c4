<?php 
$objCliente = new Cliente();
$objOferta = new Oferta();
$cidadeslist = $objCliente->listaEstado();
$oferta1 = $objOferta->listarOferta(" and ativa = 1 ");
$cidadestopolistforletra = $objOferta->listacidadeporletra("r");
?>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/pt_BR/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
$(function(){
	$("#logo").css("cursor","pointer");
	$("#logo").click(function(){
		window.location="index.php";
	});
	$("#btn-ok-newsletter").click(function(){
		if($.trim($("#newsletter-txtfield").val()) != ""){
			if(validar_mail($("#newsletter-txtfield").val())){
				$.post("cadastranews.php",{newsletter:$("#newsletter-txtfield").val()},
					function(date){
						if(date){
							$("#newsletter-txtfield").val("");
							alert("E-mail cadastrado, em breve você estara recebendo nossas ofertas");
						}else{
							alert("erro no envio dos dados");
						}
					}
				);
			}else{
				alert("digite um email válido");
			}
		}else{
			alert("Este campo não pode ser Vazio");
		}
	})
	
	$("#modal-btn").click(function(){
		if($.trim($("#email2").val()) != "" && $.trim($("#cod_estados").val()) != "" && $.trim($("#cod_cidades").val()) != ""){
			if(validar_mail($("#email2").val())){
				$.post("cadastranews.php",{newsletter:$("#email2").val(), estado:$("#cod_estados").val(),cidade:$("#cod_cidades").val()},
					function(date){
						if(date){
							    	$.post("cadastro-modal.php",{emailmodal:$("#email2").val(), estadomodal:$("#cod_estados").val()}, 
									function(date){
										$("#modal").html(date);
									});
						}else{
							alert("erro no envio dos dados");
						}
					}
				);
			}else{
				alert("digite um email válido");
			}
		}else{
			alert("Estes campos não podem ser Vazios");
		}
	})
	
});


function validar_mail(strEmail){
	var er = /^[a-zA-Z0-9][a-zA-Z0-9\._-]+@([a-zA-Z0-9\._-]+\.)[a-zA-Z-0-9]{2}/;
		
		//testar o regexp. Se der certo, retorna true
		if((strEmail != "") && (er.test(strEmail))){
			return true;
		}
		
		//se chegar aqui é porque não é válido
		return false;
}


// cidades 

function filtrocidade(letra){
	$.post("inc/filtrocidade.php",{letracidadefiltro:letra},
		function(data){
			$("#ul-lista-cidades").html(data);
		}
	);
}

</script>



</div>


<div id="modal-cidades" style="display:none">
  <div class="padding10">
    <div id="mod-cidades-top">
      <div>
        <h1>Escolha sua cidade:</h1>
      </div>
      <div id="form-busca-mod-cidades">
        <!-- 
<form>
<input name="busca-cidade" type="text" id="busca-cidade" class="radius5" value="Encontre sua cidade" title="Encontre sua cidade" />
<input name="btn-buscar-cidade" type="image" src="images/cidades-busca.png" id="btn-lupa"/>
</form> 
-->
      </div>
    </div>
    <ul id="alfabeto">
      <li><a href="javascript:filtrocidade('a');">A</a></li>
      <li><a href="javascript:filtrocidade('b');">B</a></li>
      <li><a href="javascript:filtrocidade('c');">C</a></li>
      <li><a href="javascript:filtrocidade('d');">D</a></li>
      <li><a href="javascript:filtrocidade('e');">E</a></li>
      <li><a href="javascript:filtrocidade('f');">F</a></li>
      <li><a href="javascript:filtrocidade('g');">G</a></li>
      <li><a href="javascript:filtrocidade('h');">H</a></li>
      <li><a href="javascript:filtrocidade('i');">I</a></li>
      <li><a href="javascript:filtrocidade('j');">J</a></li>
      <li><a href="javascript:filtrocidade('k');">K</a></li>
      <li><a href="javascript:filtrocidade('l');">L</a></li>
      <li><a href="javascript:filtrocidade('m');">M</a></li>
      <li><a href="javascript:filtrocidade('n');">N</a></li>
      <li><a href="javascript:filtrocidade('o');">O</a></li>
      <li><a href="javascript:filtrocidade('p');">P</a></li>
      <li><a href="javascript:filtrocidade('q');">Q</a></li>
      <li><a href="javascript:filtrocidade('r');">R</a></li>
      <li><a href="javascript:filtrocidade('s');">S</a></li>
      <li><a href="javascript:filtrocidade('t');">T</a></li>
      <li><a href="javascript:filtrocidade('u');">U</a></li>
      <li><a href="javascript:filtrocidade('v');">V</a></li>
      <li><a href="javascript:filtrocidade('w');">W</a></li>
      <li><a href="javascript:filtrocidade('x');">X</a></li>
      <li><a href="javascript:filtrocidade('y');">Y</a></li>
      <li><a href="javascript:filtrocidade('z');">Z</a></li>
    </ul>
    <ul id="ul-lista-cidades">
      <?php foreach($cidadestopolistforletra as $dadoscidadeofletras){  ?>
      	<li><a href="<?php echo /*$dadoscidadeofletras->id*/"#";?>" <?php if($dadoscidadeofletras->id == "1"){ ?> class="cidade-ativa" <?php } ?>><?php echo utf8_encode($dadoscidadeofletras->descricao);?></a></li>
      <?php } ?>
      
    </ul>
  </div>
</div>

<map name="MapMap" id="MapMap">
  <area shape="rect" coords="93,4,139,51" href="http://www.facebook.com/edegraca.com.br" target="_blank" />
  <area shape="rect" coords="145,5,190,52" href="http://www.twitter.com/@_edegraca" target="_blank" alt="twitter" />
</map>
<div id="modal" style="display:none">
  <div id="modal-cadastre-index">
    <div id="modal-top"><img src="images/images/topo-modal.png" alt="Cadastre-se Grátis - É Fácil e Rápido" width="685" height="65" /></div>
    <span class="tit-modal"> Receba diariamente as melhores ofertas em seu email e ainda concorra a prêmios! </span>
    <table width="685" border="0" cellspacing="0" cellpadding="0" class="table-form-modal">
      <tr>
        <td width="324">
        <form action="#" method="post" id="form-modal-index">
          <label>E-mail:</label>
          <br />
          <input name="email2" type="text" id="email2"  class="form-modal-input radius5"/>
          <br />
          <label>Estado:</label>
          <br />
          <select name="cod_estados" id="cod_estados" class="form-modal-select estado radius5">
            <option value="0">Selecione</option>
            <?php foreach($cidadeslist as $dadoscidade){ ?>
            		<option value="<?php echo $dadoscidade->uf_codigo;?>"><?php echo $dadoscidade->uf_sigla;?></option>
            <?php } ?>
          </select>
          <br />
          <label>Escolha sua Cidade:</label>
          <br />
          <select name="cod_cidades" id="cod_cidades" style="display: inline-block; " class="form-modal-select radius5">
            <option value="">Selecione</option>
            
          </select>
          <div id="modal-btn"> <a href="#"></a> </div>
          <div id="modal-redes-sociais"><img src="images/images/redes-sociais-modal.png" alt="redes sociais:" width="201" height="61" border="0" usemap="#MapMap" /> </div>
          <div id="ja-cadastrado"><a href="#" class="jacadastrado">Eu já sou Cadastrado.</a> | <a href="privacidade.php" target="_blank">Política de Privacidade</a>. </div>
        </form></td>
        <td width="361">
        <div id="topo-imgs-modal">
        		<img src="images/images/topo-foto.png" width="361" height="34" alt="Aproveite as melhores ofertas:" />
        </div>
          
          <div id="modal-fotos">
            <?php foreach($oferta1['oferta'] as $dadosofertasbalaocadastro){ ?>
	            <div class="item-foto-modal"><?php $dadosimg = $objOferta->getOfertaImagem($dadosofertasbalaocadastro['id'],"id_oferta"); ?> <img src="http://www.edegraca.com.br/administrator/uploads/<?php echo $dadosimg['image']?>" width="361" height="249" alt="foto" />
	              <div class="caixa-preco-modal">
	                <div>De: <span class="riscado">R$ <?php echo $dadosofertasbalaocadastro['valor'];?></span></div>
	                <div>Por: <span>R$ <?php echo $dadosofertasbalaocadastro['valorpromocao'];?></span></div>
	              </div>
	            </div>
	         <?php } ?>
            
            <!--<img src="images/images/foto001.jpg" alt="Bares e Restaurantes" />
      <img src="images/images/foto002.jpg" width="361" height="237" alt="Hotéis e Viagens" /><img src="images/images/estetica.jpg" alt="Estética e Beleza" /><img src="images/images/esportelazer.jpg" width="361" height="237" alt="Esporte e Lazer" /><img src="images/images/prodservicos.jpg" width="361" height="237" alt="Produtos e Serviços" />-->
          </div></td>
      </tr>
    </table>
  </div>
</div>



<div id="topo">
	<div id="topo-content">
	<div id="logo"></div>
    <div id="cidades-topo">
    Recife
    </div>
    <div id="topo-right">
     <?php if($_SESSION['cliente']){ ?>
      <div id="menu-topo">
    	<ul>
        <li class="menu-topo-left"><a href="minha-conta-index.php">Minha Conta</a></li>
        <li class="menu-topo-linha"></li>
        <li class="menu-topo-right"><a href="sair.php">Sair</a></li>
        </ul>
    </div><!-- fim div menu-topo-->
    <?php }else{?>
      <div id="menu-topo">
    	<ul>
        <li class="menu-topo-left"><a href="login.php">Login</a></li>
        <li class="menu-topo-linha"></li>
        <li class="menu-topo-right"><a href="cadastro.php">Cadastre-se</a></li>
        </ul>
    </div><!-- fim div menu-topo-->
    <?php } ?>
    <div id="topo-newsletter">
    <form action="#" id="newletter">
    Receba nossas ofertas:
    <input name="email" type="text" id="newsletter-txtfield"/>
    <div id="btn-ok-newsletter"><a href="#"></a></div>
    </form>
    </div>    
    </div><!-- fim div topo-right-->
    
  </div><!-- fim div topo-content--> 
</div><!-- fim div topo-->
<div id="menuwrap"> 
<div id="menu">
<ul>
<li><a href="index.php">Oferta do Dia</a></li>
<li><a href="lista-de-promocoes.php">Mais Ofertas</a></li>
<li><a href="lista-de-promocoes_encerradas.php">Ofertas Anteriores</a></li>
<li><a href="comofunciona.php">Como Funciona</a></li>
<li><a href="comocomprar.php">Como Comprar</a></li>
<li><a href="minha-conta-index.php">Minha Conta</a></li>
<li><a href="regras-sorteio.php">Regras do Sorteio</a></li>
<li><a href="faleconosco.php">Fale Conosco</a></li>
<!--<li><a href="#">Parceiros</a></li>-->

</ul>
</div>
</div>