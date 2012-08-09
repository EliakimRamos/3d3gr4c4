<?php date_default_timezone_set('America/Recife');
abstract class Base {
	public function conectar(){
		
	//$servidor1 = "localhost";$usuario_db1 ="root";$senha_db1 ="";$banco1 ="pexinxa";
	$servidor1 = "localhost";$usuario_db1 ="edegr109_bruno";$senha_db1 ="@edegraca12@";$banco1 ="edegr109_edegraca";
	
	
		
		if(@mysql_connect($servidor1,$usuario_db1,$senha_db1) == true){
		
			$con = mysql_connect($servidor1,$usuario_db1,$senha_db1)or die(mysql_error());
			@mysql_select_db($banco1,$con) or die("Error ao selecionar o banco"); ;
			mysql_query("SET NAMES 'utf-8'");
			mysql_query('SET character_set_connection=utf-8');
			mysql_query('SET character_set_client=utf-8');
			mysql_query('SET character_set_results=utf-8'); 
			
		}else{
		
		echo mysql_error();
		
		}
		
	}
	
	public function datetime_transform($datetime) {
		$dataBr ="/^(\d{1,2})\/(\d{1,2})\/(\d{4}) (\d{1,2}):(\d{2}):(\d{2})$/";
		$dataSql = "/^(\d{4})-(\d{1,2})-(\d{1,2}) (\d{1,2}):(\d{2}):(\d{2})$/";
		if(preg_match($dataSql, $datetime, $dt)){
			$new = date("d/m/Y H:i:s", mktime($dt[4], $dt[5], $dt[6], $dt[2], $dt[3], $dt[1]));
		}else if(preg_match($dataBr, $datetime, $dt)){
			$new = date("Y-m-d H:i:s", mktime($dt[4], $dt[5], $dt[6], $dt[2], $dt[1], $dt[3]));
		}
		return $new;

	}

	public function float_transform($float) {		
		$floatBr = "/^[-+]?\d{1,3}(\.\d{3})*,\d{2}$/";
		$floatSql = '/^([0-9]*\.[0-9]{2})$/';
		if (preg_match($floatBr, $float, $retorno)) {
			$retorno[0] = str_replace(".", "", $retorno[0]);
			$retorno[0] = str_replace(",", ".", $retorno[0]);
			$float_transform = number_format($retorno[0], 2, '.', '');
			return $float_transform;
		} else if (preg_match($floatSql, $float, $retorno)) {
			$float_transform = number_format($retorno[0], 2, ',', '.');
			return $float_transform;
		} else {
			return $float;
		}
	}


	public function date_transform($data,$today = false,$separador="/"){
		$dataBr = '/^(0[1-9]|[1-2][0-9]|3[0-1])[\/](0[1-9]|1[0-2])[\/](19|20)[0-9]{2}$/';
		$dataSql = '/^(19|20)[0-9]{2}[\-](0[1-9]|1[0-2])[\-](0[1-9]|[1-2][0-9]|3[0-1])$/';
		if(preg_match($dataSql,$data,$retorno)){
			$date = explode('-', $retorno[0]);
			if($separador == ""){
				$date_transform = $date[2].'/'.$date[1].'/'.$date[0];
			}else{
				$date_transform = $date[2].$separador.$date[1].$separador.$date[0];
			}
			return $date_transform;
		}else if(preg_match($dataBr,$data,$retorno)){
			$date = explode('/', $retorno[0]);
			$date_transform = $date[2].'-'.$date[1].'-'.$date[0];
			return $date_transform;
		}elseif($data == "" && $today == true){
			return date("d/m/Y");
		}else{
			return $data;
		}
	}

	public function str_zeros($string,$qtde){
		for($i = strlen($string); $i < $qtde ;$i++){
			$aux .= "0";
		}

		return $aux.$string;
	}


