<?php

class Upload
 {
   var $tipo;
   var $nome;
   var $tamanho;
   var $error;
 
   public function Upload()
   {
   //S� cria o objeto
   }
 
   public function UploadArquivo($arquivo, $pasta, $tipos)
   { 
     if(isset($arquivo))
     {
       $arquivoPermitido= false;
       $nomeOriginal = $arquivo['name']; 
       //$nomeFinal = md5($nomeOriginal . date("dmYHis"));
       $nomeFinal = date("dmYHis")."_".$nomeOriginal;
       $tipo = strrchr($arquivo['name'],".");
       $tamanho = $arquivo['size'];
 
       for($i=0;$i<=count($tipos);$i++)
       { 
         
         if($tipos[$i] == $tipo)
         {
           $arquivoPermitido=true;
         }
       }
 
       if($arquivoPermitido==false)
       {
         $this->error = "Arquivo n�o permitido";
         return false;
         exit;
       } 		
       if (move_uploaded_file($arquivo['tmp_name'], $pasta . $nomeFinal))
       { 
         $this->nome= $nomeFinal;
         $this->tipo=$tipo;
         $this->tamanho=number_format($arquivo['size']/1024, 2) . "KB";
         return true; 
       }else{ 
		 $this->error = "Erro no upload do Documento";       
         return false;
       } 
     }
   } 
 }
?>
