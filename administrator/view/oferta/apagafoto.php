<?php
require_once("../../models/Base.php");
require_once("../../models/Oferta.php");

$ofertaImagem = new Oferta();
$id_ofertaImagem = $ofertaImagem->anti_injection($_POST['idOfertaImagem']);
if($id_ofertaImagem){
	$respOfertaImagem = $ofertaImagem->getOfertaImagem($id_ofertaImagem,"id_oferta_image");
	if(file_exists("../../uploads/".$dados['image'])){
		unlink("../../uploads/".$respOfertaImagem['image']);
	}
	$ofertaImagem->excluirOfertaImagem($respOfertaImagem['id_oferta_image'],"id_oferta_image");
}
$imagens = $ofertaImagem->listarOfertaImagem(" and id_oferta=".$respOfertaImagem['id_oferta']);
if($imagens){
	foreach($imagens as $dados){
		if(file_exists("../../uploads/".$dados['image'])){	
	?>
		<img src="uploads/<?php echo $dados['image'] ?>" width="100px"
			height="100px">
		<img src="img/excluir.gif" border="0" id="excluir" title="Excluir Imagem" style="cursor: pointer"
			onclick="javascript:apagarfoto('<?php echo $dados['id_oferta_image']?>');" />
	<?
		}
	}
}else{
	echo "N&atilde;o existe imagens Cadastradas!";
}
?>