<?php
class Agendahotel extends Base{
	
	public function Agendahotel(){
		
	}
	public function inserirAgendahotel($arguments){
    	$this->conectar();
    	$retorno = $this->insert($arguments,'agenda_hotel');
    	if($retorno){
    		return $retorno;
    	}else{
    		return false;
    	}
    }
    public function editarAgendahotel($argument,$id){
    	$this->conectar();
    	$retorno = $this->update($argument,'agenda_hotel','id',$id);
    	if($retorno){
    		return $retorno;
    	}else{
    		return false;
    	}
    }
     public function excluirAgendahotel($id,$identificador){
    	$this->conectar();
    	$retorno = $this->delete($id,$identificador,'agenda_hotel');
    	if($retorno){
    		return true;
    	}else{
    		return false;
    	}
    }
    public function listarAgendahotel($filtro){
    	$this->conectar();
    	$sql = "SELECT * FROM agenda_hotel ".$filtro;
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
    public function listarAgendahotel2(){
    	$this->conectar();
    	$sql = "SELECT * FROM agenda_hotel ORDER BY nome ASC";    	
    	$query = mysql_query($sql);
    	echo mysql_error();
    	while($dados = mysql_fetch_assoc($query)){
    		$retorno['agenda'][] = $dados;    		
    	}
    	if($retorno){
    		return $retorno;
    	}else{
    		return false;
    	}
    		
    }
     public function getAgendahotel($id,$identificador){
    	$this->conectar();
    	$query = mysql_query("SELECT * FROM agenda_hotel WHERE $identificador='".$id."'");
    	echo mysql_error();
    	$dados = mysql_fetch_array($query);
    	return $dados;
    }
}
?>
