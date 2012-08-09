<?php  
session_start();

class Newsletter extends Base {
	
   public function Newsletter(){
   	
   }	
    
   public function viewHtml($nomeconvidado,$idconvidado){
    	
   	
	   	$arr[1] = "Janeiro";
		$arr[2] = "Fevereiro";
		$arr[3] = "Mar�o";
		$arr[4] = "Abril";
		$arr[5] = "Maio";
		$arr[6] = "Junho";
		$arr[7] = "Julho";
		$arr[8] = "Agosto";
		$arr[9] = "Setembro";
		$arr[10] = "Outubro";
		$arr[11] = "Novembro";
		$arr[12] = "Dezembro";
   		
   		$sql = "select * from cadastrofesta ";
   		$query = mysql_query($sql);
   		$dados =  mysql_fetch_assoc($query);
  		if($dados){
   		/*foreach ($noticias as $noticia){
   		$outras_noticias .= '<tr>
                  <td valign="top"></td>
                  <td valign="top" style="padding:10px 15px 10px 15px; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; color: #666666; font-weight: normal;" >'.$not->Not_Titulo.'<br>
                      <a href="http://www.brascomti.com.br/craes/interna/noticiaCompleta.php?a='.$noticia['id'].'">'.$noticia['titulo'].'</a>
                  	  <p>'.$noticia['chamada'].'</p>    
                  </td>
                  </tr>';
		}*/
   		
   		
   		$fp = fopen("../convite/conviteLayout.html",'r+');
		$html = file_get_contents("../convite/conviteLayout.html");
		$sqlfesta = " select * from unidades where id_unidades=".$dados['id_unidade'];
		$queryFesta = mysql_query($sqlfesta); 
		$festa = mysql_fetch_assoc($queryFesta);
		
		$html = str_replace('#data#',$this->date_transform($dados['data']),$html);
		/*$html = str_replace('#mes#',$arr[date("n")],$html);
		$html = str_replace('#ano#',date("Y"),$html);
		*/
		$html = str_replace('#nome#',$nomeconvidado,$html);
		//$html = str_replace('#imagem#',$imagem,$html);
		//$html = str_replace('../img',"../../img",$html);
		$html = str_replace('#id#',$idconvidado,$html);
		$html = str_replace('#nomeaniversa#',$dados['nome_aniver'],$html);
		$html = str_replace('#obs#',$dados['observacao'],$html);
		$html = str_replace('#buffet#',$festa['casa'],$html);
		$html = str_replace('#logradouro#',$festa['logradouro'],$html);
		$html = str_replace('#numero#',$festa['numero'],$html);
		$html = str_replace('#bairro#',$festa['bairro'],$html);
		$html = str_replace('#telefone#',$festa['telefone'],$html);
		$html = str_replace('#horario#',$dados['horario'],$html);		
		//$html = str_replace('#cod_not_destaque#',$destaques[0]['id'],$html);
		//$html = str_replace('tablinks',$table,$html);
		
		fclose($fp);
		
		$fp2 = fopen("../convite/conviteEnvio.html",'w');
		fwrite($fp2,$html);
		return $html;
  		}
   }
   
   
   
