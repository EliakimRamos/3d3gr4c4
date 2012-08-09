<?php

/*
 * Created on 04/05/2010
 *
 */
class Contareceber extends Base {

	public function Contareceber() {

	}

	public function inserirContareceber($arguments) {
		$this->conectar();
		$retorno = $this->insert($arguments, 'contareceber');
		if ($retorno) {
			return $retorno;
		} else {
			return false;
		}
	}

	public function editarContareceber($argument, $id) {
		$this->conectar();
		$retorno = $this->update($argument, 'contareceber', 'id_contareceber', $id);
		if ($retorno) {
			return $retorno;
		} else {
			return false;
		}
	}

	public function excluirContareceber($id, $identificador) {
		$this->conectar();
		$retorno = $this->delete($id, $identificador, 'contareceber');
		if ($retorno) {
			return true;
		} else {
			return false;
		}
	}

	public function listarContareceber($filtro, $qtd) {
		$this->conectar();		
		$sql = "SELECT c.numdoc, c.vencimento as vencimentoC, c.descricao,c.id_cliente, c.id_situacao as statusC, c.id_formapg, c.valorareceber, 
			    	 		c.qtd_parcela,c.numparcela, c.id_situacao, c.id_contareceber, c.id_venda,c.numParcela,c.valorparcela   
			    	 		FROM contareceber as c 	where 1=1  " . $filtro . " ORDER BY numdoc, numParcela, vencimento ASC";
		$retorno['paginacao'] = $paginacao = new Paginacao($qtd, 'pag', $sql);
		$sql = $sql . " LIMIT $paginacao->Inicial, $paginacao->Final";
		$query = mysql_query($sql);
		echo mysql_error();
		while ($dados = mysql_fetch_assoc($query)) {
			$retorno['contareceber'][] = $dados;
		}
		if ($retorno) {
			return $retorno;
		} else {
			return false;
		}

	}

	public function listarContareceber2($filtro) {
		$this->conectar();
		$sql = "SELECT * FROM contareceber";
		$query = mysql_query($sql);
		echo mysql_error();
		while ($dados = mysql_fetch_assoc($query)) {
			$retorno[] = $dados;
		}
		if ($retorno) {
			return $retorno;
		} else {
			return false;
		}

	}

	public function getContareceber($id, $identificador) {
		$this->conectar();
		$query = mysql_query("SELECT * FROM contareceber WHERE $identificador='" . $id . "'");
		echo mysql_error();
		$dados = mysql_fetch_array($query);
		return $dados;
	}
	public function getContareceberNumDoc($id, $identificador) {
		$this->conectar();
		$query = mysql_query("SELECT max(numdoc) as numdoc FROM contareceber"); // WHERE $identificador='" . $id . "'");
		echo mysql_error();
		$dados = mysql_fetch_array($query);
		return $dados;
	}
	public function getSituacao($id, $identificador) {
		$this->conectar();
		$sql = "SELECT * FROM situacao WHERE $identificador='" . $id . "'";
		$query = mysql_query($sql);
		echo mysql_error();
		$dados = mysql_fetch_array($query);
		return $dados;
	}
	public function getFormapg($id, $identificador) {
		$this->conectar();
		$query = mysql_query("SELECT * FROM formapg WHERE $identificador='" . $id . "'");
		echo mysql_error();
		$dados = mysql_fetch_array($query);
		return $dados;
	}
	public function getFilial($id, $identificador) {
		$this->conectar();
		$sql = "SELECT * FROM filial WHERE $identificador='" . $id . "'";
		$query = mysql_query($sql);
		echo mysql_error();
		$dados = mysql_fetch_array($query);
		return $dados;
	}

	public function listarFormasdePagamento($filtro) {
		$this->conectar();
		$sql = "SELECT id_formapg,descricao from formapg " . $filtro . " order by descricao asc";
		$query = mysql_query($sql);
		echo mysql_error();
		while ($dados = mysql_fetch_assoc($query)) {
			$retorno[] = $dados;
		}
		if ($retorno) {
			return $retorno;
		} else {
			return false;
		}

	}
	public function filtrocliente($filtro) {
		$this->conectar();
		$sql = "SELECT c.numdoc, c.vencimento as vencimentoC,c.descricao,c.id_cliente, c.id_situacao," .
				" c.id_formapg, c.valorareceber , c.qtd_parcela, c.id_contareceber, c.id_venda,c.numParcela,c.valorparcela   
			    	 		FROM contareceber as c inner join cliente as cl on (cl.id_cliente = c.id_cliente) where cl.nome like '%" . $filtro . "%'";
		$query = mysql_query($sql);
		echo mysql_error();
		while ($dados = mysql_fetch_assoc($query)) {
			$retorno[] = $dados;
		}
		if ($retorno) {
			return $retorno;
		} else {
			return false;
		}

	}

	public function getParcela($id, $identificador) {
		$this->conectar();
		$sql = "SELECT * FROM parcela WHERE $identificador='" . $id . "'";
		$query = mysql_query($sql);
		echo mysql_error();
		while ($dados = mysql_fetch_assoc($query)) {
			$resultados[] = $dados;
		}
		return $resultados;
	}

	public function inserirParcela($arguments) {
		$this->conectar();
		$retorno = $this->insert($arguments, 'parcela');
		if ($retorno) {
			return $retorno;
		} else {
			return false;
		}
	}

	public function editarParcela($argument, $id) {
		$this->conectar();
		$retorno2 = $this->update($argument, 'parcela', 'id_parcela', $id);
		if ($retorno2) {
			return $retorno2;
		} else {
			return false;
		}
	}

	public function quantidadeParcelaRestante($idcontapagar, $qtd) {
		$this->conectar();
		$sql = "select count(*) as parcelas from parcela where id_contareceber = " . $idcontapagar . " and id_situacao not in('4','5')";
		$query = mysql_query($sql) or die(mysql_error());
		$resultados = mysql_fetch_assoc($query);
		$dados = $resultados["parcelas"];
		return $dados;
	}
	public function quantidadeParcelaRecebida($idcontapagar, $qtd) {
		$this->conectar();
		$sql = "select count(*) as parcelas from parcela where id_contareceber = " . $idcontapagar . " and id_situacao in('4')";
		$query = mysql_query($sql) or die(mysql_error());
		$resultados = mysql_fetch_assoc($query);
		$dados = $resultados["parcelas"];
		return $dados;
	}
	public function quantidadeParcelacancelado($idcontapagar, $qtd) {
		$this->conectar();
		$sql = "select count(*) as parcelas from parcela where id_contareceber = " . $idcontapagar . " and id_situacao in('5')";
		$query = mysql_query($sql) or die(mysql_error());
		$resultados = mysql_fetch_assoc($query);
		$dados = $resultados["parcelas"];
		return $dados;
	}

}
?>