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
</script>

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