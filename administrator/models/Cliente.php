<?php
 class Cliente extends Base {
	
	
   public function Cliente(){
   	
   }	
   
   
    public function inserirCliente($arguments){
    	$this->conectar();
    	$retorno = $this->insert($arguments,'cliente');
    	if($retorno){
    		return $retorno;
    	}else{
    		return false;
    	}
    }
    
    
	public function editarCliente($argument,$id){
    	$this->conectar();
    	$retorno = $this->update($argument,'cliente','id',$id);
    	if($retorno){
    		return $retorno;
    	}else{
    		return false;
    	}
    }
    
    
    public function excluirCliente($id,$identificador){
    	$this->conectar();
    	$retorno = $this->delete($id,$identificador,'cliente');
    	if($retorno){
    		return true;
    	}else{
    		return false;
    	}
    }
    
    public function listarClientes($filtro,$qtd){
    	$this->conectar();
    	$sql = "SELECT * FROM cliente ORDER BY nome ASC";
    	$retorno['paginacao'] = $paginacao = new Paginacao($qtd,'pag',$sql);
    	$sql = $sql." LIMIT $paginacao->Inicial, $paginacao->Final";
    	$query = mysql_query($sql);
    	echo mysql_error();
    	while($dados = mysql_fetch_assoc($query)){
    		$retorno['cliente'][] = $dados;    		
    	}
    	if($retorno){
    		return $retorno;
    	}else{
    		return false;
    	}	
    }
    
    public function listarClientes2($filtro){
    	$this->conectar();
    	$sql = "SELECT * FROM cliente where 1=1 ".utf8_decode($filtro);
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
    public function ExportarEmail($filtro){
    	$this->conectar();
    	$sql = "SELECT c.email FROM `cliente` as c inner join cliente_cidade as cc on (c.id = cc.id_cliente) where 1=1 ".utf8_decode($filtro);
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
    
  public function getCliente($id,$identificador){
    	$this->conectar();
    	$sql = "SELECT * FROM cliente WHERE $identificador = '".$id."'";    	
    	$query = mysql_query($sql);
    	echo mysql_error();
		$dados = mysql_fetch_assoc($query);
		return $dados; 
    }
    
    
 public function gerarLista($filtro){
    	$this->conectar();
		$sql = "SELECT * FROM cliente where 1=1 ".$filtro." ORDER BY pontos desc, nome asc";
    	$query = mysql_query($sql);
    	echo mysql_error();
    	while($dados = mysql_fetch_array($query)){
    		$retorno[] = $dados;    		
    	}
    	if($retorno){
    		return $retorno;
    	}else{
    		return false;
    	}
    }
    
    
    
    public function cadastranews ($post){
    	$this->conectar();
    	$retorno = $this->insert($post,'newsletter');
    	if($retorno){
    		return $retorno;
    	}else{
    		return false;
    	}
    }
    
    public function verificaemailnewsletter($email){
    	$this->conectar();
    	$sql = "select * from newsletter where newsletter ='".$email."'";
    	$query = mysql_query($sql)or die(mysql_error());
    	$dados = mysql_fetch_object($query);
		return $dados; 
    	
    }
    
    public function getqtdCupons($id){
    	$this->conectar();
    	$sql = "select count(*) as qtd from oferta_cliente where ativo = 1 and comprou = 1 and id_cliente = ".$id;
    	$query = mysql_query($sql);
    	echo mysql_error();
    	$dados = mysql_fetch_object($query);
    	return $dados;
    }
}
?>