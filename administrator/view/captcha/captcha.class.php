<?php 
session_start();// Inicializa os dados da session
// Definir o header como image/png para indicar que esta página contém dados
// do tipo image->PNG
header("Content-type: image/png");



class Captcha {
    
    /*captcha*/
    public $ImgCaptcha = "";
    public $font = "";
    public $TxtCaptcha = "";
    public $cor = "";
    public $corCaptcha = "";
    public $rand_cores = "";
    public $rand_keys = "";

    /*Cores*/
    public $cinza = "";
    public $cinza_escuro = "";
    public $vermelho = "";
    public $azul = "";
    public $verde = "";
    public $rosa = "";
    public $preto = "";
    public $marrom = "";
    public $laranja = "";
    public $explode_cor = "";
    public $cor_1 = "";
    public $cor_2 = "";
    public $cor_3 = "";

    /*imagem de fundo do captcha*/
    public $rand_imagem = "";
    public $rand_keys_imagens  = "";
    public $imagem = "";



function __construct() {


    $this->rand_imagem  = array("captcha.png","captcha2.png","captcha3.png","captcha4.png");
    // pega aleatoriamente as imagens
    $this->rand_keys_imagens   = array_rand($this->rand_imagem, 4);//pega aleatoriamente as imagens
    $this->imagem = $this->rand_imagem[$this->rand_keys_imagens[rand(0,3)]];//imagens entre o valor 0 e 4

    // Criar um novo recurso de imagem a partir de um arquivo
    $this->ImgCaptcha = imagecreatefrompng("images/$this->imagem");
    //Carregar uma nova fonte
    $this->font= imageloadfont("fonts/arial.gdf");
    // Criar o texto para o captcha
    $this->TxtCaptcha = substr(md5(uniqid('')),-9,9);

    // Guardar o texto numa variavel session
     $_SESSION['captcha'] = $this->TxtCaptcha;

     /*Cores da fonte se quiser adicione mais cores*/
    $this->cinza = "0xF8,0xF8,0xF8" ;
    $this->cinza_escuro ="0xCC,0xCC,0xCC";
    $this->vermelho ="0xFF,0x00,0x00";
    $this->azul = "0x0F,0x93,0xFF";
    $this->verde = "0x00,0x66,0x00";
    $this->rosa = "0xFF,0x1A,0x98";
    $this->preto ="0x00,0x00,0x00";
    $this->marrom = "0xDC,0x91,0x3D";
    $this->laranja = "0xFF,0x8C,0x24";


    $this->rand_cores  = array(// array com as cores
                               $this->vermelho,
                               $this->azul,
                               $this->verde,
                               $this->rosa,
                               $this->preto,
                               $this->marrom,
                               $this->laranja
                               );

    $this->rand_keys   = array_rand($this->rand_cores, 2);// pega aleatoriamente as cores
    $this->cor = $this->rand_cores[$this->rand_keys[rand(0, 1)]];//cores entre o valor 0 e 1
    $this->explode_cor = explode(',',$this->cor);// separamos os dados das cores
    $this->cor_1 = $this->explode_cor[0];
    $this->cor_2 = $this->explode_cor[1];
    $this->cor_3 = $this->explode_cor[2];

    // Indicar a cor para o texto
    $this->corCaptcha = imagecolorallocate($this->ImgCaptcha,$this->cor_1,$this->cor_2,$this->cor_3);

    // Escrever a string na cor escolhida   
    imagestring($this->ImgCaptcha,$this->font,3,0,$this->TxtCaptcha,$this->corCaptcha);

    // Mostrar a imagem captha no formato PNG.
    // Outros formatos podem ser usados com imagejpeg, imagegif, imagewbmp, etc.
    imagepng($this->ImgCaptcha);

    // Liberar memória
    imagedestroy($this->ImgCaptcha);

    }
    }

   $Captcha = new Captcha();
?>