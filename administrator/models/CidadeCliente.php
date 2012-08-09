<?php
class CidadeCliente extends Base{
	
	public function CidadeCliente(){
		
	}
	public function inserirCidadeCliente($arguments){
    	$this->conectar();
    	$retorno = $this->insert($arguments,'cliente_cidade');
    	if($retorno){
    		return $retorno;
    	}else{
    		return false;
    	}
    }
    
    public function excluirCidadeCliente($id,$identificador){
    	$this->conectar();
    	$retorno = $this->delete($id,$identificador,'cliente_cidade');
    	if($retorno){
    		return true;
    	}else{
    		return false;
    	}
    }
     
    public function listarCidadeCliente($filtro){
    	$this->conectar();
    	$sql = "SELECT * FROM cliente_cidade where 1=1".$filtro;
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
    
 	public function getCidadeCliente($id){
    	$this->conectar();
    	$sql = "SELECT * FROM cidade_oferta WHERE id = '".$id."'";    	
    	$query = mysql_query($sql);
    	echo mysql_error();
		$dados = mysql_fetch_assoc($query);
		return $dados; 
    }
    
}
?>
