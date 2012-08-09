<?php
require_once ("Funcoes.php");
class Oferta extends Base {


	public function Oferta(){

	}
	 
	 
	public function inserirOferta($arguments){
		$this->conectar();
		$retorno = $this->insert($arguments,'oferta');
		if($retorno){
			return $retorno;
		}else{
			return false;
		}
	}
	
	public function inserirOfertaImage($arguments){
		$this->conectar();
		$retorno = $this->insert($arguments,'oferta_image');
		if($retorno){
			return $retorno;
		}else{
			return false;
		}
	}
	
	public function editarOferta($argument,$id){
		$this->conectar();
		$retorno = $this->update($argument,'oferta','id',$id);
		if($retorno){
			return $retorno;
		}else{
			return false;
		}
	}
	public function excluirOferta($id,$identificador){
		$this->conectar();
		$retorno = $this->delete($id,$identificador,'oferta');
		if($retorno){
			return true;
		}else{
			return false;
		}
	}
	public function excluirOfertaImagem($id,$identificador){
		$this->conectar();
		$retorno = $this->delete($id,$identificador,'oferta_image');
		if($retorno){
			return true;
		}else{
			return false;
		}
	}
	
		public function listarOferta($filtro){
		$this->conectar();
		$sql = "SELECT o.id, o.id_empresa, o.agendado, o.data_agendamento, o.novaposicao, o.id_categoria, o.valor, o.qtd_maxima, o.data_inicio, o.data_final, o.data_validade, o.descricao, o.ativa, o.desconto," .
			   " o.valorpromocao, o.valordesconto, o.titulo, o.posicao, o.lucro from oferta o, edegraca_cidade c where o.id = c.id_oferta ".$filtro." group by o.id ORDER BY o.id DESC";		
		$query = mysql_query($sql);
		echo mysql_error();
		while($dados = mysql_fetch_assoc($query)){
			$retorno['oferta'][] = $dados;
		}
		if($retorno){
			return $retorno;
		}else{
			return false;
		}
	}

	public function listarOferta2($filtro){
		$this->conectar();
	 	$sql = "SELECT * FROM oferta where 1=1 ".$filtro ." order by id desc";
		$query = mysql_query($sql);
		echo mysql_error();
		if(mysql_num_rows($query)> 0){
			while($dados = mysql_fetch_assoc($query)){
				$retorno[] = $dados;
			}
			if($retorno){
				return $retorno;
			}else{
				return false;
			}
		}
	}
	
	public function listarAnteriores($filtro){
		$this->conectar();
	 	$sql = "select o.id, o.valor, o.desconto, o.valorpromocao, o.valordesconto, o.titulo from oferta o, pechincha_cidade pc where o.ativa = 0 and pc.id_oferta = o.id and pc.id_cidade =".$filtro." order by o.id desc";
		$query = mysql_query($sql);
		echo mysql_error();
		if(mysql_num_rows($query)> 0){
			while($dados = mysql_fetch_assoc($query)){
				$retorno[] = $dados;
			}
			if($retorno){
				return $retorno;
			}else{
				return false;
			}
		}
	}
	
	public function listarOferta3($filtro){
		$this->conectar();
		$sql = "SELECT o.id, o.id_empresa, o.id_categoria, o.valor, o.qtd_minima, o.qtd_maxima, o.data_inicio, o.data_final, o.data_validade, o.descricao, o.ativa, o.desconto, o.valorpromocao, o.valordesconto," .
				"	 o.regras, o.titulo, o.ofertabonus, o.limite, o.destaque, o.id_comercial, o.agendado, o.posicao, o.lucro from oferta o, " .
				" edegraca_cidade c where o.id = c.id_oferta and c.id_cidade = ". $filtro ."  group by o.id order by o.id desc";
				
		$query = mysql_query($sql);
		echo mysql_error();
		if(mysql_num_rows($query)> 0){
			while($dados = mysql_fetch_assoc($query)){
				$retorno[] = $dados;
			}
			if($retorno){
				return $retorno;
			}else{
				return false;
			}
		}
	}
	
	
	public function listarOfertaPagSeguro($filtro){
		$this->conectar();
	 	$sql = "SELECT * FROM transpagseguro where 1=1 ".$filtro ." group by code order by code asc, date desc ";
		$query = mysql_query($sql);
		echo mysql_error();
		if(mysql_num_rows($query)> 0){
			while($dados = mysql_fetch_assoc($query)){
				$retorno[] = $dados;
			}
			if($retorno){
				return $retorno;
			}else{
				return false;
			}
		}
	}
	
	public function listarOfertaImagem($filtro){
		$this->conectar();
		$sql = "SELECT * FROM oferta_image where 1=1 ".$filtro ." order by id_oferta_image asc";
		$query = mysql_query($sql);
		echo mysql_error();
		if(mysql_num_rows($query)> 0){
			while($dados = mysql_fetch_assoc($query)){
				$retorno[] = $dados;
			}
			if($retorno){
				return $retorno;
			}else{
				return false;
			}
		}
	}
	
	public function getOferta($id,$identificador){
		$this->conectar();
		$query = mysql_query("SELECT * FROM oferta WHERE ativa <> 2 and $identificador='".$id."'");
		echo mysql_error();
		$dados = mysql_fetch_assoc($query);
		return $dados;
	}
	
