<?php
$strnome = $_POST['nomecompleto'];

$arrayome = explode(" ",$strnome);

if(empty($arrayome[1])){
	echo "digite o segundo nome";
}

?>
