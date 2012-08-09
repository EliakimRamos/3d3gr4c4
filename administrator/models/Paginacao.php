<?php
/*
    PaginacaoClass - Classe PHP de Montagem de Navegadores de P�gina
    ----------------------------------------------------------------
    Autor: Fernando Val <fernando.val@gmail.com>

    Descri��o:
        PaginacaoClass � uma classe em PHP para fazer os links de navega��o de p�gina no formato
        "Anterior <primeira> ... <n-3> <n-2> <n-1> N <n+1> <n+2> <n+3> ... <ultima> Pr�xima".

        A classe � totalmente personaliz�vel, permitindo que o programador defina os seguintes
        par�metros:

        - Link do site;
        - Vari�vel GET de defini��o da p�gina;
        - N�mero de p�ginas naveg�veis laterais a p�gina atual;
        - Texto usado para o separador da primeira e �ltiam p�ginas dos navegadores de p�ginas;
        - Texto da link "Anterior";
        - Texto do link "Pr�xima";
        - Classes HTML dos links, p�gina atual e separadores.

    Observa��es:
        - Esta classe foi totalmente escrita no idioma Portugu�s do Brasil, inclusive seu nome,
        propriedades e fun��es. N�o h� interesse do autor em portar nada para outros idiomas.
        Interessados em traduzir a documenta��o e instru��es para outros idiomas s�o bem vindos.
        Caso algu�m escreva alguma documenta��o em outro idioma, favor avisar o autor para que
        o documento e seus devidos cr�ditos sejam anexados ao projeto;
        - O autor agradece quaisquer coment�rios e sugest�es de melhorias.

    Licen�a:
        Esta classe � Open Source e distribuida sob a licen�a GPL.

    Hist�rico:
        1.00 - 21/Mar/2007 - Primeira vers�o da classe
*/

/*
    Exemplo de c�digo PHP de como usar esta classe
    ----------------------------------------------
	
	<?
			include "lib/PaginacaoClass2.0.php" ;
			$Paginacao = new Paginacao(5,'pag',"SELECT DISTINCT tipomaterial.id, tipomaterial.tipo  FROM tipomaterial,material WHERE 1=1 AND tipomaterial.id = material.id_tipomaterial  ORDER BY tipo ASC");
		?>
		
	
			
			
		<? $query = mysql_query("SELECT  DISTINCT tipomaterial.id, tipomaterial.tipo FROM tipomaterial,material WHERE 1=1 AND tipomaterial.id = material.id_tipomaterial ORDER BY tipo ASC LIMIT $Paginacao->Inicial,$Paginacao->Final"); ?>

	
<tr id="gridPaginacao">
					<td colspan="13">
						<p style="float:left">Resultado de <? if($Paginacao->TotalDeElementos == '0'){echo '0';}else{if($Paginacao->Inicial == 0){echo '1';}else{echo $Paginacao->Inicial;}}?> a <? if(($Paginacao->Inicial+$Paginacao->NumeroRegistroPagina) > $Paginacao->TotalDeElementos){echo $Paginacao->TotalDeElementos;}else{echo ($Paginacao->Inicial+$Paginacao->NumeroRegistroPagina);}?> de <?=$Paginacao->TotalDeElementos;?> registros.</p>
						<p style="float:right">Página: <?= $Paginacao->MontarPaginacao($Paginacao->PaginaAtual, $Paginacao->UltimaPagina) ?></p>
					</td>
					
					
			</tr>
*/

class Paginacao {
    // Propriedades da classe
    var $PaginaAtual = 1;       // Define a p�gina atual
    var $UltimaPagina = 1;      // Define a quantidade de p�ginas
    var $NumPgLaterais = 3;     // Define quantas p�ginas ser�o naveg�veis para os lados a partir da p�gina atual
    var $SiteLink = '';         // Define o hyperlink dos navegadores
    var $PageGET = 'pag';       // Define a vari�vel do GET que receber� o n�mero da p�gina para navegar

    var $HTMLPaginacao = '';    // C�digo HTML com a navega��o

    var $TextoSeparador = '...';                    // Texto a ser mostrado como separador para primeira e �ltima p�ginas
    var $ClassePaginaAtual = 'paginacao_atual';     // Classe CSS usada para a LABEL de p�gina atual
    var $ClasseNavegadores = 'paginacao_navegar';   // Classe CSS usada para os LINKs de navega��o
    var $ClasseSeparadores = 'paginacao_atual';     // Classe CSS usada para os LABELS dos separadores de primeira e �ltima p�ginas
    var $ClasseAnterior    = 'paginacao_anterior';
    var $ClasseProxima     = 'paginacao_proxima';
    
    var $TextoAnterior = '';                // Texto a ser mostrado no link para a p�gina anterior
    var $TextoProxima = '';           // Texto a ser mostrado no link para a pr�xima p�gina
    
    var $NumeroRegistroPagina = '10';				// N�mero de linhas por p�gina
  
    var $Inicial=0;									//Inicio do limit
    var $Final=0;										//Final do limit
    
