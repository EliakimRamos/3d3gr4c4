<?php

class Login extends Base {
	public function Login(){

	}

	public function Logar($login,$senha, $tabela){
		$this->conectar();
		$sql = "SELECT * FROM ".$tabela." WHERE email ='".$login."' and senha ='".substr(md5($senha),0,30)."'";
		$query = mysql_query($sql);
		$retorno = mysql_num_rows($query);
		$dados = mysql_fetch_assoc($query);
		if($retorno > 0){
			return $dados;
		}else{
			return false;
		}
	}

	public function verificar(){
		$ok = true;
		if($_SESSION['administradoredegraca'] != true){
			$ok= false;
		}
		return $ok;
	}

	public function verificarCliente(){
		$ok = true;
		if($_SESSION['cliente'] != true){
			$ok= false;
		}
		return $ok;
	}
	
	public function verificarComercial(){
		$ok = true;
		if($_SESSION['comercial'] != true){
			$ok= false;
		}
		return $ok;
	}
	
	
}
?>