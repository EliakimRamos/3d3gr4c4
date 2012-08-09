<?php
class CidadesOferta extends Base{
	
	public function CidadesOferta(){
		
	}
	public function inserirCidadesOferta($arguments){
    	$this->conectar();
    	$retorno = $this->insert($arguments,'cidade_oferta');
    	if($retorno){
    		return $retorno;
    	}else{
    		return false;
    	}
    }
    
	public function inserirEdegracaCidade($arguments){
    	$this->conectar();
    	$retorno = $this->insert($arguments,'edegraca_cidade');
    	if($retorno){
    		return $retorno;
    	}else{
    		return false;
    	}
    }
    
    public function excluirCidadesOferta($id,$identificador){
    	$this->conectar();
    	$retorno = $this->delete($id,$identificador,'cidade_oferta');
    	if($retorno){
    		return true;
    	}else{
    		return false;
    	}
    }     
    
    public function excluirPechinchaCidade($id,$identificador){
    	$this->conectar();
    	$retorno = $this->delete($id,$identificador,'pechincha_cidade');
    	if($retorno){
    		return true;
    	}else{
    		return false;
    	}
    }     
    
    public function listarCidadesOferta($filtro){
    	$this->conectar();
    	$sql = "SELECT * FROM cidade_oferta where 1=1 ".$filtro;
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
	
	public function listarCidades($filtro){
    	$this->conectar();
    	$sql = "SELECT * FROM edegraca_cidade where 1=1 ".$filtro;
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
