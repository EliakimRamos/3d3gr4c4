<?php
class Comercial extends Base{
	
	public function Comercial(){
		
	}
	public function inserirComercial($arguments){
    	$this->conectar();
    	$retorno = $this->insert($arguments,'comercial');
    	if($retorno){
    		return $retorno;
    	}else{
    		return false;
    	}
    }
    public function editarComercial($argument,$id){
    	$this->conectar();
    	$retorno = $this->update($argument,'comercial','id',$id);
    	if($retorno){
    		return $retorno;
    	}else{
    		return false;
    	}
    }
     public function excluirComercial($id,$identificador){
    	$this->conectar();
    	$retorno = $this->delete($id,$identificador,'comercial');
    	if($retorno){
    		return true;
    	}else{
    		return false;
    	}
    }
    public function listarComercial($filtro){
    	$this->conectar();
    	$sql = "SELECT * FROM comercial ".$filtro;
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
    public function listarComercial2(){
    	$this->conectar();
    	$sql = "SELECT * FROM comercial ORDER BY nome ASC";    	
    	$query = mysql_query($sql);
    	echo mysql_error();
    	while($dados = mysql_fetch_assoc($query)){
    		$retorno['comercial'][] = $dados;    		
    	}
    	if($retorno){
    		return $retorno;
    	}else{
    		return false;
    	}
    		
    }
     public function getComercial($id,$identificador){
    	$this->conectar();
    	$query = mysql_query("SELECT * FROM comercial WHERE $identificador='".$id."'");
    	echo mysql_error();
    	$dados = mysql_fetch_array($query);
    	return $dados;
    }
}
?>