    var $Tabela;									//tabela para a contagem
    var $Total;										//total de páginas
    var $TotalDeElementos;							//total de elementos

    
    function Paginacao($NumeroRegistroPagina=10,$PageGET = "pag",$sql=''){
    	
    	$this->PageGET 						 = $PageGET;
    	
    	
    	
    	@$posicao =  strpos($_SERVER['REQUEST_URI'],"&".$this->PageGET);
		if($posicao > 0){
			$links =  substr($_SERVER['REQUEST_URI'],0,$posicao);
		}else{
			
			@$posicao =  strpos($_SERVER['REQUEST_URI'],"?".$this->PageGET);
			if($posicao > 0){
				$links =  substr($_SERVER['REQUEST_URI'],0,$posicao);
			}else{
				$links =  $_SERVER['REQUEST_URI'];
			}
		}
		
		$sql = mysql_query($sql);
		$reg = mysql_num_rows($sql);
		
		$this->TotalDeElementos			  = $reg;
		$this->NumeroRegistroPagina		  = $NumeroRegistroPagina;
		$this->UltimaPagina		  		  = ceil((int)$reg / $NumeroRegistroPagina);
		$this->SiteLink  		 		  = $links;
		$this->Final       		  		  = $NumeroRegistroPagina;
		$this->PaginaAtual	      		  = empty($_GET["$this->PageGET"]) ? 0 : (int)$_GET["$this->PageGET"];
		
		if($this->PaginaAtual != 0){$inicio = ($this->PaginaAtual-1);}else{$inicio = 0;}
		$this->Inicial    			  	  = $inicio * $this->NumeroRegistroPagina;
		$this->Total					  = $reg;
		
		
    }
     
    function MontarPaginacao($pgatual = 0, $pgfim = 0) {
        // Verifica se a p�gina atual e/ou a �ltima foram passadas por par�metro na chamada
        if ($pgatual)
            $this->PaginaAtual = $pgatual;
        if ($pgatual === 0)
            $this->PaginaAtual = 1;
        if ($pgfim)
            $this->UltimaPagina = $pgfim;

        // Monta o link
        if (strpos($this->SiteLink, '?') === FALSE) {
            $link = $this->SiteLink . '?' . $this->PageGET . '=';
        } else {
            $link = $this->SiteLink . '&' . $this->PageGET . '=';
        }

        // Verifica se tem navaga��o pra p�gina anterior
        $anterior = '';
        if ($this->PaginaAtual > 1) {
            $anterior = '<A HREF="'.$link.($this->PaginaAtual - 1).'" CLASS="'.$this->ClasseAnterior.'">'.$this->TextoAnterior.'</A> ';
        }

        // Verifica se mostra navegador para primeira p�gina
        $primeira = '';
        if (($this->PaginaAtual - ($this->NumPgLaterais + 1) > 1) && ($this->UltimaPagina > ($this->NumPgLaterais * 2 + 2))) {
            $primeira = '<A HREF="'.$link.'1" CLASS="'.$this->ClasseNavegadores.'">1</A> <LABEL CLASS="'.$this->ClasseSeparadores.'">'.$this->TextoSeparador.'</LABEL> ';
            $dec = $this->NumPgLaterais;
        } else {
            $dec = $this->PaginaAtual;
            while ($this->PaginaAtual - $dec < 1) {
                $dec--;
            }
        }

        // Verifica se mostra navegador para �ltima p�gina
        $ultima = '';
        if (($this->PaginaAtual + ($this->NumPgLaterais + 1) < $this->UltimaPagina) && ($this->UltimaPagina > ($this->NumPgLaterais * 2 + 2))) {
            $ultima = '<LABEL CLASS="'.$this->ClasseSeparadores.'">'.$this->TextoSeparador.'</LABEL> <A HREF="'.$link.$this->UltimaPagina.'" CLASS="'.$this->ClasseNavegadores.'">'.$this->UltimaPagina.'</A>';
            $inc = $this->NumPgLaterais;
        } else {
            $inc = $this->UltimaPagina - $this->PaginaAtual;
        }

        // Se houverem menos p�ginas anteriores que o definido, tenta colocar mais p�ginas para a frente
        if ($dec < $this->NumPgLaterais) {
            $x = $this->NumPgLaterais - $dec;
            while ($this->PaginaAtual + $inc < $this->UltimaPagina && $x > 0) {
                $inc++;
                $x--;
            }
        }
        // Se houverem menos p�ginas seguintes que o definido, tenta colocar mais p�ginas para tr�s
        if ($inc < $this->NumPgLaterais) {
            $x = $this->NumPgLaterais - $inc;
            while ($this->PaginaAtual - $dec > 1 && $x > 0) {
                $dec++;
                $x--;
            }
        }

        // Monta o conte�do central do navegador
        $atual = '';
        for ($x = $this->PaginaAtual - $dec; $x <= $this->PaginaAtual + $inc; $x++) {
            if ($x == $this->PaginaAtual) {
                $atual .= '<LABEL CLASS="'.$this->ClassePaginaAtual.'">'.$x.'</LABEL> ';
            } else {
                $atual .= '<A HREF="'.$link.$x.'" CLASS="'.$this->ClasseNavegadores.'">'.$x.'</A> ';
            }
        }

        // Verifica se mostra navegador para pr�xima p�gina
        $proxima = '';
        if ($this->PaginaAtual < $this->UltimaPagina) {
            $proxima = ' <A HREF="'.$link.($this->PaginaAtual + 1).'" CLASS="'.$this->ClasseProxima.'">'.$this->TextoProxima.'</A>';
        }

        return $this->HTMLPaginacao = $anterior.$primeira.$atual.$ultima.$proxima;
    }
}
?>