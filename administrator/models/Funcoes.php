<?php
	
	class Funcoes {
		
		/**
		 * Funcao que retorna data no formata de ano-mes-dia
		 * @param $data
		 * @return ano-mes-dia
		 */		
		 public function formata_data($data){
				
				$dia = substr($data,0,2);
				$mes = substr($data,3,2);
				$ano = substr($data,6,4);
				
		
				return $ano."-".$mes."-".$dia;
				
			}
			
			/**
			 * Funcao que retorna data no formato dia/mes/ano
			 * @param date data
			 */
			public function formata_data_BR($data){
				
				$dia = substr($data,8,2);
				$mes = substr($data,5,2);
				$ano = substr($data,0,4);
				
		
				return $dia."/".$mes."/".$ano;
				
			}
			
			public function date_transform($data,$today = false,$separador="/"){
				$dataBr = '/^(0[1-9]|[1-2][0-9]|3[0-1])[\/](0[1-9]|1[0-2])[\/](19|20)[0-9]{2}$/';
				$dataSql = '/^(19|20)[0-9]{2}[\-](0[1-9]|1[0-2])[\-](0[1-9]|[1-2][0-9]|3[0-1])$/';
				if(preg_match($dataSql,$data,$retorno)){
					$date = explode('-', $retorno[0]);
					if($separador == ""){
						$date_transform = $date[2].'/'.$date[1].'/'.$date[0];
					}else{
						$date_transform = $date[2].$separador.$date[1].$separador.$date[0];
					}
					return $date_transform;
				}else if(preg_match($dataBr,$data,$retorno)){
					$date = explode('/', $retorno[0]);
					$date_transform = $date[2].'-'.$date[1].'-'.$date[0];
					return $date_transform;
				}elseif($data == "" && $today == true){
					return date("d/m/Y");
				}else{
					return $data;
				}
		}
						
			/**
			 * Funcao que impede scripts maliciosos de sql
			 * @param object $str
			 * @return
			 */
			public function anti_injection($sql)
			{
			    // remove palavras que contenham sintaxe sql
			    $sql = preg_replace(sql_regcase("/(from|select|insert|delete|where|drop table|show tables|#|\*|--|\\\\)/"),"",$sql);
			    $sql = trim($sql);//limpa espa�os vazio
			    $sql = strip_tags($sql);//tira tags html e php
			    $sql = addslashes($sql);//Adiciona barras invertidas a uma string
			    $sql= htmlspecialchars($sql);//Converte caracteres especiais do html
			    return $sql;
			}
			
			public function formaTabela($nomemodelo,$nome,$descricao,$preco,$cor,$qtd){
				$quantidade = "<table border=0><tr>";
						   if($nomemodelo){
						   		$quantidade .= "<td width=20% align=center>".$nomemodelo."</td>";
						   }
						   if($nome){
						   		$quantidade .= "<td width=20% align=center>".$nome."</td>";
						   }
						   if($descricao){
						   		$quantidade .= "<td width=20% align=center>".$descricao."</td>";
						   }
						   if($preco){
						   		$quantidade .= "<td width=15% align=center>".$preco."</td>";
						   }
						   if($cor){
						   		$quantidade .= "<td width=15% align=center>".$cor."</td>";
						   }
						   if($qtd){
						   		$quantidade .= "<td width=10% align=center>".$qtd."</td>";
						   }
						   if($qtd && $preco){
						   		$quantidade .= "<td width=10% align=center>".$qtd * $preco."</td>";
						   }
						   return $quantidade;			
			}
			
			public function getItens($idpedido){
				$sql="select ip.status,ip.cor,ip.id_itemPedido, ip.tamanho1, ip.tamanho2, ip.tamanho3, ip.tamanho4, ip.tamanho5, ip.tamanho6, ip.qtd1, " .
					 "ip.qtd2, ip.qtd3, ip.qtd4, ip.qtd5, ip.qtd6, p.descricao, ip.preco_unit, ip.status, ip.ordem_corte,ip.obs  from  itempedido as ip inner join produto as p " .
					 "on(p.id_produto = ip.id_produto) where ip.id_pedido = ".$idpedido;
				$query = mysql_query($sql);
				
				while($result = mysql_fetch_array($query)){
					$dados[] = $result;
				}
				
				if($dados){
					return $dados;
					
				}else{
					return false;
				}
				
			}
			
			public function getStatus($id){
				 $sql="select descricao from status where id_status =".$id;
				$query =mysql_query($sql)or die(mysql_error());
				while($result = mysql_fetch_assoc($query)){
					$dados=$result['descricao'];
				}				
				if($dados){
					return $dados;
				}else{
					return false;
				}
			}
	}

?>