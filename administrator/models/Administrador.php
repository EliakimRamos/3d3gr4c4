<?php
class Administrador extends Base{
	
	public function Administrador(){
		
	}
	public function inserirAdministrador($arguments){
    	$this->conectar();
    	$retorno = $this->insert($arguments,'administrador');
    	if($retorno){
    		return $retorno;
    	}else{
    		return false;
    	}
    }
    public function editarAdministrador($argument,$id){
    	$this->conectar();
    	$retorno = $this->update($argument,'administrador','id',$id);
    	if($retorno){
    		return $retorno;
    	}else{
    		return false;
    	}
    }
     public function excluirAdministrador($id,$identificador){
    	$this->conectar();
    	$retorno = $this->delete($id,$identificador,'administrador');
    	if($retorno){
    		return true;
    	}else{
    		return false;
    	}
    }
    public function listarAdministrador($filtro){
    	$this->conectar();
    	$sql = "SELECT * FROM administrador ".$filtro;
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
    public function listarAdministrador2(){
    	$this->conectar();
    	$sql = "SELECT * FROM administrador ORDER BY nome ASC";    	
    	$query = mysql_query($sql);
    	echo mysql_error();
    	while($dados = mysql_fetch_assoc($query)){
    		$retorno['administrador'][] = $dados;    		
    	}
    	if($retorno){
    		return $retorno;
    	}else{
    		return false;
    	}
    		
    }
     public function getAdministrador($id,$identificador){
    	$this->conectar();
    	$query = mysql_query("SELECT * FROM administrador WHERE $identificador='".$id."'");
    	echo mysql_error();
    	$dados = mysql_fetch_array($query);
    	return $dados;
    }
}
?>