   public function enviarNewsletter(){
   		$this->conectar();
   		$tabela = "cliente";
   		$sql = "SELECT * FROM cliente WHERE enviado='0' ";
   		$query = mysql_query($sql);
   		echo mysql_error();
   		$destinatario = mysql_fetch_assoc($query);
   		if(empty($destinatario)){
	   		$tabela = "baseemail";
	   		$sql = "SELECT * FROM baseemail WHERE enviado='0' ";
	   		$query = mysql_query($sql);
	   		echo mysql_error();
   		}
   		$destinatario = mysql_fetch_assoc($query);
   		if(empty($destinatario)){
	   		$tabela = "newsletter";
	   		$sql = "SELECT * FROM baseemail WHERE enviado='0' ";
	   		$query = mysql_query($sql);
	   		echo mysql_error();
   		}
   		 
   		$sucesso =0;
   		$falha = 0;
   		while($destinatario = mysql_fetch_assoc($query)){
   			
	   		try {
		   		$mail = new PHPMailer(true);

				$mail->SMTPAuth = true;
				$mail->CharSet = "iso-8859-1";
				$mail->From = "naoresponda@edegraca.com.br"; 
				$mail->FromName = "É de graça - Compra Coletiva"; // Nome de quem envia o email
				$mail->AddAddress($destinatario['email'],$destinatario['nome']); // Email e nome de quem receberÃ¡
				//$mail->AddAddress("forrodobarao@hotmail.com"); // Email e nome de quem receberÃ¡
				//$mail->AddAddress("wd.andre@gmail.com"); // Email e nome de quem receberÃ¡
				
				//$mail->WordWrap = 50; // Definir quebra de linha 
				
				$mail->Subject = " Ultimas horas para você aproveitar. No  Spettus Boa Viagem Recife, Rodízio completo Almoço ou Jantar de até R$ 88,80 por R$ 49,90 É de Graça!!!! ";

		   		$mail->MsgHTML("
<html>
    <head>
        <title>É de Graça!</title>
        <meta content='text/html; charset=utf-8' http-equiv='Content-Type' />
    </head>
    <body>
        <table border='1' cellspacing='0' bordercolor='#000000' cellpadding='0' width='600' align='center'>
            <tbody>
                <tr>
                    <td>
                    <table border='0' cellspacing='0' cellpadding='0' width='600' align='center'>
                        <tbody>
                            <tr>
                                <td align='center'><a target='_blank' href='http://www.edegraca.com.br'><img border='0' alt='� de gra�a' width='760' height='760' src='http://www.edegraca.com.br/newsletter/newsletter6.jpg' /></a></td>
                            </tr>
                            					
			  <tr>
			    <td align=center><br />
				<font size=2 face=arial color=#000000>
				O é de graça respeita a sua privacidade e é contra o spam na rede.<br>" .
				"Se você não deseja mais receber nossos e-mails, cancele sua inscrição <a href='http://www.edegraca.com.br/removerNews.php?cliente=".$destinatario['id']."' target=_blank>aqui</a>
				</td>
			  </tr>								
                        </tbody>
                    </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </body>
</html>	
               ");

				$mail->IsHTML(true); // send as HTML
				$mail->IsMail();
			    $maximo = "450";
		   		/*if(date("H:i") >= "05:30"){
		   			$maximo = "199";
		   		}*/
				if($sucesso == $maximo){
					
					exit;
					die;
					
				}
			   	$mail->Send();
			   	
			   	$mensagem[]['destinatario'] = $destinatario['email']."[".$destinatario['email']."]"; 
				$mensagem[]['mensagem'] 	= "<font color='green'>Mensagem Enviada</font>";
				$mensagem[]['status']       = 1;
				
				$enviado['enviado'] = 1;
				if(!empty($tabela)){
					$this->update($enviado,$tabela,'id',$destinatario['id']);
				}else{
					$sql = "SELECT * FROM cliente WHERE enviado='0' ";
			   		$query = mysql_query($sql);
			   		echo mysql_error();
			   		if(mysql_num_rows($query) == 0 ){
				   		$this->update($enviado,"baseEmail",'id',$destinatario['id']);
			   		}else{
						$this->update($enviado,"cliente",'id',$destinatario['id']);
			   		}
				}
				
				echo $sucesso++;
			} catch (phpmailerException $e) {
				$mensagem[]['destinatario'] = $destinatario['email']."[".$destinatario['email']."]"; 
				echo $mensagem[]['mensagem'] 	= "<font color='red'>".$e->errorMessage()."</font>";
				$mensagem[]['status']       = 0;
				$enviado['enviado'] = 0;
				//$this->update($enviado,'convidados','id_convidado',$destinatario['id_convidado']);
				$falha++;
			}
   		}
   		
   		$_SESSION['alert'] =$this->resumoDeEnvioDeNewsletter($sucesso,$falha);
   		return $mensagem;   	
   }
   
   function resumoDeEnvioDeNewsletter($sucesso,$falha){
   	  
   	  
   	  return "Convites enviados com sucesso: ".$sucesso." <br> falhas: ".$falha;
   	  
   }  	
}
?>