	public function getOferta2($id,$identificador){
		$this->conectar();
		$query = mysql_query("SELECT * FROM oferta WHERE  $identificador='".$id."'");
		echo mysql_error();
		$dados = mysql_fetch_assoc($query);
		return $dados;
	}
	
	
	public function getOfertaImagem($id,$identificador){
		$this->conectar();
		$query = mysql_query("SELECT * FROM oferta_image WHERE $identificador='".$id."'");
		echo mysql_error();
		$dados = mysql_fetch_assoc($query);
		return $dados;
	}
	
	public function CidadeOferta($id){
		$this->conectar();
		$query = mysql_query("SELECT * FROM cidade_oferta WHERE id='".$id."'");
		echo mysql_error();
		$dados = mysql_fetch_assoc($query);
		return $dados;
	}
	
	public function qtdVendida($id){
		$this->conectar();
		$query = mysql_query("SELECT COUNT(*)as qtd FROM oferta_cliente where id_oferta = ".$id." and comprou > 0");
		echo mysql_error();
		$dados = mysql_fetch_assoc($query);
		return $dados['qtd'];	
	}
	
	public function desativaOferta(){
		$objFuncao = new Funcoes();
		$this->conectar();
		$sql = "update oferta set ativa = 0 where data_final < '".date("Y-m-d")."'";
		$query =mysql_query($sql);
		
		$ofertasAtivas = $this->listarOferta2(" and ativa = 1 and agendado = 1 and data_agendamento = '".date("Y-m-d")."'");		
		if(!empty($ofertasAtivas)){
			foreach ($ofertasAtivas as $ofertaAtual){
				$ofertaAtual['data_inicio'] = $objFuncao->formata_data_BR($ofertaAtual['data_inicio']);
				$ofertaAtual['data_final'] =  $objFuncao->formata_data_BR($ofertaAtual['data_final']);
				$ofertaAtual['data_validade'] = $objFuncao->formata_data_BR($ofertaAtual['data_validade']); 
				$ofertaAtual['agendado'] = 0;
				$ofertaAtual['posicao'] = $ofertaAtual['novaposicao'];
				$ofertaAtual['novaposicao'] = ""; 
				
				$this->editarOferta($ofertaAtual, $ofertaAtual['id']);
			}
		}
	}
	
	public function ativarOferta(){
		$this->conectar();
		$sql = "update oferta set ativa = 1 where data_inicio = '".date("Y-m-d")."'";
		$query =mysql_query($sql);
		 		
		$this->desativaOferta();
	}
	
	public function listarOfertaFinanceiro($filtro){
		$this->conectar();
		$sql = "SELECT o.id, o.data_final, o.id_comercial, o.valorpromocao, o.data_final, o.lucro, o.titulo from oferta o, edegraca_cidade c where o.ativa <> 2 and o.id = c.id_oferta ". $filtro." group by o.id" ;
		$query = mysql_query($sql);
		echo mysql_error();
		while($dados = mysql_fetch_assoc($query)){
			$retorno['oferta'][] = $dados;
		}
		if($retorno){
			return $retorno;
		}else{
			return false;
		}
	}	
	
	public function listarOfertaFinanceiroTodas($filtro){
		$this->conectar();
		$sql = "SELECT * FROM oferta where 1=1 ".$filtro." order by data_final desc";		
		$query = mysql_query($sql);
		echo mysql_error();
		while($dados = mysql_fetch_assoc($query)){
			$retorno['oferta'][] = $dados;
		}
		if($retorno){
			return $retorno;
		}else{
			return false;
		}
	}
	
	public function OfertasFinanceiro($filtro){
		$this->conectar();
	 	$sql = "SELECT * FROM oferta where 1=1 ".$filtro ." order by titulo asc";
		$query = mysql_query($sql);
		echo mysql_error();
		if(mysql_num_rows($query)> 0){
			while($dados = mysql_fetch_assoc($query)){
				$retorno[] = $dados;
			}
			if($retorno){
				return $retorno;
			}else{
				return false;
			}
		}
	}
	
	public function TodasCidades(){
		$this->conectar();
		$query = mysql_query("SELECT * FROM cidade_oferta order by descricao ASC");
		echo mysql_error();
		$dados = mysql_fetch_assoc($query);
		return $dados;
	}
	
	
	public function InserirPagseguro($argument){
		$this->conectar();
		$retorno = $this->insert($argument,'transpagseguro');
		if($retorno){
			return $retorno;
		}else{
			return false;
		}
	}
	
	public function editarPagseguro($argument,$id){
		$this->conectar();
		$retorno = $this->update($argument,'transpagseguro','code',$id);
		if($retorno){
			return $retorno;
		}else{
			return false;
		}
	}
	
	public function listarTranspag($filtro){
		$this->conectar();
		$sql = "SELECT code from transpagseguro ".$filtro."ORDER BY code DESC";		
		$query = mysql_query($sql);
		echo mysql_error();
		while($dados = mysql_fetch_assoc($query)){
			$retorno[] = $dados;
		}
		if($retorno){
			return $retorno;
		}else{
			return false;
		}
	}
}
?>