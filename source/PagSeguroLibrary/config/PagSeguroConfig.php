<?php if (!defined('ALLOW_PAGSEGURO_CONFIG')) { die('No direct script access allowed'); }
/*
************************************************************************
PagSeguro Config File
************************************************************************
*/

$PagSeguroConfig = array();

$PagSeguroConfig['environment'] = Array();
$PagSeguroConfig['environment']['environment'] = "production";

$PagSeguroConfig['credentials'] = Array();
$PagSeguroConfig['credentials']['email'] = "brunocbarros@edegraca.com.br";
$PagSeguroConfig['credentials']['token'] = "CC2BD13CB16848EDB8787B3013715B87";

$PagSeguroConfig['application'] = Array();
$PagSeguroConfig['application']['charset'] = "UTF-8, ISO-8859-1"; // UTF-8, ISO-8859-1

$PagSeguroConfig['log'] = Array();
$PagSeguroConfig['log']['active'] = true;
$PagSeguroConfig['log']['fileLocation'] = "logpagseg.txt";

?>