	public function transforms($string) {
		$dataBr = '/^(0[1-9]|[1-2][0-9]|3[0-1])[\/](0[1-9]|1[0-2])[\/](19|20)[0-9]{2}$/';
		$dataSql = '/^(19|20)[0-9]{2}[\-](0[1-9]|1[0-2])[\-](0[1-9]|[1-2][0-9]|3[0-1])$/';
		$floatBr = "/^[-+]?\d{1,3}(\.\d{3})*,\d{2}$/";
		$floatSql = '/^([0-9]*\.[0-9]{2})$/';

		if (preg_match($floatBr, $string, $retorno)) {
			$retorno[0] = str_replace(".", "", $retorno[0]);
			$retorno[0] = str_replace(",", ".", $retorno[0]);
			$float_transform = number_format($retorno[0], 2, '.', '');
			return $float_transform;
		} else if (preg_match($floatSql, $string, $retorno)) {
			$float_transform = number_format($retorno[0], 2, ',', '.');
			return $float_transform;
		} else if (preg_match($dataSql, $string, $retorno)) {
			$date = explode('-', $retorno[0]);
			$date_transform = $date[2].'/'.$date[1].'/'.$date[0];
			return $date_transform;
		} else if (preg_match($dataBr, $string, $retorno)) {
			$date = explode('/', $retorno[0]);
			$date_transform = $date[2].'-'.$date[1].'-'.$date[0];
			return $date_transform;
		} else {
			if (!get_magic_quotes_gpc()) {
				$string = addslashes($string);
			} else {
				$string = $string;
			}
			return $string;
		}
	}

	public function insert($POST, $tabela) {
		$sql= 'SELECT * FROM '.$tabela;
		$resultado = mysql_query($sql)or die(mysql_error());
		
		foreach ($POST as $b=>$n) {

			for ($i = 0; $i < mysql_num_fields($resultado); $i++) {

				$meta = mysql_fetch_field($resultado, $i);
				if ($meta->name != $b) {
					continue;
				} else {
					$campo[] .= $b;

					if ($n == "") {
						$valor[] .= "";

					} else {
						$valor[] .= $n;

					}//else

				}//else
			}//while

		}//foreac


		$insert = implode(", ", $campo);

		foreach ($valor as $post) {
			$value[] .= "'".$this->transforms($post)."'";
		}
		$value = implode(",", $value);

		$query = "INSERT INTO $tabela ($insert) VALUES ($value)";
		
		$res = mysql_query($query);
		if ($res) {
			return mysql_insert_id();
		} else {
			return false;
		}

	}



	public function update($POST, $tabela, $identificador, $id) {
		$resultado = mysql_query('SELECT * FROM '.$tabela);

		foreach ($POST as $b=>$n) {

			for ($i = 0; $i < mysql_num_fields($resultado); $i++) {

				$meta = mysql_fetch_field($resultado, $i);
				if ($meta->name != $b) {
					continue;
				} else {
					$campo[] .= $b;

					if ($n == "") {
						$valor[] .= "";

					} else {
						$valor[] .= $n;

					}//else

				}//else
			}//while

		}//foreach

		for ($i = 0; $i < count($campo); $i++) {
			$set[] .= $campo[$i]."='".$this->transforms($valor[$i])."'";
		}

		@$set = implode(",", $set);
		$query = "UPDATE $tabela SET $set WHERE $identificador='".$id."'";
		
		$res = mysql_query($query)or die(mysql_error());

		if ($res) {
			return true;
		} else {
			return false;
		}

	}
	
	public function delete($id,$identificador,$tabela){
		$res = mysql_query("DELETE FROM $tabela WHERE $identificador=$id"); 
		return $res;
	}

	public function checked($idprimario, $iddochecked, $start = false) {
		if (strpos($idprimario, ",")) {
			$resultados = explode(",", $idprimario);
			if (array_search($iddochecked, $resultados) !== false):
			$checked = "checked='checked'";
			endif;
		} else {
			if ($idprimario === NULL) {

				if ($iddochecked === 1) {
					$checked = "checked='checked'";
				} else if ($start) {
					$checked = "checked='checked'";
				} else {
					$checked = "";
				}
			} else {
				if ($idprimario == $iddochecked) {
					$checked = "checked='checked'";
				} else {
					$checked = "";
				}
			}
		}

		return $checked;
	}

	public function selected($idprimario,$iddoselect){

		if($idprimario !== false){
			if( is_array($idprimario) ){
				if(  in_array($iddoselect,$idprimario)){
					$selected="selected='selected'";
				}else{
					$selected="";
				}
			}else{
				if($idprimario == $iddoselect){
					$selected="selected='selected'";
				}else{
					$selected="";
				}
			}
		}else{
			$selected = "";
		}
		return $selected;
	}



