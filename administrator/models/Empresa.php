<?php
class Empresa extends Base {


	public function Empresa(){

	}
	 
	public function inserirEmpresa($arguments){
		$this->conectar();
		$retorno = $this->insert($arguments,'empresa');
		if($retorno){
			return $retorno;
		}else{
			return false;
		}
	}

	public function editarEmpresa($argument,$id){
		$this->conectar();
		$retorno = $this->update($argument,'empresa','id',$id);
		if($retorno){
			return $retorno;
		}else{
			return false;
		}
	}
	public function excluirEmpresa($id,$identificador){
		$this->conectar();
		$retorno = $this->delete($id,$identificador,'empresa');
		if($retorno){
			return true;
		}else{
			return false;
		}
	}


	public function listarEmpresa($filtro){
		$this->conectar();
		$sql = "SELECT * FROM empresa where 1=1 ".utf8_decode($filtro);
		$query = mysql_query($sql);
		echo mysql_error();
		while(
		$dados = mysql_fetch_assoc($query)){
			$retorno[] = $dados;
		}
		if($retorno){
			return $retorno;
		}else{
			return false;
		}
	}
	
 public function listarEmpresa2(){
    	$this->conectar();
    	$sql = "SELECT * FROM empresa where 1 = 1 ".$filtro." ORDER BY nome ASC";
    	$query = mysql_query($sql);
    	echo mysql_error();
    	while($dados = mysql_fetch_assoc($query)){
    		$retorno['empresa'][] = $dados;    		
    	}
    	if($retorno){
    		return $retorno;
    	}else{
    		return false;
    	}
    		
    }

 	public function getEmpresa($id,$identificador){
    	$this->conectar();
    	$query = mysql_query("SELECT * FROM empresa WHERE $identificador='".$id."'");
    	echo mysql_error();
    	$dados = mysql_fetch_array($query);
    	return $dados;
    }
}
?>