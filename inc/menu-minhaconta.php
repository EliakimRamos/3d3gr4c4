<div id="menu-minhaconta">
   
      <h1>Minha Conta:</h1>
      <ul>
      	<li><a href="minha-conta-index.php" <?php if ($menu=="inicio") echo ("class='actived'"); ?> > Início</a></li>
        <li><a href="minha-conta-dados.php" <?php if ($menu=="dados") echo ("class='actived'"); ?>> Meus Dados</a></li>
        <li><a href="minha-conta-cupons.php" <?php if ($menu=="cupons") echo ("class='actived'"); ?>> Meus Cupons</a></li> 
      <!-- <li><a href="minha-conta-convide.php" <?php if ($menu=="convide") echo ("class='actived'"); ?>> Convide Amigos</a></li> -->
         <li><a href="sair.php"> Sair</a></li>
         
      </ul>
    </div> <!-- fim div menu-minhaconta  -->