	////////////////////////////// Funcao de Eliakim Ramos /////////////////////////////////

	/**
	 *
	 * @param object $tabela o nome da tabela
	 * @param object $condicao somente a condi��o sem o where (ex: aluno_nome = 'eliakim') obs o parameto $condicao pode ser nulo"
	 * @return
	 */
	public function selecionar ($tabela,$condicao){

		if(!empty($tabela)){

			if(!empty($condicao)){
				$condicao = "where ".$condicao;
			}
				
			$carrega_dados = mysql_query("select * from ".$tabela." ".$condicao);
			while($dados = mysql_fetch_array($carrega_dados)){
				$resultado[] = $dados;
			}
				
			return $resultado;

		}else{
			return false;
		}
	}

	/**
	 * Fun��o que impede scripts maliciosos de sql
	 * @param object $str
	 * @return
	 */
	public function anti_injection($sql)
	{
	    // remove palavras que contenham sintaxe sql
	    $sql = preg_replace(sql_regcase("/(from|select|insert|delete|where|drop table|show tables|#|\*|--|\\\\)/"),"",$sql);
	    $sql = trim($sql);//limpa espa�os vazio
	    $sql = strip_tags($sql);//tira tags html e php
	    $sql = addslashes($sql);//Adiciona barras invertidas a uma string
	    return $sql;
	}


	public function excluir ($tabela,$condicao){
		if(!empty($tabela)){

			if(!empty($condicao)){
				$condicao = "where ".$condicao;
			}
				
			$exclui_dados = mysql_query("delete from ".$tabela." ".$condicao);
				
			return true;

		}else{
			return false;
		}
	}

	function dataEmPortugues($data){
	$dia = substr($data,0,2);
	$mes = substr($data,2, 3);
	$ano= substr($data,6, 8);
		
	switch ($mes) {
		
		case  01:
		    $mes ="Janeiro";
		break;
		case  02:
			$mes = "Fevereiro";
		break;
		case 03:
			$mes = "Mar�o";
		break;
		case 04:
			$mes = "Abril";
		break;
		case 05:
			$mes = "Maio";
		break;
		case 06:
			$mes = "Junho";
		break;
		case 07:
			$mes = "Julho";
		break;
		case 08:
			$mes = "Agosto";
		break;
		case 09:
			$mes = "Setembro";
		break;
		case 10:
			$mes = "Outubro";
		break;
		case 11:
			$mes = "Novembro";
	    break;
	    case 12:
			$mes = "Dezembro";
		break;
	}

 return $dia." de ".$mes." de ".$ano;

}



public function loglogin($iduser,$quem){
		$this->conectar();
		$Post["ip"] = $_SERVER['REMOTE_ADDR'];
		$Post["host"] = gethostbyaddr($_SERVER['REMOTE_ADDR']);
		$Post["dia_hora"] = date("Y-m-d H:i:s");
		$Post["id_user"] = $iduser;
		$Post["adm_cliente_comercial_parceiro"] = $quem;
		$this->insert($Post,"logo_login");
	}
public function listaEstado(){
		$this->conectar();
		$sql = "select * from uf";
		$query = mysql_query($sql)or die(mysql_error());
		while($dados = mysql_fetch_object($query)){
			$result[] = $dados;
		}
		if(!empty($result)){
			return $result;
		}else{
			return false;
		}
	}
	
public function getCidadedouf($iduf){
		$this->conectar();
		$sql ="select * from cidade where uf_codigo =".$iduf." order by cidade_descricao";
		$query = mysql_query($sql)or die(mysql_error());
		while($dados = mysql_fetch_object($query)){
			$result[] = $dados;
		}
		
		if(!empty($result)){
			return $result;
		}else{
			return false;
		}
	}
	
	
public function listacidadeporletra($letra){
	$this->conectar();
	$sql = "select * from cidade where cidade_descricao like '".$letra."%' order by cidade_descricao";
	$query = mysql_query($sql)or die(mysql_error());
	while($cidadesdadoslist = mysql_fetch_object($query)){
		$dadosreturn[] = $cidadesdadoslist; 
	}
	if(!empty($dadosreturn)){
		return $dadosreturn;
	}else{
		return false;
	}
}
	
}
?>