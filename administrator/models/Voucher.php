<?php
 class Voucher extends Base {
	
	
   public function Voucher(){
   	
   }	
   
   
    public function inserirVoucher($arguments){
    	$this->conectar();
    	$retorno = $this->insert($arguments,'voucher');
    	if($retorno){
    		return $retorno;
    	}else{
    		return false;
    	}
    }
    
    
	public function editarVoucher($argument,$id){
    	$this->conectar();
    	$retorno = $this->update($argument,'voucher','id',$id);
    	if($retorno){
    		return $retorno;
    	}else{
    		return false;
    	}
    }
    
    
    public function excluirVoucher($id,$identificador){
    	$this->conectar();
    	$retorno = $this->delete($id,$identificador,'voucher');
    	if($retorno){
    		return true;
    	}else{
    		return false;
    	}
    }
    
    public function listarVoucher($filtro,$qtd){
    	$this->conectar();
    	$sql = "SELECT * FROM voucher order by id asc";
    	$retorno['paginacao'] = $paginacao = new Paginacao($qtd,'pag',$sql);
    	$sql = $sql." LIMIT $paginacao->Inicial, $paginacao->Final";
    	$query = mysql_query($sql);
    	echo mysql_error();
    	while($dados = mysql_fetch_assoc($query)){
    		$retorno['tipo'][] = $dados;    		
    	}
    	if($retorno){
    		return $retorno;
    	}else{
    		return false;
    	}
    		
    }
    
    public function listarVoucher2($filtro){
    	$this->conectar();
    	$sql = "SELECT * FROM voucher where 1=1 ".$filtro;
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
    
    public function getVoucher($id,$identificador){
    	$this->conectar();
    	$sql = "SELECT * FROM voucher WHERE $identificador = '".$id."'";
    	$query = mysql_query($sql);
    	echo mysql_error();
		$dados = mysql_fetch_array($query);
		return $dados; 
    }
	
}
?>