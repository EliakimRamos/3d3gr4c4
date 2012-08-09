<?php
class Contapagar extends Base {

	public function Contapagar() {

	}
	public function inserirContapagar($arguments) {
		$this->conectar();
		$retorno = $this->insert($arguments, 'contapagar');
		if ($retorno) {
			return $retorno;
		} else {
			return false;
		}
	}
	public function editarContapagar($argument, $id) {
		$this->conectar();
		$retorno = $this->update($argument, 'contapagar', 'id_contapagar', $id);
		if ($retorno) {
			return $retorno;
		} else {
			return false;
		}
	}
	public function excluirContapagar($id, $identificador) {
		$this->conectar();
		$retorno = $this->delete($id, $identificador, 'contapagar');
		if ($retorno) {
			return true;
		} else {
			return false;
		}
	}
	public function listarContapagar($filtro) {
		$this->conectar();
		$sql = "SELECT * FROM contapagar";
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
	public function listarContapagarpag($filtro, $qtd) {
		$this->conectar();
		$sql = "SELECT * FROM contapagar where 1=1 " . $filtro . "  ORDER BY vencimento ASC";
		$retorno['paginacao'] = $paginacao = new Paginacao($qtd, 'pag', $sql);
		$sql = $sql . " LIMIT $paginacao->Inicial, $paginacao->Final";
		$query = mysql_query($sql);
		echo mysql_error();
		while ($dados = mysql_fetch_assoc($query)) {
			$retorno['contapagar'][] = $dados;
		}
		if ($retorno) {
			return $retorno;
		} else {
			return false;
		}

	}
	public function getContapagar($id, $identificador) {
		$this->conectar();
		$query = mysql_query("SELECT * FROM contapagar WHERE $identificador='" . $id . "'");
		echo mysql_error();
		$dados = mysql_fetch_array($query);
		return $dados;
	}
}
?>