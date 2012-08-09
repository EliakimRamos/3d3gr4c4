<meta http-equiv="refresh" content="3600; URL=edegracanews.php">
<?php
include 'administrator/models/Base.php';
include 'Phpmailer.php';
include 'Newsletter.php';
include 'Smtp.php';

			
				$newsletter =  new Newsletter();
	            $retornos = $newsletter->enviarNewsletter();
			

echo'<meta http-equiv="refresh" content="3600; URL=edegracanews.php">';


?>