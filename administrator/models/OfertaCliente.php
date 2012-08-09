<?php

class OfertaCliente extends Base {


	public function OfertaCliente(){

	}
	 
	 
	public function inserirOfertaCliente($arguments){
		$this->conectar();
		$retorno = $this->insert($arguments,'oferta_cliente');
		if($retorno){
			return $retorno;
		}else{
			return false;
		}
	}
	public function editarOfertaCliente($argument,$id){
		$this->conectar();
		$retorno = $this->update($argument,'oferta_cliente','id',$id);
		if($retorno){
			return $retorno;
		}else{
			return false;
		}
	}
	public function excluirOfertaCliente($id,$identificador){
		$this->conectar();
		$retorno = $this->delete($id,$identificador,'oferta_cliente');
		if($retorno){
			return true;
		}else{
			return false;
		}
	}
	public function listarOfertaCliente($filtro,$qtd){
		$this->conectar();
		$sql = "SELECT * FROM oferta_cliente where 1=1 ".$filtro." order by id asc";
		$retorno['paginacao'] = $paginacao = new Paginacao($qtd,'pag',$sql);
		$sql = $sql." LIMIT $paginacao->Inicial, $paginacao->Final";
		$query = mysql_query($sql);
		echo mysql_error();
		while($dados = mysql_fetch_assoc($query)){
			$retorno['ofertacliente'][] = $dados;
		}
		if($retorno){
			return $retorno;
		}else{
			return false;
		}

	}

	public function listarOfertaCliente2($filtro){
		$this->conectar();
	    $sql = "SELECT * FROM oferta_cliente where 1=1 ".$filtro ." order by id desc";
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
	public function listarOfertaCliente3($filtro){
		$this->conectar();
		$sql = "SELECT * FROM oferta_cliente where 1=1 ".$filtro ." order by nome asc";
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
	
	public function getOfertaCliente($valor){
		$this->conectar();
		$sql="SELECT * FROM oferta_cliente WHERE 1 = 1 ".$valor;
		$query = mysql_query($sql);
		echo mysql_error();
		$dados = mysql_fetch_assoc($query);
		return $dados;
	}

}
?>