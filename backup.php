<?php 

$dbname = "pechinch_pechincha"; 
mysql_connect("cpmy0008.servidorwebfacil.com","pechinch_sis","#pechincha#") or die(mysql_error());  

$nomearquivo = "backup-".date("d-m-Y-H-i").".sql";
mysql_select_db($dbname) or die(mysql_error()); 

$back = fopen("backup/".$nomearquivo,"w"); 
// Pega a lista de todas as tabelas 
$res = mysql_list_tables($dbname) or die(mysql_error()); 
	while ($row = mysql_fetch_row($res)) { 
		$table = $row[0]; // cada uma das tabelas $table == "cliente" || $table == "administrador" || $table == "comercial" || $table == "oferta" || $table == "oferta_cliente" || $table == "oferta_image" || $table == "empresa" ||
		$res2 = mysql_query("SHOW CREATE TABLE $table"); 
			while ( $lin = mysql_fetch_row($res2)){ // Para cada tabela 
				if($table == "uf"){
					//fwrite($back,"\n#\n# Criação da Tabela : $table\n#\n\n");
					//fwrite($back,"$lin[1] ;\n\n#\n# Dados a serem incluídos na tabela\n#\n\n");
						$res3 = mysql_query("SELECT * FROM $table"); 
							while($r=mysql_fetch_row($res3)){ // Dump de todos os dados das tabelas 
								$sql="INSERT INTO $table VALUES ('"; 
								$sql .= implode("','",$r); 
								$sql .= "');\n"; 
								//fwrite($back,$sql);
							} 
				}
			} 
	}
	fclose($back);
?> 